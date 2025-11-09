<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\PageBanner;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Skillset;
use Illuminate\Http\Request;

class ServicePageController extends Controller
{
    public function index()
    {
        $services = Service::select("id", "title", "summary", "image")->where([["isActive", true]])->orderBy('ordering', 'asc')->get();
        $skillsets = Skillset::select("id", "title", "percentage", "barColor")->where([["isActive", true]])->orderBy('ordering', 'asc')->get();

        $service = SiteSetting::where("type", "SERVICE")->first();
        $skillset = SiteSetting::where("type", "SKILLSET")->first();
        $meta = PageBanner::where("pageTitle", "ServicePage")->first();
        return response()->json([
            "status" => "success",
            "message" => "Load data success",
            "services" => $services,
            "skillsets" => $skillsets,
            "settings" => [
                "service" => $service ? json_decode($service->content) : null,
                "skillset" => $skillset ? json_decode($skillset->content) : null,
                "meta" => $meta
            ]
        ], 200);
    }

    public function show($id)
    {
        $model = Service::find($id);
        $relatedServices = Service::where([["isActive", true], ["id", "!=", $id]])->orderBy('ordering', 'asc')->get();
        $service = SiteSetting::where("type", "SERVICE")->first();
        if (!$model) {
            return response()->json([
                "status" => "failed",
                "message" => "Load data failed",
                "data" => null,
                "relatedServices" => []
            ], 200);
        }
        return response()->json([
            "status" => "success",
            "message" => "Load data success",
            "data" => $model,
            "relatedServices" => $relatedServices,
            "settings" => [
                "service" => $service ? json_decode($service->content) : null
            ]
        ], 200);
    }
}
