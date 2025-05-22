<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            if(!Auth::guard('web')->attempt($request->only('email', 'password')))
            {
                return response()->json([
                    'message' => 'Invalid credentials',
                    'data' => null
                ], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                    'message' => 'Login Berhasil',
                    'data' => [
                        'token' => $token,
                        'user' => new UserResource($user)
                    ]
                ], 200);
        } catch (Exception $e) {
            return response()->json([
                    'message' => 'Terjadi Kesalahan',
                    'massage' => $e->getMessage(),
                ], 500);
        }
    }

    public function me()
    {
        try {
            $user = Auth::user();
            return response()->json([
                    'message' => 'Profile User Behasil Diambil',
                    'data' => new UserResource($user)
                ], 200);
            
        } catch (Exception $e) {
            return response()->json([
                    'message' => 'Terjadi Kesalahan',
                    'massage' => $e->getMessage(),
                ], 500);
        }
    }

    public function logout()
    {
        try {
            $user = Auth::user();
            $user->currentAccessToken()->delete();

            return response()->json([
                    'message' => 'Berhasil Logout',
                    'data' => null
                ], 200);
        } catch (Exception $e) {
            return response()->json([
                    'message' => 'Terjadi Kesalahan',
                    'massage' => $e->getMessage(),
                ], 500);
        }
    }
}
