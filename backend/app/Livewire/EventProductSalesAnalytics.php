<?php

namespace App\Livewire;

use Livewire\Component;

class EventProductSalesAnalytics extends Component
{
    public $events;
    public $products;
    
    public function render()
    {
        return view('livewire.event-product-sales-analytics');
    }

    public function mount(){
        $this->events = collect();
        $this->products = collect();
    }
}
