<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TransactionDiscount;
use App\Models\VoucherDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    public function getDiscountTransaction()
    {
        // Mendapatkan user yang sedang login
        $userId = Auth::id();

        // Mengambil discount pertama dengan status true
        $discount = TransactionDiscount::where([
            ['status', true],
            ['user_id', $userId]
        ])->first();

        // Jika discount tidak ditemukan, kirimkan respons dengan pesan error
        if (!$discount) {
            return response()->json([
                'status' => 'error',
                'message' => 'No discount found with status true',
            ], 404);
        }

        // Mengembalikan response dalam format JSON untuk satu discount
        return response()->json([
            'status' => 'success',
            'data' => $discount,
        ], 200);
    }

    public function getDiscountVoucher()
    {
        // Mendapatkan user yang sedang login
        $userId = Auth::id();

        // Mengambil discount pertama dengan status true
        $discount = VoucherDiscount::where([
            ['status', true],
            ['user_id', $userId]
        ])->get();

        // Jika discount tidak ditemukan, kirimkan respons dengan pesan error
        if (!$discount) {
            return response()->json([
                'status' => 'error',
                'message' => 'No discount found with status true',
            ], 404);
        }

        // Mengembalikan response dalam format JSON untuk satu discount
        return response()->json([
            'status' => 'success',
            'data' => $discount,
        ], 200);
    }
}
