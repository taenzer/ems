<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Http\Request;

class ApiProductImageController extends Controller
{
    // Output all Product Images of active Events as ZIP File
    public function index(){

        // Get all event id's of users active events
        $images = auth()->user()->getEvents()->flatMap(function($event){
            return $event->products()->where("image", "!=", null)
            ->pluck("image");
        })->unique();

        //$images = [];


        $zip_file = storage_path('product-images.zip');

        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($images as $image_path) {
            if(!isset($image_path)){
                continue;
            }
           $zip->addFile(storage_path("app/public/$image_path"), basename($image_path));
        }

        if(empty($images)){
            $zip->addEmptyDir(".");
        }
        
        $zip->close();

        return response()->download($zip_file);
    }
}