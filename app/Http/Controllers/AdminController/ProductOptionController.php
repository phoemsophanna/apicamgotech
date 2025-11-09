<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\ProductOption;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = ProductOption::select("id", "productId", "productCode", "title", "price", "stock", "image")
            ->where('productId', $request->id)
            ->orderBy('price', 'desc')->get();

        return response()->json([
            'message' => 'Get Product Option list success.',
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
            "productId" => request("productId", null),
            "productCode" => request("productCode", null),
            "title" => request("title", null),
            "titleKm" => request("titleKm", null),
            "titleCn" => request("titleCn", null),
            "price" => request("price", 0),
            "stock" => request("stock", 0),
            "image" => request("image", null),
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
        $model = ProductOption::findOrFail($request->id);
        return response()->json([
            'message' => 'Get Product Option detail success.',
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
        $model = ProductOption::findOrFail($id);
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
                ProductOption::where('id', $id)->update($data);
            } else {
                ProductOption::create($data);
            }
        } catch (Exception $error) {
            Log::info('Error: ' . $error->getMessage());
            return false;
        }
        return true;
    }
}
