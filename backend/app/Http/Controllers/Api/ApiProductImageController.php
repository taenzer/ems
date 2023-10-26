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

        $images = Product::whereHas('events', function(Builder $query){
            $query->where('active', 1);
        })->get()->pluck("image");

        $zip_file = 'product-images.zip';

        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        foreach ($images as $image_path) {
           $zip->addFile(storage_path("app/public/$image_path"), basename($image_path));
        }
        
        $zip->close();

        return response()->download($zip_file);
    }
}