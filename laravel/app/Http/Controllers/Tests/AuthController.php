<?php

namespace App\Http\Controllers\Tests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\testModel;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class AuthController extends testController
{
    public function __construct()
    {
        parent::__construct();
    }

    //登陆验证
    public function authenticate(Request $request)
    {
        $payload = [
            'uname' => $request->get('name'),
            'password' => $request->get('word')
        ];

        try {
            if (!$token = JWTAuth::attempt($payload)) {
                return response()->json(['error' => 'token_not_provided'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => '不能创建token'], 500);
        }

        return response()->json(compact('token'));
    }

    //注册的验证
    public function register(Request $request)
    {
        $newUser = [
            'uname' => $request->get('name'),
            'password' => bcrypt($request->get('word'))
        ];
        $user = testModel::create($newUser);
        $token = JWTAuth::fromUser($user);
        return $token;
    }

    //??
    public function AuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

}
