<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the logged-in user's ID
        $userId = Auth::id();

        // Retrieve products with a discount greater than 0, optionally filtering by name
        $products = DB::table('products')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->where('user_id', $userId)
            ->where('discount', '>', 0) // Filter products where discount > 0
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.discount_product.index', compact('products'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $userId = Auth::id();

        $products = Product::where('user_id', $userId)->get();

        return view('pages.discount_product.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Get Product Id
        $product_id = $request->product_id;

        // Cari product berdasarkan ID
        $product = Product::findOrFail($product_id);

        // Validasi diskon tergantung jenisnya
        $discount = (int) $request->discount;
        if ($request->discount_type === 'percentage') {
            // Jika tipe diskon adalah persentase, pastikan tidak lebih dari 100
            if ($discount > 100) {
                return back()->withErrors(['discount' => 'Discount percentage cannot exceed 100.']);
            }
            // Hitung diskon dalam bentuk persentase dari harga
            $request->merge(['discount' => $discount / 100 * $product->price]);
        }

        // Persiapkan data untuk diupdate
        $data = $request->all();

        // Update product
        $product->update($data);

        return redirect()->route('discount-product.index')->with('success', 'Discount successfully Created');
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
        //
        $product = Product::findOrFail($id);

        return view('pages.discount_product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Cari product berdasarkan ID
        $product = Product::findOrFail($id);

        // Validasi diskon tergantung jenisnya
        $discount = (int) $request->discount;
        if ($request->discount_type === 'percentage') {
            // Jika tipe diskon adalah persentase, pastikan tidak lebih dari 100
            if ($discount > 100) {
                return back()->withErrors(['discount' => 'Discount percentage cannot exceed 100.']);
            }
            // Hitung diskon dalam bentuk persentase dari harga
            $request->merge(['discount' => $discount / 100 * $product->price]);
        }

        // Persiapkan data untuk diupdate
        $data = $request->all();

        // Update product
        $product->update($data);

        return redirect()->route('discount-product.index')->with('success', 'Discount successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        // Hapus nilai discount
        $product->update(['discount' => 0]); // Atau null jika kolomnya nullable
        return redirect()->route('discount-product.index')->with('success', 'Discount successfully reset');
    }
}
