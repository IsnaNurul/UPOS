<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{

    public function index()
    {
        // Mendapatkan user yang sedang login
        $userId = Auth::id();

        $members = Member::with('member_discount')->where('user_id', $userId)->get();

        return response()->json([
            'status' => true,
            'message' => 'Success retrieve all members',
            'data' => $members
        ], 200);
    }

    public function store(Request $request)
    {
        // Mendapatkan user yang sedang login
        $userId = Auth::id();

        $data = $request->all();
        $data['user_id'] = $userId;

        // Ambil MemberDiscount dengan set_default true untuk user ini
        $defaultDiscount = MemberDiscount::where('user_id', $userId)
            ->where('set_default', true)
            ->first();

        // Set member_discount_id berdasarkan default yang aktif atau fallback ke null jika tidak ada yang default
        $data['member_discount_id'] = $defaultDiscount ? $defaultDiscount->id : null;

        // Buat data member
        $member = Member::create($data);

        // Load the related member discount
        $member->load('member_discount'); // Load the member_discount relation here

        return response()->json([
            'status' => true,
            'message' => 'Success create member',
            'data' => $member // This now includes the member_discount relation
        ], 201);
    }
}
