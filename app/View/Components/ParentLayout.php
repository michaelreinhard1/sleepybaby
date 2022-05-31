<?php

namespace App\View\Components;

use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\View\Component;

class ParentLayout extends Component
{
    /**
     * Create a new component instance.
     * @param  \App\Models\Order  $order
     * @return void
     */



    public $orders;

    public function __construct(Order $orders, Wishlist $wishlist)
    {

        $this->wishlist = $wishlist->where('user_id', auth()->user()->id)->get('id');

        $this->orders = $orders->whereIn('wishlist_id', $this->wishlist)->get();

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        return view('layouts.parent', [
            'orders' => $this->orders
        ]);
    }
}
