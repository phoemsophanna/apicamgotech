<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Testimonial::select("id", "reviewerName", "reviewerPosition", "reviewerProfile", "isDisplayHomepage", "ordering", "isActive")
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
            "reviewerName" => request("reviewerName", ""),
            "reviewerPosition" => request("reviewerPosition", ""),
            "comment" => request("comment", ""),
            "reviewerProfile" => request("reviewerProfile", ""),
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
        $model = Testimonial::findOrFail($request->id);
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
        $model = Testimonial::findOrFail($id);
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
                Testimonial::where('id', $id)->update($data);
            } else {
                Testimonial::create($data);
            }
        } catch (Exception $error) {
            Log::info('Error: ' . $error->getMessage());
            return false;
        }
        return true;
    }
}
