<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserLoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(UserCreateRequest $request): JsonResponse
    {
        try {
            $user = User::query()->create([
                "name" => $request["name"],
                "email" => $request["email"],
                "password" => Hash::make($request["password"]),
            ]);

            if ($user) {
                $token = $user->createToken("api_token");

                return response()->json(
                    [
                        "token_type" => 'Bearer',
                        "token" => $token->plainTextToken,
                        "message" => "Successfully registered",
                    ],
                    Response::HTTP_CREATED,
                );
            }
        } catch (Exception $e) {
            Log::error(printf("Register Error: %s", $e->getMessage()), [
                "request" => $request->attributes(),
            ]);
        }

        return response()->json(
            ["message" => "Error trying to register user!"],
            Response::HTTP_INTERNAL_SERVER_ERROR,
        );
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        try {
            $attemptLogin = Auth::attempt([
                "email" => $request["email"],
                "password" => $request["password"],
            ]);

            if (!$attemptLogin) {
                return response()->json(
                    ["message" => "Unauthorized"],
                    Response::HTTP_UNAUTHORIZED,
                );
            }

            $user = Auth::user();

            return response()->json([
                "token_type" => "Bearer",
                "token" => $user->createToken("api_token")->plainTextToken,
                "user" => $user->only(["name", "email"]),
                "message" => "Login successful!",
            ]);
        } catch (Exception $e) {
            Log::error(printf("Login Error: %s", $e->getMessage()), [
                "request" => $request->attributes(),
            ]);
        }

        return response()->json(
            ["message" => "Login failed!"],
            Response::HTTP_INTERNAL_SERVER_ERROR,
        );
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $token = $request->bearerToken();

            if (!$token) {
                return response()->json(
                    ["message" => "Missing token!"],
                    Response::HTTP_BAD_REQUEST,
                );
            }

            $access_token = PersonalAccessToken::findToken($token);

            if (!$access_token) {
                return response()->json(
                    ["message" => "Invalid token!"],
                    Response::HTTP_BAD_REQUEST,
                );
            }

            $access_token->delete();

            return response()->json(
                ["message" => "Successfully logged out"],
                Response::HTTP_OK,
            );
        } catch (Exception $e) {
            Log::error(printf("Logout Error: %s", $e->getMessage()), [
                "request" => $request->attributes,
            ]);
        }

        return response()->json(
            ["message" => "An error occurred during logout"],
            Response::HTTP_INTERNAL_SERVER_ERROR,
        );
    }
}
