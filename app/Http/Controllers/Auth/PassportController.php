<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiBaseController;
use App\Models\User;

class PassportController extends ApiBaseController
{
    private $tokenName = 'PassportAuthToken';

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken($this->tokenName)->accessToken;

        return $this->sendJson([
            'user' => $user,
            'token' => $token,
        ], 'Register user successfully', 201);
    }

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken($this->tokenName)->accessToken;
            return $this->sendJson([
                'token' => $token,
            ], 'Successfully logged in');
        } else {
            return $this->sendJson(true, 'Failed to login', 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->sendJson(null, 'Successfully logged out');
    }
}
