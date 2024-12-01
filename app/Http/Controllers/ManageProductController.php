<?php

namespace App\Http\Controllers;

use App\Models\ProductBranch;
use App\Models\Restock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManageProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil semua kategori dan cabang
        $categories = DB::table('categories')->where('user_id', Auth::id())->get();
        $branches = DB::table('branches')->where('user_id', Auth::id())->get();

        // Filter produk berdasarkan nama, kategori, dan cabang
        $products = ProductBranch::with('product', 'branch')
            ->when($request->input('name'), function ($query, $name) {
                $query->whereHas('product', function ($q) use ($name) {
                    $q->where('name', 'like', '%' . $name . '%');
                });
            })
            ->when($request->input('category_id'), function ($query, $categoryId) {
                $query->whereHas('product', function ($q) use ($categoryId) {
                    $q->where('category_id', $categoryId);
                });
            })
            ->when($request->input('branch_id'), function ($query, $branchId) {
                $query->where('branch_id', $branchId);
            })
            ->get();

        return view('pages.manage-product.index', compact('products', 'categories', 'branches'));
    }

    public function requestStock($id)
    {
        $product_branch = ProductBranch::findOrFail($id);

        $data = Restock::create([
            'product_branch_id' => $id,
            'last_stock' => $product_branch->stock,
            'new_stock' => '0',
            'status' => 'request',
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Request new stock successfully');
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
