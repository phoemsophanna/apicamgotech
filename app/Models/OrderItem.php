<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        "orderId",
        "productId",
        "productOptionId",
        "productName",
        "productNameKm",
        "productNameCn",
        "productCode",
        "productPrice",
        "productImage",
        "quantity",
    ];
}
