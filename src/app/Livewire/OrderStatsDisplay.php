<?php

namespace App\Livewire;

use Livewire\Component;

class OrderStatsDisplay extends Component
{
    public $statsByGateway;
    public $orderCount = 0;
    public $itemCount = 0;
    public $bestsellers = [];
    public $money = 0;
    public $gateways = [];
    public $selectedGateways = [];
    public $avgTotal = 0;

    public function render()
    {
        return view('livewire.order-stats-display');
    }

    public function mount($orderStatsByGateway)
    {
        $this->statsByGateway = $orderStatsByGateway;
        $this->gateways = $orderStatsByGateway->keys();
        $this->selectedGateways = collect($this->gateways)->mapWithKeys(
            function ($item) {
                return [$item => true];
            }
        );
        $this->calcStats();
    }

    public function calcStats()
    {
        $filteredStats = $this->statsByGateway->filter(function ($stats, $gateway) {
            return isset($this->selectedGateways[$gateway]) && $this->selectedGateways[$gateway] == true;
        });

        $this->money = $filteredStats->sum("total");
        $this->orderCount = $filteredStats->sum("orders");
        $this->avgTotal = $filteredStats->avg("avg_total");
        $this->itemCount = $filteredStats->sum("items");
        $this->bestsellers = collect($filteredStats->map(function ($stats) {
            return $stats["bestseller"];
        })->reduce(function ($carry, $set) {
            foreach ($set as $productName => $qty) {
                if (isset($carry[$productName])) {
                    $carry[$productName] += $qty;
                } else {
                    $carry[$productName] = $qty;
                }
            }
            return $carry;
        }));
    }

    public function selectedGatewayCount(){
        return collect($this->selectedGateways)->filter(function($gateway){ return $gateway; })->count();
    }
}
