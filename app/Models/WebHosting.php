<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebHosting extends Model
{
    use HasFactory;
    protected $fillable = [
        "type",
        "pricePerYear",
        "dataStorage",
        "bandwidth",
        "emailAccounts",
        "database",
        "domainAddOn",
        "maxHourlyEmailSend",
        "hostingGroup",
        "isFreeDomain",
        "isMostPopular",
        "mostPopularColor",
        "isGoodSpeed",
        "goodSpeedColor",
        "ordering",
        "isActive",
    ];
}
