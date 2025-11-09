<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use App\Models\ProductOrder;
use App\Models\OrderItem;

class OrderService
{
    public static function checkProductSolds($productId)
    {
        $orderSuccess = ProductOrder::where("orderStatus", "COMPLETE")->pluck("id")->toArray();
        $solds = OrderItem::where("productId", $productId)->whereIn("orderId", $orderSuccess)->sum("quantity");
        return (int) $solds;
    }
}
