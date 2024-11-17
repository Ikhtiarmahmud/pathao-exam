<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
       'merchant_order_id',
       'recipient_name',
       'recipient_phone',
       'recipient_address',
       'item_quantity',
       'item_weight',
       'amount_to_collect',
       'item_description',
    ];

    protected $hidden = [
        "created_at",
        "updated_at"
    ];
}
