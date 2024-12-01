<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductBranch;
use Illuminate\Http\Request;

class ProductBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {

         $products = ProductBranch::where('branch_id', $id)->with('product')->orderBy('id', 'desc')->get();
         return response()->json([
             'success' => true,
             'message' => 'List Data Product',
             'data' => $products
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
