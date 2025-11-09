<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = Project::select("id", "title", "category_id", "inProgress", "isDisplayHomepage", "isActive", "ordering")->with('category')->orderBy('id', 'desc')->get();

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
            "title" => request("title", ""),
            "content" => request("content", ""),
            "image" => request("image", null),
            "category_id" => request("category_id", null),
            "client" => request("client", null),
            "fromDate" => $request->fromDate ? Carbon::parse(request("fromDate", null))->format("Y-m-d") : null,
            "toDate" =>  $request->toDate ? Carbon::parse(request("toDate", null))->format("Y-m-d") : null,
            "location" => request("location", null),
            "websiteLink" => request("websiteLink", null),
            "facebookLink" => request("facebookLink", null),
            "instagramLink" => request("instagramLink", null),
            "telegramLink" => request("telegramLink", null),
            "appStore" => request("appStore", null),
            "playStore" => request("playStore", null),
            "inProgress" => request("inProgress", false),
            "isDisplayHomepage" => request("isDisplayHomepage", false),
            "ordering" => request("ordering", 0),
            'isActive' => request("isActive", true)
        ];
        Log::info($dataForm);

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
        $model = Project::findOrFail($request->id);
        $model->projectCategory = $model->category ? [
            "value" => $model->category->id,
            "label" => $model->category->name,
        ] : null;
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
        $model = Project::findOrFail($id);
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
                Project::where('id', $id)->update($data);
            } else {
                Project::create($data);
            }
        } catch (Exception $error) {
            Log::info('Error: ' . $error->getMessage());
            return false;
        }
        return true;
    }
}
