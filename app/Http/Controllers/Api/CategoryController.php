<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{

    public function index()
    {
        // Mendapatkan user yang sedang login
        $userId = Auth::id();

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan',
            ], 404);
        }
        
        $categories = Category::where('user_id', $userId)->get();
        return response()->json([
            'status' => true,
            'message' => 'List data categories',
            'data' => $categories
        ]);
    }
}
