<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Order;
use Livewire\Attributes\Url;
use Livewire\Component;

class EventOrderProtocoll extends Component
{

    public Event $event;
    public $headers = [];
    public array $expanded = [];
    #[Url(as: 'sortBy')]
    public $sortByCol = "id";
    #[Url(as: 'asc')]
    public $sortByAsc = true;
    public $orders  = [];

    public function mount(Event $event){
        $this->event = $event;
        $this->headers = [
            ['key' => 'id', 'label' => 'ID'],
            ['key' => 'created_at', 'label' => 'Zeitstempel', 'format' => ['date', 'd.m.Y H:i:s']],
            ['key' => 'total', 'label' => 'Summe', 'format' => ['currency', '2,.', '€']],
            ['key' => 'gateway', 'label' => 'Gateway'],
        ];
        $this->getSortedOrders();
    }

    public function sortByColumn($column){
        if($this->sortByCol == $column){
            $this->sortByAsc = !$this->sortByAsc;
        }else{
            $this->sortByCol = $column;
            $this->sortByAsc = true;
        }

        $this->getSortedOrders();
    }

    public function getSortedOrders(){
        $this->orders = $this->sortByAsc ?
            $this->event->orders->sortBy(fn($order, $key) => $this->orderSortClosure($this->sortByCol, $order)) :
            $this->event->orders->sortByDesc(fn($order, $key) => $this->orderSortClosure($this->sortByCol, $order));
    }

    public function orderSortClosure($column, $order){
        switch($column){
            case 'gateway':
                $member_name = $order->getMemberNameIfPresent();
                return isset($member_name) ? $order->gateway . "-" . $member_name : $order->gateway;
            case 'total':
                return $order->total;
            case 'id':
                return $order->id;
            case 'created_at':
                return $order->created_at;
        }
    }

    public function render()
    {
        return view('livewire.event-order-protocoll');
    }
}
