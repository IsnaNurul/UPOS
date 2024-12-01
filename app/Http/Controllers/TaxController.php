<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get User Id
        $userId = Auth::id();

        $pajak = DB::table('pajaks')->where('user_id', $userId)->first();
        return view('pages.settings.tax.index', compact('pajak'));
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
        // Validasi input
        $request->validate([
            'jenis' => 'required',
            'value' => 'required'
        ]);

        // Get user ID yang sedang login
        $userId = Auth::id();

        // Cek apakah profil sudah ada untuk user ini
        $pajak = DB::table('pajaks')->where('user_id', $userId)->first();

        if ($pajak) {
            // Jika profil sudah ada, lakukan update
            DB::table('pajaks')->where('user_id', $userId)->update([
                'jenis' => $request->jenis,
                'value' => $request->value,
                'user_id' => $userId
            ]);

            return redirect()->route('setting-tax.index')->with('success', 'Receipt settings updated successfully.');
        } else {
            // Jika profil belum ada, lakukan insert
            DB::table('pajaks')->insert([
                'jenis' => $request->jenis,
                'value' => $request->value,
                'user_id' => $userId
            ]);

            return redirect()->route('setting-tax.index')->with('success', 'Receipt settings created successfully.');
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
