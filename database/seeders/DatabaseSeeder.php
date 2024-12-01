<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Member;
use App\Models\MemberDiscount;
use App\Models\PaymentGateawayType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory()->create([
            'name' => 'Nasgor With Me',
            'email' => 'tedy@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '087565677368',
            'business_name' => 'Nasi Goreng',
        ]);

        $this->call([
            PaymentGateawaySeeder::class,
        ]);

        // Member::create([
        //     'name' => 'none member',
        //     'phone' => '081234567890',
        //     'password' => Hash::make('12345678'),
        //     'alamat' => 'tasik',
        //     'member_discount_id' => '1',
        //     'user_id' => '1'
        // ]);

    }
}
