<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthRequest;
use App\Http\Resources\UserResource;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(AuthRequest $request)
    {
        $credentials['email'] = $request->email;
        $credentials['password'] = $request->password;

        if ( !$token = auth('api')->attempt($credentials) ){
            throw new AuthenticationException('The email address or password is incorrect');
        }

        return $this->respondWithToken($token)->setStatusCode(201);
    }

    public function me()
    {
        return new UserResource(auth()->user());
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    /**
     * 社会登录
     */
    public function socialStore($type, Request $request)
    {
        $driver = Socialite::driver($type);

        try {
            if ($code = $request->code) {
                $access_token = $driver->getAccessTokenResponse($code);
                $oauthUser = $driver->userFromToken($access_token);
            } else {
                $oauthUser = $driver->userFromToken($request->access_token);
            }
        } catch (\Exception $e) {
            abort('403', 'Parameter error, no user information obtained');
        }

        if (!$oauthUser->id) {
            abort('403', 'Parameter error, no user information obtained');
        }

        switch ($type) {
            case 'google':
                break;
            case 'facebook':
                dd($oauthUser);
                break;
        }
    }
}
