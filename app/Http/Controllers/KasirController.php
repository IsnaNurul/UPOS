<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateKasirRequest;
use App\Models\Branch;
use App\Models\Kasir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the logged-in user's ID
        $userId = Auth::id();

        // Fetch the list of branches to use for filtering
        $branches = Branch::where('user_id', $userId)->get();

        // Get data kasirs with branch information using Eloquent
        $kasirs = Kasir::with('branch') // Load the branch relationship
            ->where('user_id', $userId)
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($request->input('branch_id'), function ($query, $branchId) {
                return $query->where('branch_id', $branchId);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('pages.kasir.index', compact('kasirs', 'branches'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::where('user_id', Auth::id())->get();
        return view('pages.kasir.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:kasirs,phone',
            'pin' => 'required|array|size:4',
            'pin.*' => 'digits:1',
            'branch_id' => 'required|exists:branches,id', // Ensures only one branch ID
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['pin'] = implode('', $request->pin); // Combine PIN array to a single string

        Kasir::create($data);

        return redirect()->route('kasir.index')->with('success', 'Kasir created successfully.');
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
        $kasir = Kasir::findOrFail($id);
        return view('pages.kasir.edit', compact('kasir'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKasirRequest $request, Kasir $kasir)
    {
        // Validate that the request includes a PIN array with exactly 4 digits
        $request->validate([
            'name' => 'required|max:100|min:3',
            'phone' => 'required|unique:kasirs,phone,' . $kasir->id, // Exclude current record's phone from unique validation
            'pin' => 'required|array|size:4', // Validate that pin is an array of 4 items
            'pin.*' => 'digits:1', // Each element in the pin array should be a single digit
        ]);

        // Join the PIN array into a single string
        $data = $request->all();
        $data['pin'] = implode('', $request->pin); // Concatenate the array elements

        // Update the kasir record with the validated data
        $kasir->update($data);

        return redirect()->route('kasir.index')->with('success', 'Kasir successfully updated');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kasir $kasir)
    {
        $kasir->delete();
        return redirect()->route('kasir.index')->with('success', 'Kasir successfully deleted');
    }
}
