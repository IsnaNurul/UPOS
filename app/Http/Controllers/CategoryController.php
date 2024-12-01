<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //index
    public function index(Request $request)
    {
        // Ambil user ID dari pengguna yang sedang login
        $userId = Auth::id();
        
        $categories = DB::table('categories')
        ->when($request->input('name'), function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        })->where('user_id', $userId)->paginate(10);
        return view('pages.categories.index', compact('categories'));
    }

    //create
    public function create()
    {
        return view('pages.categories.create');
    }

    //store
    public function store(Request $request)
    {

        // Ambil user ID dari pengguna yang sedang login
        $userId = Auth::id();

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        // Buat data category dengan user_id dari pengguna yang sedang login
        Category::create([
            'name' => $request->name,
            'user_id' => $userId,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category successfully created');
    }

    //edit
    public function edit(Category $category)
    {
        return view('pages.categories.edit', compact('category'));
    }

    //update
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Category successfully updated');
    }

    //destroy
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category successfully deleted');
    }
}
