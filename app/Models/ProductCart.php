<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCart extends Model
{
    use HasFactory;
    protected $fillable = [
        "userId",
        "productId",
        "productOptionId",
        "productName",
        "productNameKm",
        "productNameCn",
        "productCode",
        "productPrice",
        "productImage",
        "quantity"
    ];
}
