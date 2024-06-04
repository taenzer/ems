<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate; 
use App\Models\TicketProduct;

class TicketAdminForm extends Component
{
    #[Validate('required')]
    public $name;
    // #[Validate('required')]
    public $ticket_design_id;
    public $tixAvailable;
    public $pricings = array();
    public $permits = array();
    
    public function save(){
        $this->validate(); 
        $ticket = TicketProduct::create([
            "name" => $this->name,
            "tixAvailable" => $this->tixAvailable,
            "ticket_design_id" => $this->ticket_design_id
        ]);

        foreach($this->pricings as $pricing){
            $ticket->prices()->create($pricing);
        }

        foreach($this->permits as $permit){
            $ticket->permits()->create(["event_id" => $permit->id]);
        }

        return redirect()->route("tickets.products.show", $ticket->id);
    }

    public function mount(){

    }

    public function addPermit(\App\Models\Event $event){
        $this->permits[$event->id] = $event;
    }
    
    public function removePermit($index){
        unset($this->permits[$index]);
    }
    public function removePricing($index){
        unset($this->pricings[$index]);  
    }
    public function addPricing($category = "", $price = 0){
        $this->pricings[uniqid()] = array("category" => $category, "price" => $price);
    }
    public function render()
    {
        return view('livewire.ticket-admin-form');
    }
}