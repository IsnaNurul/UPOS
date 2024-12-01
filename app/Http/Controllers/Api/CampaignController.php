<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index()
    {
        // Mengambil campaign pertama dengan status true
        $campaign = Campaign::where('status', true)->first();

        // Jika campaign tidak ditemukan, kirimkan respons dengan pesan error
        if (!$campaign) {
            return response()->json([
                'status' => 'error',
                'message' => 'No campaign found with status true',
            ], 404);
        }

        // Mengembalikan response dalam format JSON untuk satu campaign
        return response()->json([
            'status' => 'success',
            'data' => $campaign,
        ], 200);
    }
}
