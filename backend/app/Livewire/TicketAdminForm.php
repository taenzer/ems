<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate; 
use App\Models\TicketProduct;

class TicketAdminForm extends Component
{

    public TicketProduct $product;
    
    #[Validate('required')]
    public $name;
    // #[Validate('required')]
    public $ticket_design_id;
    public $tixAvailable;
    public $pricings = array();
    public $permits = array();
    public $exists = false;
    public $editable = false;
    
    public function save(){
        
        $this->validate(); 
        $this->product->name = $this->name;
        $this->product->tixAvailable = $this->tixAvailable;
        $this->product->ticket_design_id = $this->ticket_design_id;
        $this->product->save();

        $this->product->prices()->whereNotIn('id', array_keys($this->pricings))->delete();

        foreach($this->pricings as $pricing){
            $this->product->prices()->firstOrCreate($pricing);
        }

        return redirect()->route("tickets.products.show", $this->product->id);
    }

    public function mount($product = null){

        if(isset($product)){
            $this->product = $product;
            $this->name = $product->name;
            $this->tixAvailable = $product->tixAvailable;
            $this->ticket_design_id = $product->ticket_design_id;
            $this->pricings = $product->prices->mapWithKeys(function($pricing){
                return [$pricing->id => $pricing];
            })->toArray();
            $this->permits = $product->permits()->with("event")->get()->mapWithKeys(function($permit){
                return [$permit->id => $permit];
            });

        }else{
            $this->product = new TicketProduct();
        }
        

    }

    public function addPermit(\App\Models\Event $event){
        $permit = $this->product->permits()->firstOrCreate(["event_id" => $event->id]);
        $this->permits[$permit->id] = $permit;
    }
    
    public function removePermit($index){
        $this->permits[$index]->delete();
        unset($this->permits[$index]);
    }
    public function removePricing($index){
        unset($this->pricings[$index]);  
    }
    public function addPricing($category = "", $price = 0){
        $this->pricings["new-".uniqid()] = array("category" => $category, "price" => $price);
    }
    public function render()
    {
        return view('livewire.ticket-admin-form');
    }
}