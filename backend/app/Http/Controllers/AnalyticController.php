<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyticController extends Controller
{
    public function index(){
        return view("analytics.dashboard");
    }

    public function eventProductSales(){
        return view("analytics.eventProductSales");
    }
}
