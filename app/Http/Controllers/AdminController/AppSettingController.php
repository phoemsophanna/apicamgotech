<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class AppSettingController extends Controller
{
    public function index($type)
    {
        $model = AppSetting::where('type', 'LIKE', $type)->first();
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
            case 'PRIVACY_POLICY':
                $item = $this->_privacy($req);
                break;
            default:
                $item = [];
                break;
        }

        $model = AppSetting::where('type', $req->type)->first();
        if ($model) {
            $model->update(["content" => json_encode($item)]);
        } else {
            AppSetting::create(["type" => $req->type, "content" => json_encode($item)]);
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
            "aboutCompanyKm" => $body->aboutCompanyKm ?: "",
            "aboutCompanyCn" => $body->aboutCompanyCn ?: "",
            "address" => $body->address ?: "",
            "addressKm" => $body->addressKm ?: "",
            "addressCn" => $body->addressCn ?: "",
            "email" => $body->email ?: "",
            "website" => $body->website ?: "",
            "smartNumber" => $body->smartNumber ?: "",
            "cellcardNumber" => $body->cellcardNumber ?: "",
            "facebook" => $body->facebook ?: "",
            "telegram" => $body->telegram ?: "",
            "linkedin" => $body->linkedin ?: "",
            "tiktok" => $body->tiktok ?: "",
            "thumbnail" => $body->thumbnail ?: "",
            "headerThumbnail" => $body->headerThumbnail ?: "",
        ];
    }
    
    private function _privacy(Request $body)
    {
        return [
            "title" => $body->title ?: "",
            "description" => $body->description ?: ""
        ];
    }
}
