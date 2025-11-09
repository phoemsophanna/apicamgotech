<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\PageBanner;
use App\Models\Performance;
use App\Models\SiteSetting;
use App\Models\Skillset;
use App\Models\Technology;
use App\Models\Testimonial;
use App\Models\WebHosting;
use Illuminate\Http\Request;
use App\Models\DefaultPlan;
use App\Models\PerformanceType;

class WebPageController extends Controller
{
    public function testimonialPage()
    {
        $meta = PageBanner::where("pageTitle", "TestimonialPage")->first();
        return response()->json([
            "status" => "success",
            "message" => "Load data success",
            "testimonials" => Testimonial::where([["isActive", true]])->orderBy('ordering', 'asc')->get(),
            "meta" => $meta
        ], 200);
    }
    public function webHostingPage()
    {
        $webHosting = SiteSetting::where("type", "WEB_HOSTING")->first();
        $meta = PageBanner::where("pageTitle", "WebHostingPage")->first();
        return response()->json([
            "status" => "success",
            "message" => "Load data success",
            "meta" => $meta,
            "defaultPlan" => DefaultPlan::where("isActive", true)->orderBy("ordering", 'asc')->get(),
            "hostingGroup" => PerformanceType::where("isActive", true)->orderBy("ordering", 'asc')->get(),
            "hostingList" => WebHosting::where([["isActive", true]])->orderBy('ordering', 'asc')->get(),
            "settings" => [
                "webHosting" => $webHosting ? json_decode($webHosting->content) : null,
            ]
        ], 200);
    }
    public function aboutUsPage()
    {
        $whoWeAre = SiteSetting::where("type", "WHO_WE_ARE")->first();
        $ourGoal = SiteSetting::where("type", "OUR_GOAL")->first();
        $whyChooseUs = SiteSetting::where("type", "WHY_CHOOSE_US")->first();
        $skillset = SiteSetting::where("type", "SKILLSET")->first();
        $meta = PageBanner::where("pageTitle", "AboutPage")->first();
        return response()->json([
            "status" => "success",
            "message" => "Load data success",

            "performances" => Performance::where([["isActive", true]])->orderBy('ordering', 'asc')->get(),
            "skillsets" => Skillset::where([["isActive", true]])->orderBy('ordering', 'asc')->get(),
            "technologies" => Technology::where([["isActive", true]])->orderBy('ordering', 'asc')->get(),
            "settings" => [
                "whoWeAre" => $whoWeAre ? json_decode($whoWeAre->content) : null,
                "ourGoal" => $ourGoal ? json_decode($ourGoal->content) : null,
                "whyChooseUs" =>  $whyChooseUs ? json_decode($whyChooseUs->content) : null,
                "skillset" =>  $skillset ? json_decode($skillset->content) : null,
                "meta" => $meta
            ]
        ], 200);
    }
    public function faqPage()
    {
        $contact = SiteSetting::where("type", "CONTACT")->first();
        $meta = PageBanner::where("pageTitle", "FaqPage")->first();
        return response()->json([
            "status" => "success",
            "message" => "Load data success",
            "faqs" => Faq::where([["isActive", true]])->orderBy('ordering', 'asc')->get(),
            "contact" => $contact ? json_decode($contact->content) : null,
            "meta" => $meta
        ], 200);
    }
    public function privacyPolicy()
    {
        $privacyPolicy = SiteSetting::where("type", "PRIVACY_POLICY")->first();
        $meta = PageBanner::where("pageTitle", "PrivacyPolicyPage")->first();
        return response()->json([
            "status" => "success",
            "message" => "Load data success",
            "privacyPolicy" => $privacyPolicy ? json_decode($privacyPolicy->content) : null,
            "meta" => $meta
        ], 200);
    }
    public function termService()
    {
        $termService = SiteSetting::where("type", "TERM_SERVICE")->first();
        $meta = PageBanner::where("pageTitle", "TermsofServicePage")->first();
        return response()->json([
            "status" => "success",
            "message" => "Load data success",
            "termService" => $termService ? json_decode($termService->content) : null,
            "meta" => $meta
        ], 200);
    }

    public function contactUs()
    {
        $contact = SiteSetting::where("type", "CONTACT")->first();
        $aboutCompany = SiteSetting::where("type", "ABOUT_COMPANY")->first();
        $pageBanners = PageBanner::where("isActive", true)->get();
        $meta = PageBanner::where("pageTitle", "ContactPage")->first();
        $pageBanner = null;
        foreach ($pageBanners as $page) {
            $pageBanner[$page->pageTitle] = $page->image;
        }

        return response()->json([
            "status" => "success",
            "message" => "Load data success",
            "contact" => $contact ? json_decode($contact->content) : null,
            "aboutCompany" => $aboutCompany ? json_decode($aboutCompany->content) : null,
            "pageBanner" => $pageBanner,
            "meta" => $meta
        ], 200);
    }

    public function sendingEmail(Request $request)
    {
        $contact = SiteSetting::where("type", "CONTACT")->first();
        $contactForm = $contact ? json_decode($contact->content) : null;

        $email = $request->email;
        $subject = $request->subject;
        \Mail::send(
            'email',
            array(
                'name' => $request->name,
                'email' => $email,
                'number' => $request->number,
                'subject' => $subject,
                'text' => $request->text,
            ),
            function ($message) use ($email, $subject, $contactForm) {
                $message->from('contact-form@camgotech.com');
                $message->subject($subject);
                $message->to($contactForm ? $contactForm->contactFormEmail : 'info@camgotech.com');
            }
        );

        return response(['status' => true, 'message' => "Send Email Successfully"]);
    }
}
