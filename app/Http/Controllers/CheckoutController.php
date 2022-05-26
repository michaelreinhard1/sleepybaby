<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Mollie\Laravel\Facades\Mollie;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    // checkout
    public function checkout( Request $request )
    {

        if(env('APP_ENV') == 'local') {
            $webhookUrl = env('MOLLIE_WEBHOOK_URL');
        } else {
            $webhookUrl = route('webhooks.mollie');
        }

        $cart = Cart::session(1);

        $total = $cart->getTotal();

        $total = number_format($total, 2, '.', '');

        Log::alert('total: ' . $total);

        // Create a new order and save it to the database
        $order = new Order();
        $order->total = Cart::getTotal();
        $order->name = $request->name;
        $order->remarks = $request->remarks;
        $order->status = 'open';
        $order->save();

        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $total // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => // Order on current date and time
                "Order #{$cart->getContent()->first()->id} on " . date("Y-m-d H:i:s"),
            "redirectUrl" => route('order.success'),
            "webhookUrl" => $webhookUrl,
            "metadata" => [
                "order_id" => $order->id, // Pass the order id to webhookUrl
                "order_name" => $order->name,
            ],
        ]);

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);

    }

    public function success()
    {
        return view('order-success');
    }
}
