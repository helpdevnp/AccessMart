<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $casts = [
        'id' => 'integer',
        'order_id' => 'integer',
        'store_id' => 'integer',
        'amount' => 'float',
        'created_at' => 'datetime',
    ];


    public function store()
    {
        return $this->belongsTo(Store::class,'store_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function delivery_man()
    {
        return $this->belongsTo(DeliveryMan::class,'delivery_man_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s',strtotime($value));
    }
}
