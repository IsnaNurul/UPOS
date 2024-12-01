<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //
    public function index()
    {
       // Mendapatkan user yang sedang login
       $userId = Auth::id();

        // Mengambil profile pertama dengan status true
        $profile = Profile::findOrFail($userId);


        // Jika profile tidak ditemukan, kirimkan respons dengan pesan error
        if (!$profile) {
            return response()->json([
                'status' => 'error',
                'message' => 'No profile found with status true',
            ], 404);
        }

        // Mengembalikan response dalam format JSON untuk satu profile
        return response()->json([
            'status' => 'success',
            'data' => $profile,
        ], 200);
    }
}
