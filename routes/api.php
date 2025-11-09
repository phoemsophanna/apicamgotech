<?php

use App\Http\Controllers as API;
use App\Http\Controllers\AdminController as Admin;
use App\Http\Controllers\FileStorageController;
use App\Http\Controllers\Website\ArticlePageController;
use App\Http\Controllers\Website\CareerPageController;
use App\Http\Controllers\Website\HomepageController;
use App\Http\Controllers\Website\ProjectPageController;
use App\Http\Controllers\Website\ServicePageController;
use App\Http\Controllers\Website\WebPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('/login', [API\AuthController::class, 'login']);
    Route::post('/register', [API\AuthController::class, 'register']);
    Route::post('/logout', [API\AuthController::class, 'logout']);
    Route::get('/user-profile', [API\AuthController::class, 'userProfile']);
    Route::put('/update-user', [API\AuthController::class, 'updateUser']);
    Route::put('/change-password', [API\AuthController::class, 'changeAuth']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'users'
], function () {
    Route::get("/", [API\UserController::class, "index"]);
    Route::post("/", [API\UserController::class, "store"]);
    Route::get("/detail", [API\UserController::class, "show"]);
    Route::delete("/delete/{id}", [API\UserController::class, "destroy"]);
});

Route::group(['middleware' => 'api', 'prefix' => 'services'], function () {
    Route::get("/", [Admin\ServiceController::class, "index"]);
    Route::post("/", [Admin\ServiceController::class, "store"]);
    Route::get("/detail", [Admin\ServiceController::class, "show"]);
    Route::delete("/delete/{id}", [Admin\ServiceController::class, "destroy"]);
});

Route::group(['middleware' => 'api', 'prefix' => 'performances'], function () {
    Route::get("/", [Admin\PerformanceController::class, "index"]);
    Route::post("/", [Admin\PerformanceController::class, "store"]);
    Route::get("/detail", [Admin\PerformanceController::class, "show"]);
    Route::delete("/delete/{id}", [Admin\PerformanceController::class, "destroy"]);
});

Route::group(['middleware' => 'api', 'prefix' => 'news'], function () {
    Route::get("/", [Admin\NewsController::class, "index"]);
    Route::post("/", [Admin\NewsController::class, "store"]);
    Route::get("/detail", [Admin\NewsController::class, "show"]);
    Route::delete("/delete/{id}", [Admin\NewsController::class, "destroy"]);
});
Route::group(['middleware' => 'api', 'prefix' => 'project-categories'], function () {
    Route::get("/", [Admin\ProjectCategoryController::class, "index"]);
    Route::post("/", [Admin\ProjectCategoryController::class, "store"]);
    Route::get("/detail", [Admin\ProjectCategoryController::class, "show"]);
    Route::delete("/delete/{id}", [Admin\ProjectCategoryController::class, "destroy"]);
});
Route::group(['middleware' => 'api', 'prefix' => 'projects'], function () {
    Route::get("/", [Admin\ProjectController::class, "index"]);
    Route::post("/", [Admin\ProjectController::class, "store"]);
    Route::get("/detail", [Admin\ProjectController::class, "show"]);
    Route::delete("/delete/{id}", [Admin\ProjectController::class, "destroy"]);
});
Route::group(['middleware' => 'api', 'prefix' => 'web-hosting'], function () {
    Route::get("/", [Admin\WebHostingController::class, "index"]);
    Route::post("/", [Admin\WebHostingController::class, "store"]);
    Route::get("/detail", [Admin\WebHostingController::class, "show"]);
    Route::get("/dropdown", [Admin\WebHostingController::class, "dropdown"]);
    Route::delete("/delete/{id}", [Admin\WebHostingController::class, "destroy"]);
});
Route::group(['middleware' => 'api', 'prefix' => 'performance-type'], function () {
    Route::get("/", [Admin\PerformanceTypeController::class, "index"]);
    Route::post("/", [Admin\PerformanceTypeController::class, "store"]);
    Route::get("/detail", [Admin\PerformanceTypeController::class, "show"]);
    Route::delete("/delete/{id}", [Admin\PerformanceTypeController::class, "destroy"]);
});
Route::group(['middleware' => 'api', 'prefix' => 'default-plan'], function () {
    Route::get("/", [Admin\DefaultPlanController::class, "index"]);
    Route::post("/", [Admin\DefaultPlanController::class, "store"]);
    Route::get("/detail", [Admin\DefaultPlanController::class, "show"]);
    Route::delete("/delete/{id}", [Admin\DefaultPlanController::class, "destroy"]);
});
Route::group(['middleware' => 'api', 'prefix' => 'testimonials'], function () {
    Route::get("/", [Admin\TestimonialController::class, "index"]);
    Route::post("/", [Admin\TestimonialController::class, "store"]);
    Route::get("/detail", [Admin\TestimonialController::class, "show"]);
    Route::delete("/delete/{id}", [Admin\TestimonialController::class, "destroy"]);
});
Route::group(['middleware' => 'api', 'prefix' => 'technologies'], function () {
    Route::get("/", [Admin\TechnologyController::class, "index"]);
    Route::post("/", [Admin\TechnologyController::class, "store"]);
    Route::get("/detail", [Admin\TechnologyController::class, "show"]);
    Route::delete("/delete/{id}", [Admin\TechnologyController::class, "destroy"]);
});
Route::group(['middleware' => 'api', 'prefix' => 'banners'], function () {
    Route::get("/", [Admin\BannerController::class, "index"]);
    Route::post("/", [Admin\BannerController::class, "store"]);
    Route::get("/detail", [Admin\BannerController::class, "show"]);
    Route::delete("/delete/{id}", [Admin\BannerController::class, "destroy"]);
});
Route::group(['middleware' => 'api', 'prefix' => 'skillsets'], function () {
    Route::get("/", [Admin\SkillsetController::class, "index"]);
    Route::post("/", [Admin\SkillsetController::class, "store"]);
    Route::get("/detail", [Admin\SkillsetController::class, "show"]);
    Route::delete("/delete/{id}", [Admin\SkillsetController::class, "destroy"]);
});
Route::group(['middleware' => 'api', 'prefix' => 'faqs'], function () {
    Route::get("/", [Admin\FaqController::class, "index"]);
    Route::post("/", [Admin\FaqController::class, "store"]);
    Route::get("/detail", [Admin\FaqController::class, "show"]);
    Route::delete("/delete/{id}", [Admin\FaqController::class, "destroy"]);
});
Route::group(['middleware' => 'api', 'prefix' => 'careers'], function () {
    Route::get("/", [Admin\CareerController::class, "index"]);
    Route::post("/", [Admin\CareerController::class, "store"]);
    Route::get("/detail", [Admin\CareerController::class, "show"]);
    Route::delete("/delete/{id}", [Admin\CareerController::class, "destroy"]);
});
Route::group(['middleware' => 'api', 'prefix' => 'page-banners'], function () {
    Route::get("/", [Admin\PageBannerController::class, "index"]);
    Route::post("/", [Admin\PageBannerController::class, "store"]);
    Route::get("/detail", [Admin\PageBannerController::class, "show"]);
    Route::delete("/delete/{id}", [Admin\PageBannerController::class, "destroy"]);
});

Route::group(['middleware' => 'api', 'prefix' => 'site-setting'], function () {
    Route::post('/', [Admin\SiteSettingController::class, 'onSave']);
    Route::get('/{type}', [Admin\SiteSettingController::class, 'index']);
});

Route::post("/save-image/{dir}", [FileStorageController::class, "uploadImage"]);
Route::post("/save-content-image", [FileStorageController::class, "uploadContent"]);
Route::delete("/save-image/{dir}", [FileStorageController::class, "deleteImage"]);
Route::get("/save-image/{dir}", [FileStorageController::class, "previewImage"]);
// Website
Route::get("/sliders", [HomepageController::class, "sliders"]);
Route::get("/homepage", [HomepageController::class, "index"]);
Route::get("/sliders", [HomepageController::class, "sliders"]);
Route::get("/homepage/sliders", [HomepageController::class, "sliders"]);
Route::get("/service-page", [ServicePageController::class, "index"]);
Route::get("/service-detail/{id}", [ServicePageController::class, "show"]);
Route::get("/project-page", [ProjectPageController::class, "index"]);
Route::get("/project-detail/{id}", [ProjectPageController::class, "show"]);
Route::get("/project-list", [ProjectPageController::class, "list"]);
Route::get("/career-page", [CareerPageController::class, "index"]);
Route::get("/career-detail/{id}", [CareerPageController::class, "show"]);
Route::get("/article-page", [ArticlePageController::class, "index"]);
Route::get("/article-detail/{id}", [ArticlePageController::class, "show"]);
Route::get("/testimonial-page", [WebPageController::class, "testimonialPage"]);
Route::get("/web-hosting-page", [WebPageController::class, "webHostingPage"]);
Route::get("/about-us-page", [WebPageController::class, "aboutUsPage"]);
Route::get("/faq-page", [WebPageController::class, "faqPage"]);
Route::group(['middleware' => [ 'cors'], 'prefix' => "sending-email"], function() {
    Route::post("/", [WebPageController::class, "sendingEmail"]);
});
Route::get("/contact-us-page", [WebPageController::class, "contactUs"]);
Route::get("/privacy-policy-page", [WebPageController::class, "privacyPolicy"]);
Route::get("/term-service-page", [WebPageController::class, "termService"]);
