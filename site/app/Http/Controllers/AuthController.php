<?php

namespace App\Http\Controllers;

use App\Classes\Responses\JsonResponses;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     *
     */
    public function me()
    {
        return JsonResponses::createOk(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     *
     */
    public function logout()
    {
        auth()->logout();

        return JsonResponses::createOk(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param $token
     * @return \App\Classes\Responses\ApiJsonResponse|JsonResponses
     */
    protected function respondWithToken($token)
    {
        return JsonResponses::createOk([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
