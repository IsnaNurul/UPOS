<?php

namespace App\Http\Controllers;

use App\Models\ServiceCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $userId = Auth::id();

        $service_charge = ServiceCharge::where('user_id', $userId)->first();

        return view('pages.settings.service_charge.index', compact('service_charge'));
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
        // Get user ID yang sedang login
        $userId = Auth::id();

        // Cek apakah profil sudah ada untuk user ini
        $service_charge = DB::table('service_charges')->where('user_id', $userId)->first();

        if ($service_charge) {
            // Jika profil sudah ada, lakukan update
            DB::table('service_charges')->where('user_id', $userId)->update([
                'value' => $request->value,
                'user_id' => $userId
            ]);

            return redirect()->route('service-charge.index')->with('success', 'Service charge updated successfully.');
        } else {
            // Jika profil belum ada, lakukan insert
            DB::table('service_charges')->insert([
                'value' => $request->value,
                'user_id' => $userId
            ]);

            return redirect()->route('service-charge.index')->with('success', 'Service charge created successfully.');
        }
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
