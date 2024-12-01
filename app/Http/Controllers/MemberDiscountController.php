<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberDiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mendapatkan ID user yang sedang login
        $userId = Auth::id();

        // Mengambil data member discounts, dengan yang default berada di atas
        $members = MemberDiscount::where('user_id', $userId)
            ->orderBy('set_default', 'desc') // Mengurutkan agar yang default berada di atas
            ->get();

        return view('pages.discounts.member-discount.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('pages.discounts.member-discount.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //get User Id
        $userId = Auth::id();

        $data = $request->all();

        $data['user_id'] = $userId;

        MemberDiscount::create($data);

        return redirect()->route('discount-member.index')->with('success', 'Discount successfully created');
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
        $member = MemberDiscount::findOrFail($id);

        return view('pages.discounts.member-discount.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $member = MemberDiscount::findOrFail($id);

        // Pastikan data yang di-update berupa array dengan key sesuai kolom di database
        $data = $request->all();

        $member->update($data);

        return redirect()->route('discount-member.index')->with('success', 'Discount successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $member = MemberDiscount::findOrFail($id);

        // Check if this member discount is the default
        if ($member->set_default) {
            return redirect()->route('discount-member.index')->with('error', 'Default discount cannot be deleted.');
        }

        $member->delete();

        return redirect()->route('discount-member.index')->with('success', 'Discount successfully deleted');
    }

    public function setDefault($id)
    {
        // Mengatur semua member_discounts set_default menjadi false
        MemberDiscount::where('user_id', Auth::id())->update(['set_default' => false]);

        // Mengatur tier yang dipilih menjadi default
        $member = MemberDiscount::findOrFail($id);
        $member->set_default = true;
        $member->save();

        return redirect()->route('discount-member.index')->with('success', 'Default discount successfully set.');
    }
}
