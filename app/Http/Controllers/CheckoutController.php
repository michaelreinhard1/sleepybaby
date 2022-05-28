<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\Wishlist;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Mollie\Laravel\Facades\Mollie;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function checkout( Request $request )
    {


        if(env('APP_ENV') == 'local') {
            $webhookUrl = 'https://e2a3-2a02-1811-2519-a000-2908-da2-ccf8-8ecd.eu.ngrok.io/user/webhooks/mollie';
        } else {
            $webhookUrl = route('user.webhooks.mollie');
        }
        $user_id = session()->get('user_id');
        $cart = Cart::session($user_id);

        $total = $cart->getTotal();

        $total = number_format($total, 2, '.', '');

        Log::alert('total: ' . $total);

        $code = $request->session()->get('code');

        // Create a new order and save it to the database
        $order = new Order();
        $order->total = Cart::getTotal();
        $order->name = $request->name;
        $order->remarks = $request->remarks;
        $order->articles = json_encode(Cart::getContent()->keys());
        $order->code = $code;
        $order->status = 'open';
        $order->save();

        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $total // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => // Order on current date and time
                "Order #{$cart->getContent()->first()->id} on " . date("Y-m-d H:i:s"),
            "redirectUrl" => route('user.order.success'),
            "webhookUrl" => $webhookUrl,
            "metadata" => [
                "order_id" => $order->id, // Pass the order id to webhookUrl
                "order_name" => $order->name,
            ],
        ]);

        $wishlist = Wishlist::where('code', $code)->first();

        $wishlist->articles = json_decode($wishlist->articles);

        $order->articles = json_decode($order->articles);

        $wishlist->articles = array_values(array_diff($wishlist->articles, $order->articles));

        $wishlist->articles = json_encode($wishlist->articles);

        // $wishlist->save();

        $this->sendEmail($order);

        // redirect customer to Mollie user.checkout page
        return redirect($payment->getCheckoutUrl(), 303);

    }

    // sendEmail
    public function sendEmail( $order )
    {

        // Send an email to user from the wishlist
        Mail::to('xulobeats@gmail.com')->send(new OrderMail($order));

    }

    public function success()
    {
        $user_id = session()->get('user_id');
        Cart::session($user_id)->clear();
        return view('user.order-success');
    }
}
