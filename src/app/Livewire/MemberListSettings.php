<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Collection;

class MemberListSettings extends Component
{
    public Event $event;

    public Collection $list;
    public $enabled = false;
    public $somethingChanged = false;

    public function save(){
        if($this->enabled){
            $this->list = $this->list->filter(function (String $value) {
                return !empty($value);
            });
            $this->event->member_list = $this->list->isNotEmpty() ? $this->list : null;
        }else{
            $this->event->member_list = null;
        }
        
        $this->enabled = isset($this->event->member_list);
        $this->list = $this->enabled ? $this->event->member_list : collect([""]);
        $this->somethingChanged = false;

        $this->event->update();
        session()->flash("success_message", "Daten wurden erfolgreich gespeichert!");
    }

    public function mount(Event $event){
        $this->list = collect([""]);
        $this->event = $event;
        $this->enabled = isset($event->member_list);
        if($this->enabled){
            $this->list = $event->member_list;
        }
    }

    public function render()
    {
        return view('livewire.member-list-settings');
    }

    public function addMember(){
        $this->list[] = "";
        $this->somethingChanged = true;
    }

    public function removeMember(int $index){
        unset($this->list[$index]);
        if ($this->list->isEmpty()) {
            $this->enabled = false;
            $this->list = collect([""]);
        }
        $this->somethingChanged = true;
    }

    public function inputChanged(){
        $this->somethingChanged = true;
    }

    public function toggleEnabled(){
        $this->enabled = !$this->enabled;
        if($this->enabled && empty($this->list)){
            return;
        }
        $this->somethingChanged = true;
        
    }
}
