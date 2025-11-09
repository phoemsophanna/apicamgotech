<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = User::select("id", "name", "email", "phoneNumber", "userRole", "image", "isActive")
            ->where('id', '!=', auth()->user()->id)
            ->where('id', '!=', 1)
            ->orderBy('id', 'desc')->get();

        return response()->json([
            'message' => 'Get user list success.',
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
            'name' => request('name', null),
            'email' => request('email', null),
            'phoneNumber' => request('phoneNumber', null),
            'userRole' => request('userRole', null),
            'image' => request('image', null),
            'isActive' => request("isActive", true)
        ];

        if ($request->password) {
            $dataForm['password'] = bcrypt($request->password);
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
        $model = User::findOrFail($request->id);
        return response()->json([
            'message' => 'Get user detail success.',
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
        $model = User::findOrFail($id);
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
                User::where('id', $id)->update($data);
            } else {
                User::create($data);
            }
        } catch (Exception $error) {
            Log::info('Error: ' . $error->getMessage());
            return false;
        }
        return true;
    }
}
