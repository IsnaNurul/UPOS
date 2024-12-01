<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateaway extends Model
{
    use HasFactory;
    protected $guarded = '';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function payment_gateaway_type()
    {
        return $this->belongsTo(PaymentGateawayType::class, 'type_id', 'id');
    }
}
