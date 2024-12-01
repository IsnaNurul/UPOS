<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductBranch;
use App\Models\Restock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productsRequest = Restock::with('product_branch')
            ->where('user_id', Auth::id())
            ->where('status', 'request')
            ->get();

        $productsOnDelivery = Restock::with('product_branch')
            ->where('user_id', Auth::id())
            ->where('status', 'on delivery')
            ->get();

        $productsDone = Restock::with('product_branch')
            ->where('user_id', Auth::id())
            ->where('status', 'done')
            ->get();


        // dd($productsRequest, $productsOnDelivery, $productsDone);  // Debug the data

        return view('pages.restock.index', compact('productsRequest', 'productsOnDelivery', 'productsDone'));
    }

    public function restock(Request $request, $id)
    {
        // Find the restock request
        $restock = Restock::findOrFail($id);

        // Get the current stock from the product
        $currentStock = $restock->product_branch->product->stock;
        // dd($currentStock);

        // Validate if the new stock is greater than or equal to the current stock
        if ($request->new_stock > $currentStock) {
            return redirect()->back()->with('error', 'The new stock must be greater than or equal to the current stock available.');
        }

        // Update the restock status and new stock
        $data['status'] = 'on delivery';
        $data['new_stock'] = $request->new_stock;

        // Perform the update
        $restock->update($data);

        // Return success response
        return redirect()->back()->with('success', 'Request new stock successfully');
    }


    public function complete($restockId)
    {
        // Cari restock berdasarkan ID
        $restock = Restock::find($restockId);

        if ($restock && $restock->status == 'on delivery') {
            // Ambil product_branch yang terkait dengan restock
            $productBranch = ProductBranch::find($restock->product_branch_id);

            if ($productBranch) {
                // Ambil produk terkait melalui product_branch
                $product = Product::find($productBranch->product_id);

                if ($product) {
                    // Update status restock menjadi 'done'
                    $restock->status = 'done';
                    $restock->save();

                    // Tambahkan stock di product_branch sesuai dengan new_stock
                    $productBranch->stock += $restock->new_stock;
                    $productBranch->save();

                    // Kurangi stock produk utama di tabel products sesuai dengan new_stock
                    $product->stock -= $restock->new_stock;
                    $product->save();

                    // Kembalikan response atau redirect sesuai kebutuhan
                    return redirect()->route('restock.index')->with('success', 'restock status updated to Done and stock updated.');
                }

                return redirect()->route('restock.index')->with('error', 'restock not found.');
            }

            return redirect()->route('restock.index')->with('error', 'restock branch not found.');
        }

        return redirect()->route('restock.index')->with('error', 'Restock not found or status is not "request".');
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
