<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\PageBanner;
use App\Models\Service;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class ArticlePageController extends Controller
{
    public function index()
    {
        $articles = News::select("id", "title", "image", "summary", "created_at", "updated_at")->where([["isActive", true]])->orderBy("ordering", "asc")->get();
        $techNews = SiteSetting::where("type", "TECH_NEWS")->first();
        $meta = PageBanner::where("pageTitle", "TechNewsPage")->first();
        return response()->json([
            "status" => "success",
            "message" => "Load data success",
            "articles" => $articles,
            "settings" => [
                "techNews" => $techNews ? json_decode($techNews->content) : null,
                "meta" => $meta
            ]
        ], 200);
    }

    public function show($id)
    {
        $articles = News::select("id", "title", "image", "summary", "created_at", "updated_at")->where([["isActive", true], ["id", "!=", $id]])->orderBy("id", "desc")->limit(3)->get();
        $services = Service::where([["isActive", true]])->orderBy("ordering", "asc")->get();
        $article = News::find($id);
        if (!$article) {
            return response()->json([
                "status" => "failed",
                "message" => "Load data failed",
                "article" => null
            ], 200);
        }

        return response()->json([
            "status" => "success",
            "message" => "Load data success",
            "article" => $article,
            "articles" => $articles,
            "services" => $services
        ], 200);
    }
}
