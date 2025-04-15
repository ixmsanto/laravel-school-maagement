<?php

namespace App\Http\Controllers;

// path: app/Http/Controllers/AuthController.php

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @OA\Info(
 *     title="School Management System API",
 *     version="1.0.0",
 *     description="API for managing school operations including authentication, students, teachers, homework, and reports",
 *     @OA\Contact(
 *         email="support@example.com"
 *     )
 * )
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Local development server"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Enter JWT token in the format: Bearer {token}"
 * )
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     operationId="login",
     *     tags={"Authentication"},
     *     summary="Authenticate user and generate JWT token",
     *     description="Logs in a user with email and password, returning an access token and refresh token.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="teacher@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", example="eyJ0..."),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=300),
     *             @OA\Property(property="refresh_token", type="string", example="eyJ0...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid credentials")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        $user = auth('api')->user();
        $customClaims = ['role' => $user->role];
        $token = JWTAuth::claims($customClaims)->attempt($credentials);
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'refresh_token' => JWTAuth::refresh($token),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/refresh",
     *     operationId="refreshToken",
     *     tags={"Authentication"},
     *     summary="Refresh JWT token",
     *     description="Refreshes an expired JWT token, returning a new access token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token refreshed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", example="eyJ0..."),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=300)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Could not refresh token",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Could not refresh token")
     *         )
     *     )
     * )
     */
    public function refresh()
    {
        try {
            $newToken = JWTAuth::refresh();
            return response()->json([
                'access_token' => $newToken,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not refresh token'], 401);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     operationId="logout",
     *     tags={"Authentication"},
     *     summary="Log out user",
     *     description="Invalidates the current JWT token, logging the user out.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     )
     * )
     */
    public function logout()
    {
        JWTAuth::invalidate();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
