<?php

namespace App\Livewire;

use App\Services\Analytics;
use Livewire\Component;

class EventProductSalesAnalytics extends Component
{
    public $events;
    public $products;
    public $gateways;
    public $selectableEvents;
    public $selectableProducts;
    public $selectableGateways;
    public $cellclasses = "bg-slate-100 p-4 rounded";

    public $stats;

    
    public function render()
    {
        return view('livewire.event-product-sales-analytics');
    }

    public function mount(){
        $this->events = collect();
        $this->products = collect();
        $this->stats = collect();
        $this->selectableGateways = $this->selectableEvents->flatMap(function($event){
            return $event->orders->map(function($order){
                return $order->gateway;
            });
        })->unique();
        $this->gateways = collect($this->selectableGateways)->mapWithKeys(
            function ($item) {
                return [$item => true];
            }
        );
    }

    public function addEvent($id){

        $event = $this->selectableEvents->firstWhere("id", $id);

        if($event){
            $this->events->push($event);
            $this->selectableEvents = $this->selectableEvents->reject(function ($event) use ($id) {
                return $event->id == $id;
            });
        }

        $this->recalculateStats();
    }
    public function addProduct($id)
    {
        $product = $this->selectableProducts->firstWhere("id", $id);

        if ($product) {
            $this->products->push($product);
            $this->selectableProducts = $this->selectableProducts->reject(function ($product) use ($id) {
                return $product->id == $id;
            });
        }

        $this->recalculateStats();

    }

    public function recalculateStats(){
        $gw = $this->gateways->filter(function($gateway){
            return $gateway;
        })->keys();
        $this->stats = Analytics::multiEventProductSaleAnalytics($this->events, $this->products, $gw->toArray()); 
    }
}
