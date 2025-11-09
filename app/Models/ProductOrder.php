<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        "userId",
        "customerName",
        "phoneNumber",
        "location",
        "address",
        "needTax",
        "isServiceInstall",
        "subTotalPrice",
        "taxPrice",
        "totalPrice",
        "paymentMethodId",
        "transactionCode",
        "transactionDetail",
        "transactionNote",
        "orderStatus",
        "orderNumber"
    ];
}
