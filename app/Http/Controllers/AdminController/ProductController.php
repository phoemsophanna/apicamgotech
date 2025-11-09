<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductOption;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = Product::select("id", "productCode", "brandId", "categoryId", "title", "fromPrice", "toPrice", "stock", "images", "ordering", "isActive", "isNewProduct")
            ->orderBy('id', 'asc')->get();

        $data->each(function ($query) {
            $images = json_decode($query->images);
            $query->image = count($images) > 0 ? $images[0] : null;
            $query->productBrand = Brand::select("id", "title")->where("id", $query->brandId)->first();
            $query->productCategory = Category::select("id", "title")->where("id", $query->categoryId)->first();
            $query->countOption = ProductOption::where('productId', $query->id)->count();
            $query->makeHidden(["images", "brandId", "categoryId"]);
        });

        return response()->json([
            'message' => 'Get Product list success.',
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $images = $request->images ? json_encode($request->images) : json_encode([]);
        $dataForm = [
            "brandId" => $request->productBrand ? $request->productBrand["value"] : null,
            "categoryId" => $request->productCategory ? $request->productCategory["value"] : null,
            "productCode" => request("productCode", null),
            "title" => request("title", null),
            "titleKm" => request("titleKm", null),
            "titleCn" => request("titleCn", null),
            "description" => request("description", null),
            "descriptionKm" => request("descriptionKm", null),
            "descriptionCn" => request("descriptionCn", null),
            "fromPrice" => request("fromPrice", 0),
            "toPrice" => request("toPrice", 0),
            "stock" => request("stock", 0),
            "images" => $images,
            "video_link" => request("video_link", null),
            "slideNumber" => request("slideNumber", 0),
            "isNewProduct" => request("isNewProduct", false),
            "ordering" => request("ordering", 0),
            "isActive" => request("isActive", true),
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
            'status' => 'success',
            'id' => $result->id
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $model = Product::findOrFail($request->id);
        $model->images = json_decode($model->images);
        $brand = Brand::where("id", $model->brandId)->first();
        $category = Category::where("id", $model->categoryId)->first();
        $model["productBrand"] = $brand ? ["value" => $brand->id, "label" => $brand->title, "selected" => true] : null;
        $model["productCategory"] = $category ? ["value" => $category->id, "label" => $category->title, "selected" => true] : null;
        return response()->json([
            'message' => 'Get Product detail success.',
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
        $model = Product::findOrFail($id);
        $model->delete();
        return response()->json([
            'message' => 'Delete successfully.',
            'status' => 'success'
        ], 200);
    }

    public function dropdown()
    {
        $brand = Brand::select("id", "title")->where([["isActive", true]])->orderBy("ordering", "asc")->get();
        $brand->each(function ($query) {
            $query->categories = Category::select("id", "title")->where([["isActive", true], ["brandId", $query->id]])->orderBy("ordering", "asc")->get();
        });
        return response()->json([
            "message" => "Fetch record successfully",
            "status" => "success",
            "data" => $brand
        ]);
    }

    private function _onSave($id, $data)
    {
        try {
            if ($id) {
                Product::where('id', $id)->update($data);
                return Product::where("id", $id)->first();
            } else {
                return Product::create($data);
            }
        } catch (Exception $error) {
            Log::info('Error: ' . $error->getMessage());
            return false;
        }
    }
}
