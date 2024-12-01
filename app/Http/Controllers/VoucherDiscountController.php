<?php

namespace App\Http\Controllers;

use App\Models\VoucherDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoucherDiscountController extends Controller
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
            $discounts = DB::table('voucher_discounts')
                ->when($request->input('name'), function ($query, $name) {
                    return $query->where('name', 'like', '%' . $name . '%');
                })
                ->where('status', true)->where('user_id', $userId)->paginate(10);
        } elseif ($status === 'unactive') {
            $discounts = $discounts = DB::table('voucher_discounts')
                ->when($request->input('name'), function ($query, $name) {
                    return $query->where('name', 'like', '%' . $name . '%');
                })
                ->where('status', false)->where('user_id', $userId)->paginate(10);
        } else {
            // Default: Tampilkan semua discount
            $discounts = $discounts = DB::table('voucher_discounts')
                ->when($request->input('name'), function ($query, $name) {
                    return $query->where('name', 'like', '%' . $name . '%');
                })
                ->where('user_id', $userId)->paginate(10);
        }

        // Hitung jumlah discount untuk setiap kategori
        $countAll = VoucherDiscount::count();
        $countActive = VoucherDiscount::where('status', true)->where('user_id', $userId)->count();
        $countUnactive = VoucherDiscount::where('status', false)->where('user_id', $userId)->count();

        // Kirim data ke view
        return view('pages.discounts.voucher-discount.index', compact('discounts', 'countAll', 'countActive', 'countUnactive', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('pages.discounts.voucher-discount.create');

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
            'unique_code' => 'required|string',
            'minimum_transaction' => 'required|integer',
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'end_date' => 'required|date',
        ]);

        //get User Id
        $userId = Auth::id();

        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/vouchers', $filename);

        // Simpan campaign ke database
        VoucherDiscount::create([
            'name' => $request->name,
            'description' => $request->description,
            'discount' => $request->discount,
            'end_date' => $request->end_date,
            'status' => true, // Default status sebagai false
            'minimum_transaction' => $request->minimum_transaction,
            'unique_code' => $request->unique_code,
            'image' => $filename,
            'user_id' => $userId,
        ]);

        // Redirect atau kembalikan pesan sukses
        return redirect()->route('voucher-discount.index')->with('success', 'Discount created successfully');
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
        $discount = VoucherDiscount::findOrFail($id);

        return view('pages.discounts.voucher-discount.edit', compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Cari product berdasarkan ID
        $product = VoucherDiscount::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount' => 'required|integer',
            'unique_code' => 'required|string',
            'end_date' => 'required|date',
        ]);

        // Persiapkan data untuk diupdate
        $data = $request->all();

        // Update product
        $product->update($data);

        return redirect()->route('voucher-discount.index')->with('success', 'Discount successfully updated');

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
        $discount = VoucherDiscount::findOrFail($id);

        // Jika campaign ingin diaktifkan (status = true), cek apakah sudah ada campaign aktif
        // if (!$discount->status) {
        //     $activeDiscount = VoucherDiscount::where('status', true)->first();

        //     if ($activeDiscount) {
        //         // Jika sudah ada campaign aktif, berikan pesan error
        //         return redirect()->route('voucher-discount.index')->with('error', 'Only one discount can be active at a time.');
        //     }
        // }

        // Toggle status
        $discount->status = !$discount->status;

        // Simpan perubahan
        $discount->save();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('voucher-discount.index')->with('success', 'Discount status updated successfully');
    }
}
