<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateawayType extends Model
{
    use HasFactory;

    protected $gurded = '';

    public function paymentGateaways()
    {
        return $this->hasMany(PaymentGateaway::class, 'type_id', 'id');
    }
}
