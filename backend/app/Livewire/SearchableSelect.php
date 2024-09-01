<?php

namespace App\Livewire;

use Livewire\Component;

class SearchableSelect extends Component
{
    public $title = "Auswählen";
    public $selectables;
    public $open = false;
    public $maxVisible = 2;
    public $searchBy = "";

    public function mount(){
       
    }
    public function render()
    {
        return view('livewire.searchable-select');
    }

    public function getSelectables(){
        $searchBy = $this->searchBy;
        return $this->selectables->filter(function($seachable) use ($searchBy){
            return str_contains(strtolower($seachable), strtolower($searchBy));
        })->take($this->maxVisible);
    }

    public function toggleSelection(){
        $this->open = !$this->open;
    }

    public function select($selected){
        $this->dispatch("select", selected: $selected);
        $this->closeSelect();
    }
    public function closeSelect()    {
        $this->open = false;
        $this->searchBy = "";
    }
}
