<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "summary",
        "content",
        "location",
        "type",
        "ordering",
        "isActive",
    ];
}
