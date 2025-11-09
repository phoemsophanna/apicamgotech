<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\PageBanner;

class CareerPageController extends Controller
{
    public function index()
    {
        $careers = Career::where([["isActive", true]])->orderBy('ordering', 'asc')->get();
        $meta = PageBanner::where("pageTitle", "CareerPage")->first();
        return response()->json([
            "status" => "success",
            "message" => "Load data success",
            "careers" => $careers,
            "meta" => $meta
        ], 200);
    }

    public function show($id)
    {
        $model = Career::find($id);
        if (!$model) {
            return response()->json([
                "status" => "failed",
                "message" => "Load data failed",
                "data" => null,
                "relatedCareers" => []
            ], 200);
        }
        return response()->json([
            "status" => "success",
            "message" => "Load data success",
            "data" => $model
        ], 200);
    }
}
