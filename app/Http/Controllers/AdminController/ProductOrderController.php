<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\OrderHistory;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = ProductOrder::select(
            "id",
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
            "orderNumber",
            "created_at"
        )
            ->orderBy('id', 'desc')->get();

        $data->each(function ($query) {
            $query->totalItems = OrderItem::where("orderId", $query->id)->count();
            $query->orderAt = Carbon::parse($query->created_at)->format("D, d M Y - H:i A");
            $paymentMethod = PaymentMethod::where("id", $query->paymentMethodId)->first();
            $query->paymentMethodTitle = $paymentMethod ? $paymentMethod->title : null;
            $query->makeHidden(["created_at", "paymentMethodId"]);
        });

        return response()->json([
            'message' => 'Get Product Order list success.',
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataForm = [
            "orderStatus" => request("orderStatus", "PENDING"),
        ];

        $result = $this->_onSave($request->id, $dataForm);

        if (!$result) {
            return response()->json([
                'message' => 'Save record is failed.',
                'status' => 'failed'
            ], 200);
        }

        OrderHistory::create([
            "userId" => auth()->user()->id,
            "orderId" => $request->id,
            "orderStatus" => request("orderStatus", null),
            "message" => request("message", null)
        ]);

        return response()->json([
            'message' => 'Save record is successfully.',
            'status' => 'success'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $model = ProductOrder::findOrFail($request->id);
        $model->orderAt = Carbon::parse($model->created_at)->format("D, d M Y - H:i A");
        $model->customer = User::select("id", "name", "email", "phone", "address", "image")->where("id", $model->userId)->first();
        $paymentMethod = PaymentMethod::where("id", $model->paymentMethodId)->first();
        $model->paymentMethodTitle = $paymentMethod ? $paymentMethod->title : null;
        $model->products = OrderItem::select(
            "id",
            "productId",
            "productOptionId",
            "productName",
            "productNameKm",
            "productNameCn",
            "productCode",
            "productPrice",
            "productImage",
            "quantity"
        )->where("orderId", $request->id)->get();

        $orderPending = OrderHistory::select("id", "orderStatus", "message", "created_at")->where([["orderId", $request->id], ["orderStatus", "PENDING"]])->first();
        if ($orderPending) {
            $orderPending->date = Carbon::parse($orderPending->created_at)->format("D, d M Y");
            $orderPending->time = Carbon::parse($orderPending->created_at)->format("H:i A");
            $orderPending->makeHidden(["created_at"]);
        }
        $orderPickup = OrderHistory::select("id", "orderStatus", "message", "created_at")->where([["orderId", $request->id], ["orderStatus", "PICKUP"]])->first();
        if ($orderPickup) {
            $orderPickup->date = Carbon::parse($orderPickup->created_at)->format("D, d M Y");
            $orderPickup->time = Carbon::parse($orderPickup->created_at)->format("H:i A");
            $orderPickup->makeHidden(["created_at"]);
        }
        $orderShipping = OrderHistory::select("id", "orderStatus", "message", "created_at")->where([["orderId", $request->id], ["orderStatus", "SHIPPING"]])->first();
        if ($orderShipping) {
            $orderShipping->date = Carbon::parse($orderShipping->created_at)->format("D, d M Y");
            $orderShipping->time = Carbon::parse($orderShipping->created_at)->format("H:i A");
            $orderShipping->makeHidden(["created_at"]);
        }
        $orderCancel = OrderHistory::select("id", "orderStatus", "message", "created_at")->where([["orderId", $request->id], ["orderStatus", "CANCEL"]])->first();
        if ($orderCancel) {
            $orderCancel->date = Carbon::parse($orderCancel->created_at)->format("D, d M Y");
            $orderCancel->time = Carbon::parse($orderCancel->created_at)->format("H:i A");
            $orderCancel->makeHidden(["created_at"]);
        }
        $orderComplete = OrderHistory::select("id", "orderStatus", "message", "created_at")->where([["orderId", $request->id], ["orderStatus", "COMPLETE"]])->first();
        if ($orderComplete) {
            $orderComplete->date = Carbon::parse($orderComplete->created_at)->format("D, d M Y");
            $orderComplete->time = Carbon::parse($orderComplete->created_at)->format("H:i A");
            $orderComplete->makeHidden(["created_at"]);
        }

        $appSetting = AppSetting::select("id", "type", "content")
            ->where("type", "ABOUT_COMPANY")
            ->first();

        $model->about = $appSetting ? json_decode($appSetting->content) : null;
        $model->orderPending = $orderPending;
        $model->orderPickup = $orderPickup;
        $model->orderShipping = $orderShipping;
        $model->orderCancel = $orderCancel;
        $model->orderComplete = $orderComplete;

        return response()->json([
            'message' => 'Get Product Order detail success.',
            'status' => 'success',
            'model' => $model
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = ProductOrder::findOrFail($id);
        $model->delete();
        return response()->json([
            'message' => 'Delete successfully.',
            'status' => 'success'
        ], 200);
    }

    private function _onSave($id, $data)
    {
        try {
            if ($id) {
                ProductOrder::where('id', $id)->update($data);
            } else {
                ProductOrder::create($data);
            }
        } catch (Exception $error) {
            Log::info('Error: ' . $error->getMessage());
            return false;
        }
        return true;
    }
}
