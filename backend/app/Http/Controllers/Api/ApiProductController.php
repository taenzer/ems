<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

class ApiProductController extends Controller{

    public function index(){
        $events = auth()->user()->getEvents(true);

        $products = $events->flatMap(function($event){
            $prods = $event->products()->orderByPivot("prio", "desc")->get();
            return $prods->map(function ($prod) {
                return collect([
                    "id" => $prod->id,
                    "event_id" => $prod->product_data->event_id,
                    "name" => $prod->name,
                    "type" => $prod->type,
                    "price" => $prod->product_data->price,
                    "image" => $prod->image,
                    "prio" => $prod->product_data->prio
                ]);
            });
        })->unique();
        return $products;
    }
}