<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = Brand::select("id", "title", "titleKm", "titleCn", "image", "ordering", "isActive")
            ->orderBy('id', 'desc')->get();

        $data->each(function ($q) {
            $q->countCategory = Category::where("brandId", $q->id)->where('isActive', true)->count();
        });

        return response()->json([
            'message' => 'Get Brand list success.',
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
            "titleKm" => request("titleKm", null),
            "titleCn" => request("titleCn", null),
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
        $model = Brand::findOrFail($request->id);
        return response()->json([
            'message' => 'Get Brand detail success.',
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
        $model = Brand::findOrFail($id);
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
                Brand::where('id', $id)->update($data);
            } else {
                Brand::create($data);
            }
        } catch (Exception $error) {
            Log::info('Error: ' . $error->getMessage());
            return false;
        }
        return true;
    }
}
