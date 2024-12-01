<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ServiceCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan user yang sedang login
        $userId = Auth::id();

        // Mengambil service_charge pertama
        $service_charge = ServiceCharge::findOrFail($userId);

        // Jika service_charge tidak ditemukan, kirimkan respons dengan pesan error
        if (!$service_charge) {
            return response()->json([
                'status' => 'error',
                'message' => 'No service charge found with status true',
            ], 404);
        }

        // Mengembalikan response dalam format JSON untuk satu service_charge
        return response()->json([
            'status' => 'success',
            'data' => $service_charge,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
