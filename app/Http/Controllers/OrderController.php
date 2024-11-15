<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Get all orders
    public function index()
    {
        return Order::all();
    }

    // Store a new order
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $order = Order::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'status' => $request->status ?? 'pending',
        ]);

        return response()->json($order, 201);
    }

    // Get a single order by ID
    public function show($id)
    {
        return Order::findOrFail($id);
    }

    // Update an order
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->update($request->all());

        return response()->json($order);
    }

    // Delete an order
    public function destroy($id)
    {
        Order::destroy($id);

        return response()->json(['message' => 'Order deleted'], 200);
    }
}
