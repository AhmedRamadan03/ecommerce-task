<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Traits\ApiResponseTrait;


class AuthController extends Controller
{

    use ApiResponseTrait;

    public function register(RegisterRequest  $request)
    {
        $data = $request->validated();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role'=> $data['role']??'customer',
            'password' => bcrypt($data['password']),
        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        return $this->successResponse([
            'user' => $user,
            'token' => $token,
        ], 'User registered successfully.', 201);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        if (! $user || ! Hash::check($data['password'], $user->password)) {
                return $this->errorResponse('Invalid email or password.', [], 401);

        }

        $token = $user->createToken('api_token')->plainTextToken;

         return $this->successResponse([
            'user' => $user,
            'token' => $token,
        ], 'Logged in successfully.');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->successResponse([], 'Logged out successfully.');
    }

    public function me(Request $request)
    {
        return $this->successResponse([
            'user' => $request->user(),
        ], 'User info retrieved.');
    }
}
