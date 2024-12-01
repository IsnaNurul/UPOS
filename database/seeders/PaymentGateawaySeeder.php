<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\PaymentGateawayType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PaymentGateawaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path ke gambar yang akan disimpan
        $sourcePath = database_path('seeders/images/midtrans.jpg');
        
        // Pastikan direktori tujuan ada
        if (!Storage::exists('public/payment_gateaway')) {
            Storage::makeDirectory('public/payment_gateaway');
        }

        // Generate nama file unik
        $fileName = Str::random(10) . '.jpg';

        // Salin gambar ke storage Laravel
        $storedPath = Storage::putFileAs('public/payment_gateaway', new \Illuminate\Http\File($sourcePath), $fileName);

        // Simpan informasi foto ke database
        PaymentGateawayType::create([
            'type' => 'midtrans',
            'image' => $fileName,
        ]);
    }
}
