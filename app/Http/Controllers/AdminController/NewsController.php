<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\News;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = News::select("id", "title", "summary", "image", "isDisplayHomepage", "isActive", "ordering")->orderBy('id', 'desc')->get();

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
            "image" => request("image", null),
            "summary" => request("summary", ""),
            "content" => request("content", ""),
            "metaKeyword" => request("metaKeyword", ""),
            "metaDesc" => request("metaDesc", ""),
            "isDisplayHomepage" => request("isDisplayHomepage", false),
            "ordering" => request("ordering", 0),
            'isActive' => request("isActive", true)
        ];
        
        $news = News::where('id', $request->id)->first();
        if($news && $news->image != $dataForm["image"]){
            $this->sendNotification("Update Post Image: ". $request->id);
        }

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
        $model = News::findOrFail($request->id);
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
        $model = News::findOrFail($id);
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
                News::where('id', $id)->update($data);
            } else {
                News::create($data);
                $this->sendNotification("We have new posts");
            }
        } catch (Exception $error) {
            Log::info('Error: ' . $error->getMessage());
            return false;
        }
        return true;
    }
    
    private function sendNotification($message)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.telegram.org/bot6332218341:AAEZGnXc6jufb5iOpOWvl8qf2vpYDD2uGXo/sendMessage',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'chat_id' => '-1002058920837',
                'text' => $message,
                'parse_mode' => 'HTML'
            ),
        ));

        curl_exec($curl);

        curl_close($curl);
    }
}
