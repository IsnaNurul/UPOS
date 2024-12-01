<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = '';

    public function kasir()
    {
        return $this->belongsTo(Kasir::class, 'kasir_id', 'id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'orderId', 'id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'memberId');
    }
}
