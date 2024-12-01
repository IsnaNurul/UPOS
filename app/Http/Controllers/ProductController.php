<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Get categories for filter dropdown
        $categories = DB::table('categories')->get();

        $products = DB::table('products')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($request->input('category_id'), function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->when($request->input('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pages.products.index', compact('products', 'categories'));
    }

    public function updateStock(Request $request)
    {
        // Ensure the product ID and stock are passed correctly
        $request->validate([
            'id' => 'required|exists:products,id',
            'stock' => 'required|integer|min:0'
        ]);

        $product = Product::find($request->id);
        $product->stock = $request->stock;
        $product->last_stock_update = now(); // Update the stock timestamp
        $product->save();

        return redirect()->back()->with('success', 'Stock updated successfully.');
    }


    public function create()
    {
        $categories = DB::table('categories')->get();
        $branches = Branch::where('user_id', Auth::id())->get();
        return view('pages.products.create', compact('categories', 'branches'));
    }

    public function store(Request $request)
    {
        // Ambil user ID dari pengguna yang sedang login
        $userId = Auth::id();

        // Validate input
        $request->validate([
            'name' => [
                'required',
                'min:3',
                // Tambahkan kondisi unik hanya untuk produk dengan user_id yang sama
                Rule::unique('products')->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                }),
            ],
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category_id' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg',
            'branches' => 'required|array|min:1', // Ensure branches are selected
            'branches.*' => 'exists:branches,id', // Validate each branch ID
        ]);

        // Save the image
        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);

        // Prepare data for product creation
        $category = DB::table('categories')->where('id', $request->category_id)->first();
        $product = new \App\Models\Product;
        $product->name = $request->name;
        $product->price = (int) $request->price;
        $product->stock = (int) $request->stock;
        $product->unit = $request->unit;
        $product->discount = '0';
        $product->category = $category->name;
        $product->category_id = $request->category_id;
        $product->image = $filename;
        $product->user_id = $userId;
        $product->save();

        // Insert data into product_branches table
        foreach ($request->branches as $branchId) {
            DB::table('product_branches')->insert([
                'product_id' => $product->id,
                'branch_id' => $branchId,
                'user_id' => $userId,
                'stock' => '0', // Use the same stock or pass different stock for each branch if needed
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('product.index')->with('success', 'Product successfully created');
    }


    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $categories = DB::table('categories')->get();
        return view('pages.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {

        // Cari product berdasarkan ID
        $product = \App\Models\Product::findOrFail($id);

        // Ambil kategori berdasarkan category_id
        $category = DB::table('categories')->where('id', $request->category_id)->first();

        // Persiapkan data untuk diupdate
        $data = $request->all();
        $data['category'] = $category->name;

        // Update product
        $product->update($data);

        return redirect()->route('product.index')->with('success', 'Product successfully updated');
    }

    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product successfully deleted');
    }
}
