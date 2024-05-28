<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Helpers\File\FileHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('product.index', [
            'product_sets' => Product::all()->groupBy('type'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $attributes = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'default_price' => 'required',
            'image' => 'required|base64_url_image'
        ]);

        $attributes['user_id'] = auth()->id();
        $attributes['image'] = FileHelper::fromBase64($attributes['image'])->store('product_images');
        $product = Product::create($attributes);

        return redirect(route('products.show', ['product' => $product]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('product.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('product.edit', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'type' => 'required',
            'default_price' => 'required',
            'image' => 'required|base64_url_image'
        ]);
        
        if(Storage::exists($product->image))
        {
            Storage::delete($product->image);
        }

        $attributes['image'] = FileHelper::fromBase64($attributes['image'])->store('product_images');
        $product->update($attributes);
        return redirect(route('products.show', ['product' => $product]))->with('success', 'Produkt aktualisiert');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}