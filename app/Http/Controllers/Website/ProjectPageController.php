<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\PageBanner;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ProjectPageController extends Controller
{
    public function index()
    {
        $projectCategory = ProjectCategory::select("id", "name")->where('isActive', true)->orderBy("ordering", "asc")->get();
        $project = SiteSetting::where("type", "PROJECT")->first();
        $meta = PageBanner::where("pageTitle", "ProjectPage")->first();
        return response()->json([
            "status" => "success",
            "message" => "Load data success",
            "projectCategory" => $projectCategory,
            "projects" => [],
            "settings" => [
                "project" => $project ? json_decode($project->content) : null,
                "meta" => $meta
            ]
        ], 200);
    }
    
    // public function index()
    // {
    //     $projectCategory = ProjectCategory::select("id", "name")->where('isActive', true)->orderBy("ordering", "asc")->get();
        
    //     $project = SiteSetting::where("type", "PROJECT")->first();
    //     return response()->json([
    //         "status" => "success",
    //         "message" => "Load data success",
    //         "projectCategory" => $projectCategory,
    //         "settings" => [
    //             "project" => $project ? json_decode($project->content) : null,
    //         ]
    //     ], 200);
    // }

    public function list(Request $request)
    {
        $size = $request->size ?: 8;
        $projects = Project::select("id", "title", "image", "category_id", "websiteLink", "appStore", "playStore", "facebookLink", "instagramLink", "telegramLink")
                            ->where([["isActive", true]])
                            ->orderBy("ordering", "asc")
                            ->get();

        return response()->json([
            "status" => "success",
            "message" => "Load data success",
            "projects" => $projects
        ], 200);
    }

    public function show($id)
    {
        $project = Project::with("category")->find($id);
        if (!$project) {
            return response()->json([
                "status" => "failed",
                "message" => "Load data failed",
                "project" => null
            ], 200);
        }

        return response()->json([
            "status" => "success",
            "message" => "Load data success",
            "project" => $project
        ], 200);
    }
}
