<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
        $attributes = request()->validate([
            'name' => 'required',
            'type' => 'required',
            'default_price' => 'required',
        ]);

        $attributes['user_id'] = auth()->id();

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
        ]);

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
