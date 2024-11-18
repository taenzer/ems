<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AnalyticController extends Controller
{
    public function index(){
        return view("analytics.dashboard");
    }

    public function eventProductSales(){
        return view("analytics.eventProductSales", [
            "events" => auth()->user()->getEvents(),
            "products" => Product::all(),
        ]);
    }
}
