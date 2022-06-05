<?php

namespace App\Mail;

use App\Models\Article;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var \App\Models\Order
     */
    public $order;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Order  $order
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;

        $this->order->articles = Article::whereIn('id', $order->articles)->get();

        $this->order->wishlist_name = Wishlist::find($order->wishlist_id)->name;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('Thank you for your order') . ' ' . $this->order->wishlist_name . '!')->view('emails.order-confirmation')->with([
            'order' => $this->order,
            'message' => $this
        ]);
    }
}
