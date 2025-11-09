<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrder = ProductOrder::count();
        $newOrder = ProductOrder::where("orderStatus", "PENDING")->count();

        $totalProduct = Product::where("isActive", true)->count();
        $orderSuccess = ProductOrder::where("orderStatus", "COMPLETE")->get();
        $productSold = 0;
        foreach ($orderSuccess as $order) {
            $orderItems = OrderItem::where("orderId", $order->id)->get();
            foreach ($orderItems as $item) {
                $productSold = $productSold + $item->quantity;
            }
        }

        return response()->json([
            'message' => 'Get Brand detail success.',
            'status' => 'success',
            'model' => [
                [
                    "id" => 1,
                    "feaIcon" => "package",
                    "feaIconClass" => "primary",
                    "label" => "Total Product",
                    "badgeClass" => "",
                    "icon" => "ri-arrow-down-s-line",
                    "percentage" => "",
                    "caption" => "All active products",
                    "subCounter" => [[
                        "id" => 1,
                        "counter" => Product::where("isActive", true)->count(),
                        "suffix" => "",
                        "separator" => ","
                    ]],
                ],
                [
                    "id" => 2,
                    "feaIcon" => "dollar-sign",
                    "feaIconClass" => "dark",
                    "label" => "Product Sold",
                    "badgeClass" => "",
                    "icon" => "",
                    "percentage" => '',
                    "caption" => "Products have been sold.",
                    "subCounter" => [[
                        "id" => 1,
                        "counter" => $productSold,
                        "suffix" => "",
                        "separator" => ","
                    ]],
                ],
                [
                    "id" => 3,
                    "feaIcon" => "shopping-bag",
                    "feaIconClass" => "info",
                    "label" => "Total Order",
                    "badgeClass" => "",
                    "icon" => "ri-arrow-up-s-line",
                    "percentage" => "",
                    "caption" => "All customer order",
                    "subCounter" => [[
                        "id" => 1,
                        "counter" => $totalOrder,
                        "suffix" => "",
                        "separator" => ","
                    ]],
                ],
                [
                    "id" => 4,
                    "feaIcon" => "clock",
                    "feaIconClass" => "warning",
                    "label" => "New Orders",
                    "badgeClass" => "success",
                    "icon" => "",
                    "percentage" => ($totalOrder > 0 ? number_format(($newOrder / $totalOrder) * 100, 2)  : "0.00") . " %",
                    "caption" => "New order product",
                    "subCounter" => [[
                        "id" => 1,
                        "counter" => $newOrder,
                        "suffix" => "",
                        "separator" => ","
                    ]],
                ],
            ]
        ], 200);
    }
}
