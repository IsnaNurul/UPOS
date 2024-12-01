<?php

namespace App\Http\Controllers;

use App\Models\PaymentGateaway;
use App\Models\PaymentGateawayType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentGateawayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data PaymentGateaway beserta tipe-nya
        $payment_gateaway = PaymentGateaway::with('payment_gateaway_type')->get();

        // Mengambil data pertama yang memiliki status aktif (status = 1)
        $status = PaymentGateaway::where('status', 1)->exists();

        return view('pages.integrations.payment-gateaway.index', compact('payment_gateaway', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua payment_gateaway_types yang tidak ada di tabel payment_gateaways
        $payment_gateaway = PaymentGateawayType::doesntHave('paymentGateaways')->get();

        return view('pages.integrations.payment-gateaway.create', compact('payment_gateaway'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //get user id
        $userId = Auth::id();

        $request->validate([
            'type_id' => 'required',
            'api_key' => 'required',
        ]);

        $data = $request->all();
        $data['user_id'] = $userId;

        $payment_gateaway = PaymentGateaway::create($data);
        return redirect()->route('payment-gateaway.index')->with('success', 'Payment gateaway successfully created');
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
        $payment_gateaway = PaymentGateaway::with('payment_gateaway_type')->where('id', $id)->first();

        if (!$payment_gateaway) {
            abort(404, 'Payment Gateaway not found');
        }
    
        return view('pages.integrations.payment-gateaway.edit', compact('payment_gateaway'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $payment_gateaway = PaymentGateaway::findOrFail($id);

        $data = $request->all();

        $payment_gateaway->update($data);

        return redirect()->route('payment-gateaway.index')->with('success', 'Payment gateaway successfully updated');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $payment_gateaway = PaymentGateaway::findOrFail($id);

        $payment_gateaway->delete();

        return redirect()->route('payment-gateaway.index')->with('success', 'Payment gateaway successfully deleted');

    }

    public function toggleStatus($id)
    {
        // Cari campaign berdasarkan ID
        $payment_gateaway = PaymentGateaway::findOrFail($id);

        // Jika campaign ingin diaktifkan (status = true), cek apakah sudah ada campaign aktif
        if (!$payment_gateaway->status) {
            $activePaymentGateaway = PaymentGateaway::where('status', true)->first();

            if ($activePaymentGateaway) {
                // Jika sudah ada campaign aktif, berikan pesan error
                return redirect()->route('payment-gateaway.index')->with('error', 'Only one payment gateaway can be active at a time.');
            }
        }

        // Toggle status
        $payment_gateaway->status = !$payment_gateaway->status;

        // Simpan perubahan
        $payment_gateaway->save();

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('payment-gateaway.index')->with('success', 'Payment gateaway status updated successfully');
    }
}
