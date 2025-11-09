<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "brandId",
        "categoryId",
        "productCode",
        "title",
        "titleKm",
        "titleCn",
        "description",
        "descriptionKm",
        "descriptionCn",
        "fromPrice",
        "toPrice",
        "stock",
        "images",
        "video_link",
        "slideNumber",
        "isNewProduct",
        "ordering",
        "isActive",
    ];
}
