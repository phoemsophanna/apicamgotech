<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\News;
use App\Models\PageBanner;
use App\Models\Performance;
use App\Models\Project;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Technology;
use App\Models\Testimonial;
use App\Models\WebHosting;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        $whoWeAre = SiteSetting::where("type", "WHO_WE_ARE")->first();
        $service = SiteSetting::where("type", "SERVICE")->first();
        $whyChooseUs = SiteSetting::where("type", "WHY_CHOOSE_US")->first();
        $project = SiteSetting::where("type", "PROJECT")->first();
        $testimonial = SiteSetting::where("type", "TESTIMONIAL")->first();
        $webHosting = SiteSetting::where("type", "WEB_HOSTING")->first();
        $techNews = SiteSetting::where("type", "TECH_NEWS")->first();
        $meta = PageBanner::where("pageTitle", "HomePage")->first();

        return response()->json([
            "status" => "success",
            "message" => "Load data success",
            "meta" => $meta,
            "services" => Service::select("id", "title", "summary", "image")
                ->where([['isDisplayHomepage', true], ['isActive', true]])
                ->orderBy('ordering', 'asc')
                ->get(),
            "performances" => Performance::select("id", "title", "description", "image")->where([["isActive", true]])->orderBy('ordering', 'asc')->get(),
            "projects" => Project::select("id", "title", "image", "websiteLink", "facebookLink", "instagramLink", "telegramLink", "appStore", "playStore")
                ->where([['isDisplayHomepage', true], ["isActive", true]])
                ->orderBy('ordering', 'asc')
                ->get(),
            "testimonials" => Testimonial::select("id", "reviewerName", "reviewerPosition", "comment", "reviewerProfile")
                ->where([['isDisplayHomepage', true], ["isActive", true]])
                ->orderBy('ordering', 'asc')
                ->get(),
            "hostingList" => WebHosting::select(
                "id",
                "type",
                "pricePerYear",
                "dataStorage",
                "bandwidth",
                "emailAccounts",
                "database",
                "domainAddOn",
                "maxHourlyEmailSend",
                "isFreeDomain",
                "isMostPopular",
                "isGoodSpeed"
            )
                ->where([['isDisplayHomepage', true], ["isActive", true]])
                ->orderBy('ordering', 'asc')
                ->get(),
            "articles" => News::select("id", "title", "image", "summary", "created_at", "updated_at")
                ->where([['isDisplayHomepage', true], ["isActive", true]])
                ->orderBy('ordering', 'asc')
                ->get(),
            "technologies" => Technology::select("id", "title", "image")->where([["isActive", true]])->orderBy('ordering', 'asc')->get(),
            "settings" => [
                "whoWeAre" => $whoWeAre ? json_decode($whoWeAre->content) : null,
                "service" => $service ? json_decode($service->content) : null,
                "whyChooseUs" => $whyChooseUs ? json_decode($whyChooseUs->content) : null,
                "project" => $project ? json_decode($project->content) : null,
                "testimonial" => $testimonial ? json_decode($testimonial->content) : null,
                "webHosting" => $webHosting ? json_decode($webHosting->content) : null,
                "techNews" => $techNews ? json_decode($techNews->content) : null,
            ]
        ], 200);
    }

    public function sliders()
    {
        $banners = Banner::select("id", "title", "subtitle", "description", "image", "linkLabel", "linkTo", "redirectNewTap")
            ->where([['isActive', true]])
            ->orderBy('ordering', 'asc')
            ->get();

        return response()->json([
            "status" => "success",
            "message" => "Load data success",
            "sliders" => $banners
        ], 200);
    }
}
