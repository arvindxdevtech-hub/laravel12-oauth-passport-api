<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $response = $this->authService->register(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully.',
            'data' => $response,
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $response = $this->authService->login(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'data' => $response,
        ], 200);
    }

    public function profile(Request $request)
    {
        $user = $request->user();
        $user_info = [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
        ];
        return response()->json([
            'success' => true,
            'data' => $user_info,
        ]);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return response()->json([
            'success' => true,
            'message' => 'Logout successfully.',
        ]);
    }
}
