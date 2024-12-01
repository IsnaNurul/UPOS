<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get User Id
        $userId = Auth::id();

        // Get data for members along with the associated member_discount
        $members = Member::with('member_discount')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('pages.member.index', compact('members'));
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
    public function edit($id)
    {
        //
        $member = Member::findOrFail($id);

        return view('pages.member.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'string|required',
            'phone' => 'required'
        ]);

        $member = Member::findOrFail($id);

        $member->update($request->all());

        return redirect()->route('member.index')->with('success', 'Member successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $member = Member::findOrFail($id);

        $member->delete();

        return redirect()->route('member.index')->with('success', 'Member successfully deleted');
    }
}
