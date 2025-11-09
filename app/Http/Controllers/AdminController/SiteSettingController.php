<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index($type)
    {
        $model = SiteSetting::where('type', 'LIKE', $type)->first();
        if (!$model) {
            return response()->json([
                'message' => 'Get detail failed.',
                'status' => 'failed',
                'model' => null
            ], 200);
        }
        $model->content = json_decode($model->content);
        return response()->json([
            'message' => 'Get detail success.',
            'status' => 'success',
            'model' => $model
        ], 200);
    }

    public function onSave(Request $req)
    {
        $item = [];
        switch ($req->type) {
            case 'ABOUT_COMPANY':
                $item = $this->_aboutCompany($req);
                break;
            case 'WHO_WE_ARE':
                $item = $this->_whoWeAre($req);
                break;
            case 'OUR_GOAL':
                $item = $this->_ourGoal($req);
                break;
            case 'SKILLSET':
                $item = $this->_skillset($req);
                break;
            case 'SERVICE':
                $item = $this->_service($req);
                break;
            case 'WHY_CHOOSE_US':
                $item = $this->_whyChooseUs($req);
                break;
            case 'PROJECT':
                $item = $this->_project($req);
                break;
            case 'TESTIMONIAL':
                $item = $this->_testimonial($req);
                break;
            case 'WEB_HOSTING':
                $item = $this->_webHosting($req);
                break;
            case 'TECH_NEWS':
                $item = $this->_techNews($req);
                break;
            case 'CONTACT':
                $item = $this->_contact($req);
                break;
            case 'TERM_SERVICE':
                $item = $this->_termService($req);
                break;
            case 'PRIVACY_POLICY':
                $item = $this->_privacyPolicy($req);
                break;
            default:
                $item = [];
                break;
        }

        $model = SiteSetting::where('type', $req->type)->first();
        if ($model) {
            $model->update(["content" => json_encode($item)]);
        } else {
            SiteSetting::create(["type" => $req->type, "content" => json_encode($item)]);
        }

        return response()->json([
            'message' => 'Save record is successfully.',
            'status' => 'success'
        ], 200);
    }

    private function _aboutCompany(Request $body)
    {
        return [
            "companyName" => $body->companyName ?: "",
            "aboutCompany" => $body->aboutCompany ?: "",
            "thumbnail" => $body->thumbnail ?: ""
        ];
    }

    private function _whoWeAre(Request $body)
    {
        return [
            "title" => $body->title ?: "",
            "description" => $body->description ?: "",
            "thumbnail" => $body->thumbnail ?: ""
        ];
    }
    private function _skillset(Request $body)
    {
        return [
            "title" => $body->title ?: "",
            "description" => $body->description ?: "",
            "thumbnail" => $body->thumbnail ?: ""
        ];
    }
    private function _ourGoal(Request $body)
    {
        return [
            "title" => $body->title ?: "",
            "description" => $body->description ?: "",
            "thumbnail" => $body->thumbnail ?: "",
            "vision" => $body->vision ?: "",
            "mission" => $body->mission ?: "",
            "ourvalue" => $body->ourvalue ?: "",
            "thumbnailTwo" => $body->thumbnailTwo ?: ""
        ];
    }

    private function _service(Request $body)
    {
        return [
            "title" => $body->title ?: "",
            "description" => $body->description ?: ""
        ];
    }
    private function _whyChooseUs(Request $body)
    {
        return [
            "title" => $body->title ?: "",
            "description" => $body->description ?: ""
        ];
    }
    private function _project(Request $body)
    {
        return [
            "title" => $body->title ?: "",
            "description" => $body->description ?: ""
        ];
    }
    private function _testimonial(Request $body)
    {
        return [
            "title" => $body->title ?: "",
            "description" => $body->description ?: ""
        ];
    }
    private function _webHosting(Request $body)
    {
        return [
            "title" => $body->title ?: "",
            "description" => $body->description ?: ""
        ];
    }
    private function _techNews(Request $body)
    {
        return [
            "title" => $body->title ?: "",
            "description" => $body->description ?: ""
        ];
    }
    private function _contact(Request $body)
    {
        return [
            'email1' => $body->email1 ?: "",
            'email2' => $body->email2 ?: "",
            'phoneNumber1' => $body->phoneNumber1 ?: "",
            'phoneNumber2' => $body->phoneNumber2 ?: "",
            'address' => $body->address ?: "",
            'embedMap' => $body->embedMap ?: "",
            'facebookLink' => $body->facebookLink ?: "",
            'instagramLink' => $body->instagramLink ?: "",
            'telegramLink' => $body->telegramLink ?: "",
            'linkedinLink' => $body->linkedinLink ?: "",
            'appId' => $body->appId ?: "",
            'pageId' => $body->pageId ?: "",
            "thumbnail" => $body->thumbnail ?: "",
            "contactFormEmail" => $body->contactFormEmail ?: "",
        ];
    }
    private function _termService(Request $body)
    {
        return [
            "thumbnail" => $body->thumbnail ?: "",
            "description" => $body->description ?: ""
        ];
    }
    private function _privacyPolicy(Request $body)
    {
        return [
            "thumbnail" => $body->thumbnail ?: "",
            "description" => $body->description ?: ""
        ];
    }
}
