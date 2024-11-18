<?php

namespace App\Services;
use App\Models\Event;
use App\Models\Product;

class Analytics {

    public static function multiEventProductSaleAnalytics($events, $products, array $gateways = array()){
        $stats = $products->flatMap(function($product, $productIndex) use ($events, $gateways){
            return $events->map(function($event, $eventIndex) use ($product, $productIndex, $gateways) {
                
                $orderItems = $event->orderItems()
                    ->where("product_id", $product->id)
                    ->get()
                    ->filter(function($item) use ($gateways){
                        return empty($gateways) || in_array($item->order->gateway, $gateways);
                    })
                    ->groupBy("price")
                    ->map(function($priceGroup){
                        return collect([
                            "itemsSold" => $priceGroup->sum("quantity"),
                            "price" => $priceGroup->first()->price,
                            "total" => $priceGroup->sum("itemTotal")
                        ]);
                    });
                return collect([
                    "productIndex" => $productIndex,
                    "eventIndex" => $eventIndex,
                    "priceCategories" => $orderItems,
                    "itemsSoldTotal" => $orderItems->sum("itemsSold"),
                    "total" => $orderItems->sum("total"),
                ]);
            });
        });
        //dd($stats);
        return $stats;
    }

    // TICKET ANALYTICS

    /**
     * Get all tickets wich have access to the event. By default also includes tickets that
     * grant access for multiple events. 
     * 
     * @param $directTicketsOnly - set `true` if you only want tickets that have no other permit
     */
    public static function getEventTickets(Event $event, array $gateways = array(), bool $directTicketsOnly = false){
        return $event->tickets->filter(function ($ticket) use ($gateways, $directTicketsOnly) {
            return empty($gateways) 
            || in_array($ticket->ticketOrder->gateway, $gateways)
            && (!$directTicketsOnly || $ticket->permits->count() == 1);
        });
    }

    public static function getEventTicketSaleStats(Event $event, array $gateways = array(), bool $directTicketsOnly = false){
        return Analytics::getEventTickets($event, $gateways, $directTicketsOnly)
            // First, iterate over all tickets and gather information from the relations
            ->map(function ($ticket) {
                return collect([
                    "ticket" => $ticket->ticketProduct->name . " - " . $ticket->ticketPrice->category,
                    "ticket_price" => $ticket->ticketPrice->price,
                    "boxoffice_fee" => $ticket->boxoffice_fee
                ]);
            })
            // Now group them by the ticket type
            ->groupBy('ticket')
            // ...and analyze the grouped tickets
            ->map(function ($tickets) {
                return $tickets
                    // group them again by their boxoffice_fee
                    ->groupBy("boxoffice_fee")
                    // and calculate the needed stats
                    ->map(function ($feeGroup) {
                        return collect([
                            "count" => $feeGroup->count(), // How many tickets have been sold
                            "price" => $feeGroup->first()["ticket_price"], // the price (without fee) (should be equal for all tickets in the group)
                            "fee" => $feeGroup->first()["boxoffice_fee"], // the fee (should be equal for all tickets in the group)
                            "sum" => $feeGroup->sum("ticket_price") + $feeGroup->sum("boxoffice_fee"), // sum of all prices and fees
                        ]);
                    });
            });
    }

    // EVENT ANALYTICS

    /**
     * Get all product orders of an event
     */
    public static function getEventOrders(Event $event, array $gateways = array()){
        return $event->orders->filter(function ($order) use ($gateways) {
            return empty($gateways) || in_array($order->gateway, $gateways);
        });
    }

    /**
     * Get all product orderItems of an event
     */
    public static function getEventOrderItems(Event $event, array $gateways = array()){
        return Analytics::getEventOrders($event, $gateways)->flatMap(function ($order) {
            return $order->items;
        });
    }

    /**
     * Analyze the orders of an event and return stats about how many items have been sold
     * for what price.
     */
    public static function getEventProductSaleStats(Event $event, array $gateways = array()){
        return Analytics::getEventOrderItems($event, $gateways)
            ->groupBy("product_id")
            ->map(function ($items, $product_id) {
                return collect([
                    "product" => Product::find($product_id),
                    "itemsSold" => $items->sum("quantity"),
                    "prices" => $items->groupBy("price")->mapWithKeys(function ($priceGroup) {
                        return [strval($priceGroup->first()->price) => $priceGroup->sum("quantity")];
                    }),
                    "salesVolume" => $items->sum("itemTotal")
                ]);
            });
    }
}