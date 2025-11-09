<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = PaymentMethod::select(
            "id",
            "title",
            "accountName",
            "accountNumber",
            "image",
            "ordering",
            "isActive",
        )
            ->orderBy('ordering', 'desc')->get();

        return response()->json([
            'message' => 'Get Payment Method list success.',
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
            "title" => request("title", null),
            "accountName" => request("accountName", null),
            "accountNumber" => request("accountNumber", null),
            "image" => request("image", null),
            "ordering" => request("ordering", 0),
            "isActive" => request("isActive", true)
        ];

        $result = $this->_onSave($request->id, $dataForm);

        if (!$result) {
            return response()->json([
                'message' => 'Save record is failed.',
                'status' => 'failed'
            ], 200);
        }

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
        $model = PaymentMethod::findOrFail($request->id);
        return response()->json([
            'message' => 'Get PaymentMethod detail success.',
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
        $model = PaymentMethod::findOrFail($id);
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
                PaymentMethod::where('id', $id)->update($data);
            } else {
                PaymentMethod::create($data);
            }
        } catch (Exception $error) {
            Log::info('Error: ' . $error->getMessage());
            return false;
        }
        return true;
    }
}
