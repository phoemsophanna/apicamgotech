<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
    use HasFactory;
    protected $fillable = [
        "productId",
        "productCode",
        "title",
        "titleKm",
        "titleCn",
        "price",
        "stock",
        "image",
    ];
}
