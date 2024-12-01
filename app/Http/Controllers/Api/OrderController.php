<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function store(Request $request)
    {

        $request->validate([
            'transactionTime' => 'required|date',
            'idKasir' => 'required|exists:kasirs,id',
            'totalPrice' => 'required|numeric',
            'memberDiscount' => 'required|numeric',
            'totalQuantity' => 'required|numeric',
            'subTotal' => 'required|numeric', // Validasi untuk subTotal
            'memberId' => 'nullable|exists:members,id', // Validasi untuk memberId (nullable jika tidak wajib)
            'totalPajak' => 'required|numeric', // Validasi untuk totalPajak
            'serviceFee' => 'required|numeric', // Validasi untuk serviceFee
            'voucherId' => 'nullable|exists:voucher_discounts,id', // Validasi untuk voucherId (nullable jika tidak wajib)
            'voucherDiscount' => 'nullable|numeric',
            'paymentMethod' => 'required|string', // Validasi untuk paymentMethod,
            'namaKasir' => 'required|string|max:255', // Validasi untuk namaKasir
            'orders' => 'required|array',
            'orders.*.productId' => 'required|exists:products,id',
            'orders.*.quantity' => 'required|numeric',
            'orders.*.price' => 'required|numeric',
        ]);


        // Create order
        $order = \App\Models\Order::create([
            'transactionTime' => $request->transactionTime,
            'idKasir' => $request->idKasir,
            'totalPrice' => $request->totalPrice,
            'memberDiscount' => $request->memberDiscount,
            'totalQuantity' => $request->totalQuantity,
            'subTotal' => $request->subTotal,
            'memberId' => $request->memberId,
            'totalPajak' => $request->totalPajak,
            'serviceFee' => $request->serviceFee,
            'voucherId' => $request->voucherId,
            'voucherDiscount' => $request->voucherDiscount,
            'paymentMethod' => $request->paymentMethod,
            'namaKasir' => $request->namaKasir,
            'userId' => Auth::id(),
        ]);

        // return response()->json($order->id);
        // Create order items
        foreach ($request->orders as $item) {
            \App\Models\OrderItem::create([
                'orderId' => $order->id,
                'productId' => $item['productId'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // Update product stock
            $product = \App\Models\Product::find($item['productId']);
            if ($product) {
                $product->stock -= $item['quantity'];
                $product->save();
            }
        }

        // Response
        return response()->json([
            'success' => true,
            'message' => 'Order Created'
        ], 201);
    }
}
