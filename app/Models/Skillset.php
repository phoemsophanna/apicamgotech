<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skillset extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "percentage",
        "barColor",
        "ordering",
        "isActive",
    ];
}
