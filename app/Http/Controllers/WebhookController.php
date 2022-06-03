<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mollie\Laravel\Facades\Mollie;

class WebhookController extends Controller
{
    public function handle(Request $request) {

        $id = $request->input('id');


        $payment = Mollie::api()->payments()->get($id);


        if ($payment->isPaid() && ! $payment->hasRefunds() && ! $payment->hasChargebacks()) {

            $order_id = $payment->metadata->order_id;
            $order = Order::findOrFail($order_id);
            $order->status = 'paid';
            $order->save();

            Log::alert('Payment completed', [
                'id' => $payment->id,
                'amount' => $payment->amount,
                'description' => $payment->description,
            ]);

        } elseif ($payment->isOpen()) {
            /*
            * The payment is open.
            */
        } elseif ($payment->isPending()) {
            /*
            * The payment is pending.
            */
        } elseif ($payment->isFailed()) {
            /*
            * The payment has failed.
            */
        } elseif ($payment->isExpired()) {
            /*
            * The payment is expired.
            */
        } elseif ($payment->isCanceled()) {
            /*
            * The payment has been canceled.
            */
        } elseif ($payment->hasRefunds()) {
            /*
            * The payment has been (partially) refunded.
            * The status of the payment is still "paid"
            */
        } elseif ($payment->hasChargebacks()) {
            /*
            * The payment has been (partially) charged back.
            * The status of the payment is still "paid"
            */
        }
    }
}
