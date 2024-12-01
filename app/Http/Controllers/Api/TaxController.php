<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pajak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaxController extends Controller
{
    //
    public function index()
    {
        // Mendapatkan user yang sedang login
        $userId = Auth::id();

        // Mengambil tax pertama
        $tax = Pajak::findOrFail($userId);

        // Jika tax tidak ditemukan, kirimkan respons dengan pesan error
        if (!$tax) {
            return response()->json([
                'status' => 'error',
                'message' => 'No tax found with status true',
            ], 404);
        }

        // Mengembalikan response dalam format JSON untuk satu tax
        return response()->json([
            'status' => 'success',
            'data' => $tax,
        ], 200);
    }
}
