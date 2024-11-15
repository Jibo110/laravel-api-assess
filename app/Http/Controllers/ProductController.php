<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Get all products
    public function index()
    {
        return Product::all();
    }

    // Store a new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer'
        ]);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return response()->json($product, 201);
    }

    // Get a single product by ID
    public function show($id)
    {
        return Product::findOrFail($id);
    }

    // Update a product
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update($request->all());

        return response()->json($product);
    }

    // Delete a product
    public function destroy($id)
    {
        Product::destroy($id);

        return response()->json(['message' => 'Product deleted'], 200);
    }
}
