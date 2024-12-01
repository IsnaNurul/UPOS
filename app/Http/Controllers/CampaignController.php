<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Dapatkan filter status dari query parameter (all, active, unactive)
        $status = $request->query('status', 'all');

        // Query berdasarkan status
        if ($status === 'active') {
            $campaigns = Campaign::where('status', true)->get();
        } elseif ($status === 'unactive') {
            $campaigns = Campaign::where('status', false)->get();
        } else {
            // Default: Tampilkan semua campaign
            $campaigns = Campaign::all();
        }

        // Hitung jumlah campaign untuk setiap kategori
        $countAll = Campaign::count();
        $countActive = Campaign::where('status', true)->count();
        $countUnactive = Campaign::where('status', false)->count();

        // Kirim data ke view
        return view('pages.campaigns.index', compact('campaigns', 'countAll', 'countActive', 'countUnactive', 'status'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount' => 'required|integer',
            'end_date' => 'required|date',
        ]);

        // Simpan campaign ke database
        Campaign::create([
            'name' => $request->name,
            'description' => $request->description,
            'discount' => $request->discount,
            'end_date' => $request->end_date,
            'status' => false, // Default status sebagai false
        ]);

        // Redirect atau kembalikan pesan sukses
        return redirect()->route('campaign.index')->with('success', 'Campaign created successfully');
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

    public function toggleStatus($id)
    {
        // Cari campaign berdasarkan ID
        $campaign = Campaign::findOrFail($id);

        // Jika campaign ingin diaktifkan (status = true), cek apakah sudah ada campaign aktif
        if (!$campaign->status) {
            $activeCampaign = Campaign::where('status', true)->first();

            if ($activeCampaign) {
                // Jika sudah ada campaign aktif, berikan pesan error
                return redirect()->route('campaign.index')->with('error', 'Only one campaign can be active at a time.');
            }
        }

        // Toggle status
        $campaign->status = !$campaign->status;

        // Simpan perubahan
        $campaign->save();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('campaign.index')->with('success', 'Campaign status updated successfully');
    }
}
