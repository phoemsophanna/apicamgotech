<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\WebHosting;
use App\Models\PerformanceType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebHostingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = WebHosting::select("id", "type", "pricePerYear", "dataStorage", "bandwidth", "database", "emailAccounts", "maxHourlyEmailSend", "isFreeDomain", "isMostPopular", "isGoodSpeed", "isActive")
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'message' => 'Get list success.',
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataForm = [
            "type" => request("type", ""),
            "pricePerYear" => request("pricePerYear", ""),
            "dataStorage" => request("dataStorage", ""),
            "bandwidth" => request("bandwidth", ""),
            "emailAccounts" => request("emailAccounts", ""),
            "database" => request("database", ""),
            "domainAddOn" => request("domainAddOn", ""),
            "maxHourlyEmailSend" => request("maxHourlyEmailSend", ""),
            "hostingGroup" => json_encode(request("hostingGroup", [])),
            "isFreeDomain" => request("isFreeDomain", false),
            "isMostPopular" => request("isMostPopular", false),
            "mostPopularColor" => request("mostPopularColor", null),
            "isGoodSpeed" => request("isGoodSpeed", false),
            "goodSpeedColor" => request("goodSpeedColor", null),
            "isDisplayHomepage" => request("isDisplayHomepage", false),
            "ordering" => request("ordering", 0),
            'isActive' => request("isActive", true)
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
            'status' => 'success'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $model = WebHosting::findOrFail($request->id);
        return response()->json([
            'message' => 'Get detail success.',
            'status' => 'success',
            'model' => $model
        ], 200);
    }
    
    public function dropdown()
    {
        $model = PerformanceType::select("id", "title")->where("isActive", true)->orderBy("ordering", "asc")->get();
        return response()->json([
            'message' => 'Get detail success.',
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
        $model = WebHosting::findOrFail($id);
        $model->delete();
        return response()->json([
            'message' => 'Delete successfully.',
            'status' => 'success'
        ], 200);
    }

    private function _onSave($id, $data)
    {
        try {
            if ($id) {
                WebHosting::where('id', $id)->update($data);
            } else {
                WebHosting::create($data);
            }
        } catch (Exception $error) {
            Log::info('Error: ' . $error->getMessage());
            return false;
        }
        return true;
    }
}
