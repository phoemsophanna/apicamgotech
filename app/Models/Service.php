<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "image",
        "summary",
        "content",
        "isDisplayHomepage",
        "ordering",
        "isActive",
        "metaKeyword",
        "metaDesc",
    ];
}
