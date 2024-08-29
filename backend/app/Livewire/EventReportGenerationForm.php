<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\TicketOrder;
use App\Models\User;

use Livewire\Component;

class EventReportGenerationForm extends Component
{
    public $reportType = "sales";
    public $selectedGateways = [];
    public $selectedUser = "all";

    public $event;
    public $gateways = [];
    public $users = [];

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->reportTypeChanged();
    }
    public function render()
    {
        return view('livewire.event-report-generation-form');
    }

    public function generateReport()
    {
        $this->redirect(route("events.report.create", [
            "event" => $this->event,
            "report-type" => $this->reportType,
            "gateways" => collect($this->selectedGateways)->filter(function ($gateway) {
                return $gateway;
            })->keys()->toArray(),
            "user" => $this->getSelectedUser()
        ]));
    }

    protected function getSelectedUser()
    {
        if (!isset($this->selectedUser) || $this->selectedUser == "all") {
            return null;
        }
        return $this->selectedUser;
    }

    public function reportTypeChanged()
    {
        $this->reloadGateways();
        $this->reloadUsers();
        $this->selectedGateways = [];
    }

    public function reloadUsers()
    {
        $event = $this->event;
        if ($this->reportType == "sales") {
            // Get Gateways of Orders
            $this->users = $event->sellers;
        } else {
            // Get Gateways of TicketOrders
            $this->users = User::whereHas('ticketOrders.tickets.permits', function ($query) use ($event) {
                $query->where('event_id', $event->id);
            })->get()->unique();
        }
    }

    public function reloadGateways()
    {
        $event = $this->event;
        if ($this->reportType == "sales") {
            // Get Gateways of Orders
            $this->gateways = $event->orders->pluck('gateway')->unique();
        } else {
            // Get Gateways of TicketOrders
            $this->gateways = TicketOrder::whereHas('tickets.permits', function ($query) use ($event) {
                $query->where('event_id', $event->id);
            })->pluck('gateway')->unique();
        }
    }
}