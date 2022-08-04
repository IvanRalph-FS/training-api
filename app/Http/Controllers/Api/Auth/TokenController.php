<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TokenRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class TokenController extends Controller
{
    public function __invoke(TokenRequest $request)
    {
        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'username' => [
                    'The provided credentials are incorrect'
                ]
            ], 422);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        $user['token'] = $token;

        return response()->json($user, 200);
    }
}
