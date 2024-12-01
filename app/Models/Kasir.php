<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Kasir extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = '';
    protected $table = 'kasirs';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
