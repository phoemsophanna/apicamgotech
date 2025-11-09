<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultPlan extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "ordering",
        "isActive"
    ];
}
