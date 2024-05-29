<?php

namespace App\Livewire;

use Livewire\Component;

class TicketAdminForm extends Component
{
    public $name = "12";
    public $tixAvailable = 0;
    public $pricings = array();
    public $permits = array();
    
    public function save(){
        dd("save");
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