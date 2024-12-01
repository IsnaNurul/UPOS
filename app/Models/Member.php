<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $guarded = '';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function member_discount()
    {
        return $this->belongsTo(MemberDiscount::class, 'member_discount_id', 'id');
    }
}
