<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;

class AdminTicketCheckout extends Component
{

    public $event;
    public $products;
    public $cart;

    public function getProducts(){
        $this->products = Event::find($this->event)->ticketProducts;
    }
    public function render()
    {
        return view('livewire.admin-ticket-checkout');
    }

    public function updateCart($ticketProductId, $ticketPriceId, $amount){
        if(!isset($this->cart[$ticketProductId][$ticketPriceId])){
            $this->cart[$ticketProductId][$ticketPriceId] = 0;
        }
        $this->cart[$ticketProductId][$ticketPriceId] += $amount;
    }
}
