<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kasir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

    public function loginKasir(Request $request)
    {
        $loginData = $request->validate([
            'pin' => 'required|digits:4', // Validate that pin is exactly 4 digits
        ]);

        // Find the user by PIN
        $user = Kasir::where('pin', $request->pin)->first();
        $bussiness_name = $user ? $user->user->profile->bussiness_name ?? null : null;

        if (!$user) {
            return response([
                'message' => 'Authentication Failed',
            ], 404);
        }

        // Generate an authentication token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'user' => [
                'kasir' => $user,
                'bussiness_name' => $bussiness_name,
            ],
            'token' => $token,
        ], 200);
    }

    public function login(Request $request)
{
    $loginData = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = \App\Models\User::with('profile', 'kasir', 'payment_gateaways', 'branches')
        ->where('email', $request->email)
        ->first();

    if (!$user) {
        return response([
            'message' => 'Authentication Failed',
        ], 404);
    }

    if (!Hash::check($request->password, $user->password)) {
        return response([
            'message' => 'Authentication Failed',
        ], 404);
    }
    
    // Hide 'created_at' and 'updated_at' for all related models
    $user->makeHidden(['created_at', 'updated_at']);
    $user->profile->makeHidden(['created_at', 'updated_at']);
    $user->kasir->each(function ($kasir) {
        $kasir->makeHidden(['created_at', 'updated_at']);
    });
    $user->payment_gateaways->each(function ($paymentGateway) {
        $paymentGateway->makeHidden(['created_at', 'updated_at']);
    });
    $user->branches->each(function ($branch) {
        $branch->makeHidden(['created_at', 'updated_at']);
    });

    $token = $user->createToken('auth_token')->plainTextToken;

    return response([
        'user' => $user,
        'token' => $token,
    ], 200);
}


    //logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout success',
        ]);
    }

    //logout kasir
    public function logoutKasir(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout success',
        ]);
    }
}
