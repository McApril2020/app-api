<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($validated['product_id']);

        if ($product->available_stock < $validated['quantity']) {
            return response()->json([
                'message' => 'Failed to order this product due to unavailability of the stock'
            ], 400);
        }

        // Deduct stock
        $product->available_stock -= $validated['quantity'];
        $product->save();

        return response()->json([
            'message' => 'You have successfully ordered this product.'
        ], 201);
    }
}
