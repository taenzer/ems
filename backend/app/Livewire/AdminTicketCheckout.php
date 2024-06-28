<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\TicketOrder;
use App\Models\Ticket;

class AdminTicketCheckout extends Component
{

    public $event;
    public $products;
    public $cart;

    public function getProducts()
    {
        $this->products = Event::find($this->event)->ticketProducts;
    }
    public function render()
    {
        return view('livewire.admin-ticket-checkout');
    }

    public function getCartItemCount($ticketProductId, $ticketPriceId)
    {
        return isset($this->cart[$ticketProductId][$ticketPriceId]) ? $this->cart[$ticketProductId][$ticketPriceId] : 0;
    }

    public function calcTicketProductTotal($ticketProductId)
    {
        return $this->products->firstWhere("id", $ticketProductId)->prices->map(
            function ($price) use ($ticketProductId) {
                return isset($this->cart[$ticketProductId][$price->id]) ? $this->cart[$ticketProductId][$price->id] * $price->price : 0;
            }

        )->sum();
    }

    public function calcOrderTotal()
    {
        return isset($this->products) ? $this->products->map(function ($product) {
            return $this->calcTicketProductTotal($product->id);
        })->sum() : 0;
    }

    public function updateCart($ticketProductId, $ticketPriceId, $amount)
    {
        if (!isset($this->cart[$ticketProductId][$ticketPriceId])) {
            $this->cart[$ticketProductId][$ticketPriceId] = 0;
        }
        $this->cart[$ticketProductId][$ticketPriceId] += $amount;
        if ($this->cart[$ticketProductId][$ticketPriceId] < 0) {
            $this->cart[$ticketProductId][$ticketPriceId] = 0;
        }
    }

    public function createOrder()
    {
        $order = new TicketOrder();
        $order->gateway = "EMS-ADMIN";
        $order->total = $this->calcOrderTotal();
        $order->user_id = auth()->user()->id;
        $order->save();

        foreach ($this->cart as $ticketProductId => $ticketPrices) {
            foreach ($ticketPrices as $ticketPriceId => $qty) {
                for ($i = 0; $i < $qty; $i++) {
                    $order->tickets()->create([
                        "ticket_product_id" => $ticketProductId,
                        "ticket_price_id" => $ticketPriceId,
                        "secret" => Ticket::generateSecret(),
                    ]);
                }
            }
        }
        return redirect(route("tickets.orders.show", ["order" => $order]));
    }
}