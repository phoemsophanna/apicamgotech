<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['status' => 'fail', 'message' => "Email or password is incorrect."], 202);
        }
        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }

    public function updateUser(Request $request)
    {
        $user = auth()->user();
        $newUser = User::find($user->id);
        $newUser->update([
            'name' => request("name", $user->name),
            'email' => request("email", $user->email),
            'phoneNumber' => request('phoneNumber', $user->phoneNumber),
            'userRole' => request('userRole', $user->userRole),
            'image' => request('image', $user->image),
        ]);
        return response()->json([
            "message" => 'success',
            "data" => $newUser
        ]);
    }

    public function changeAuth(Request $request)
    {
        $user = auth()->user();
        $newUser = User::find($user->id);
        $newUser->update([
            'password' => bcrypt($request->newPassword)
        ]);
        return response()->json([
            "message" => 'success',
            "data" => $newUser
        ]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'status' => 'success',
            'token' => $token,
            'tokenType' => 'bearer',
            'expiresIn' => auth()->factory()->getTTL() * 60,
            'data' => auth()->user()
        ]);
    }
}
