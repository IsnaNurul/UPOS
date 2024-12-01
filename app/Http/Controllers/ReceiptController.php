<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get User Id
        $userId = Auth::id();

        $profile = DB::table('profiles')->where('user_id', $userId)->first();
        return view('pages.settings.receipt.index', compact('profile'));
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
            'business_name' => 'required|max:255',
            'header_text' => 'nullable|max:255',
            'footer_text' => 'nullable|max:255',
            'logo' => 'nullable|image|max:1024', // Max size 1MB
        ]);

        // Get user ID yang sedang login
        $userId = Auth::id();

        // Cek apakah profil sudah ada untuk user ini
        $profile = DB::table('profiles')->where('user_id', $userId)->first();

        // Jika file logo diunggah
        $logoPath = null;
        if ($request->logo) {
            $logoPath = time() . '.' . $request->logo->extension();
            $request->logo->storeAs('public/logo', $logoPath);
        }

        if ($profile) {
            // Jika profil sudah ada, lakukan update
            DB::table('profiles')->where('user_id', $userId)->update([
                'business_name' => $request->business_name,
                'header_text' => $request->header_text,
                'footer_text' => $request->footer_text,
                'logo' => $logoPath ?? $profile->logo, // Update logo jika ada
            ]);

            return redirect()->route('setting-receipt.index')->with('success', 'Receipt settings updated successfully.');
        } else {
            // Jika profil belum ada, lakukan insert
            DB::table('profiles')->insert([
                'user_id' => $userId,
                'business_name' => $request->business_name,
                'header_text' => $request->header_text,
                'footer_text' => $request->footer_text,
                'logo' => $logoPath,
            ]);

            return redirect()->route('setting-receipt.index')->with('success', 'Receipt settings created successfully.');
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
