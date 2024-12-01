<?php
namespace App\Actions\Fortify;

use App\Models\Branch;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:15'],
            'business_name' => ['nullable', 'string', 'max:255'],
        ])->validate();

        // Membuat user baru
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'phone' => $input['phone'] ?? null,
            'business_name' => $input['business_name'] ?? null,
        ]);

        // Membuat branch terkait dengan user yang baru dibuat
        Branch::create([
            'name' => $user->business_name, // Menggunakan business_name dari user
            'user_id' => $user->id, // Menggunakan ID user yang baru dibuat
        ]);

        // Membuat profile terkait dengan user yang baru dibuat
        Profile::create([
            'business_name' => $user->business_name,
            'user_id' => $user->id, // Mengaitkan profile dengan user yang baru dibuat
        ]);

        // Mengembalikan objek user yang baru dibuat
        return $user;
    }
}
