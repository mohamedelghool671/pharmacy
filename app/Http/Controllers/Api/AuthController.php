<?php

namespace App\Http\Controllers\Api;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\ResetPassword;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Api\LoginRequest;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\RegisterRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Pharmacy API", version="1.0")
 */
class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="User registration",
     *     tags={"Auth"},
     *     description="Allows a new user to create an account by providing necessary details.",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"first_name", "last_name", "email", "password"},
     *             @OA\Property(property="first_name", type="string", example="Mohamed"),
     *             @OA\Property(property="last_name", type="string", example="Emad"),
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="phone", type="string", example="0123456789"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="12345678")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Registration successful"),
     *     @OA\Response(response=422, description="Validation errors")
     * )
     */
    public function register(RegisterRequest $request) {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $data['token'] = $user->createToken('user register')->plainTextToken;
        return ApiResponse::sendResponse("Register Successfully", 200, [
            "First_name" => $user->first_name,
            "last_name" => $user->last_name,
            "email" => $user->email,
            "token" => $data['token']
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="User login",
     *     tags={"Auth"},
     *     description="Allows a user to log in using email and password.",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Login successful"),
     *     @OA\Response(response=401, description="Invalid credentials")
     * )
     */
    public function login(LoginRequest $request) {
        $data = $request->validated();
        if (Auth::attempt(["email" => $data['email'], "password" => $data['password']])) {
            $user = Auth::user();
            $token = $user->createToken("login user")->plainTextToken;
            return ApiResponse::sendResponse("Login success", 200, [
                "first_name" => $user->first_name,
                "last_name" => $user->last_name,
                "email" => $user->email,
                "token" => $token
            ]);
        }
        return ApiResponse::sendResponse("Invalid credentials", 401, null);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="User logout",
     *     tags={"Auth"},
     *     description="Logs out the authenticated user by revoking their access token.",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="Logout successful")
     * )
     */
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::sendResponse("Logout success", 200);
    }

        /**
     * @OA\Post(
     *     path="/api/social-login/{provider}",
     *     summary="Login via social media",
     *     description="Allows users to log in using social media providers like Google or Facebook.
     *                  The access token must be obtained from the provider and sent to this API.",
     *     tags={"Auth"},
     *     @OA\Parameter(
     *         name="provider",
     *         in="path",
     *         required=true,
     *         description="The social media provider (e.g., google, facebook)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"access_token"},
     *             @OA\Property(property="access_token", type="string", example="ya29.a0AfH6SM..."),
     *         )
     *     ),
     *     @OA\Response(response=200, description="Login successful"),
     *     @OA\Response(response=422, description="Invalid token or user not found"),
     *     @OA\Response(response=401, description="Unauthorized access")
     * )
     */
    public function socialLogin(Request $request, $provider) {
        try {
            $access_token = $request->get("access_token");
            $user = Socialite::driver($provider)->stateless()->userFromToken($access_token);
            if (!$user) {
                return ApiResponse::sendResponse("User not found", 422, []);
            }
            $newUser = User::create([
                "first_name" => $user->user['given_name'] ?? "Unknown",
                "last_name" => $user->user['family_name'] ?? "Unknown",
                "email" => $user->email,
                "provider_id" => $user->id
            ]);
            $token = $newUser->createToken('success login')->plainTextToken;
            return ApiResponse::sendResponse("Success login", 200, [
                "first_name" => $newUser->first_name,
                "last_name" => $newUser->last_name,
                "email" => $newUser->email,
                "token" => $token
            ]);
        } catch (Exception $e) {
            return ApiResponse::sendResponse("Invalid token", 401, []);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/forget-password",
     *     summary="Request a password reset code",
     *     tags={"Auth"},
     *     description="Sends a password reset code to the user's email if it exists in the system.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Reset code sent successfully"),
     *     @OA\Response(response=422, description="User not found or validation error")
     * )
     */
    public function forgetPassword(Request $request) {
        $error = Validator::make($request->all(), ["email" => "required|email|exists:users,email"]);
        if ($error->fails()) {
            return ApiResponse::sendResponse($error->errors(), 422, null);
        }
        $user = User::where("email", $request->email)->first();
        if ($user) {
            $resetCode = rand(100000, 999999);
            $user->reset_code = $resetCode;
            $user->reset_code_expires_at = Carbon::now()->addMinutes(5);
            $user->save();
            Mail::to($user->email)->send(new ResetPassword($user->first_name, $resetCode));
            return ApiResponse::sendResponse("Reset code sent successfully", 200, []);
        }
        return ApiResponse::sendResponse("User not found", 422, []);
    }


    /**
     * @OA\Post(
     *     path="/api/reset-password",
     *     summary="Reset password using reset code",
     *     description="Resets the user's password using a 6-digit reset code sent via email.
     *                  The reset code is valid for 5 minutes.",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "reset_code", "password", "password_confirmation"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="reset_code", type="integer", example=123456),
     *             @OA\Property(property="password", type="string", format="password", example="newpassword123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="newpassword123")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Password updated successfully"),
     *     @OA\Response(response=422, description="Invalid reset code or email not found"),
     *     @OA\Response(response=400, description="Validation error")
     * )
     */
    public function resetPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'reset_code' => 'required|numeric|digits:6',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendResponse($validator->errors(), 422, []);
        }
        $user = User::where('email', $request->email)
                    ->where('reset_code', $request->reset_code)
                    ->where('reset_code_expires_at', '>', Carbon::now())
                    ->first();
        if (!$user) {
            return ApiResponse::sendResponse("Invalid code", 422, null);
        }
        $user->password = bcrypt($request->password);
        $user->reset_code = null;
        $user->reset_code_expires_at = null;
        $user->save();
        $token = $user->createToken('reset user')->plainTextToken;
        return ApiResponse::sendResponse("Password update success", 200, [
            "user_name" => $user->first_name,
            "email" => $user->email,
            "token" => $token
        ]);
    }
}
