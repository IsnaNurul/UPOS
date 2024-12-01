<?php

namespace App\Http\Controllers;

use App\Models\TransactionDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //get User Id
        $userId = Auth::id();

        // Dapatkan filter status dari query parameter (all, active, unactive)
        $status = $request->query('status', 'all');

        // Query berdasarkan status
        if ($status === 'active') {
            $discounts = DB::table('transaction_discounts')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->where('status', true)->where('user_id', $userId)->paginate(10);
        } elseif ($status === 'unactive') {
            $discounts = $discounts = DB::table('transaction_discounts')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->where('status', false)->where('user_id', $userId)->paginate(10);
        } else {
            // Default: Tampilkan semua discount
            $discounts = $discounts = DB::table('transaction_discounts')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->where('user_id', $userId)->paginate(10);
        }

        // Hitung jumlah discount untuk setiap kategori
        $countAll = TransactionDiscount::count();
        $countActive = TransactionDiscount::where('status', true)->where('user_id', $userId)->count();
        $countUnactive = TransactionDiscount::where('status', false)->where('user_id', $userId)->count();

        // Kirim data ke view
        return view('pages.discounts.transaction-discount.index', compact('discounts', 'countAll', 'countActive', 'countUnactive', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('pages.discounts.transaction-discount.create');
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
            'minimum_transaction' => 'required|integer',
            'end_date' => 'required|date',
        ]);

        //get User Id
        $userId = Auth::id();

        // Simpan campaign ke database
        TransactionDiscount::create([
            'name' => $request->name,
            'description' => $request->description,
            'discount' => $request->discount,
            'end_date' => $request->end_date,
            'status' => false, // Default status sebagai false
            'minimum_transaction' => $request->minimum_transaction,
            'user_id' => $userId,
        ]);

        // Redirect atau kembalikan pesan sukses
        return redirect()->route('transaction-discount.index')->with('success', 'Discount created successfully');
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
    public function edit($id)
    {

        //get User Id
        $discount = TransactionDiscount::findOrFail($id);

        return view('pages.discounts.transaction-discount.edit', compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Cari product berdasarkan ID
        $product = TransactionDiscount::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount' => 'required|integer',
            'end_date' => 'required|date',
        ]);

        // Persiapkan data untuk diupdate
        $data = $request->all();

        // Update product
        $product->update($data);

        return redirect()->route('transaction-discount.index')->with('success', 'Discount successfully updated');

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
        $discount = TransactionDiscount::findOrFail($id);

        // Jika campaign ingin diaktifkan (status = true), cek apakah sudah ada campaign aktif
        if (!$discount->status) {
            $activeDiscount = TransactionDiscount::where('status', true)->first();

            if ($activeDiscount) {
                // Jika sudah ada campaign aktif, berikan pesan error
                return redirect()->route('transaction-discount.index')->with('error', 'Only one discount can be active at a time.');
            }
        }

        // Toggle status
        $discount->status = !$discount->status;

        // Simpan perubahan
        $discount->save();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('transaction-discount.index')->with('success', 'Discount status updated successfully');
    }
}
