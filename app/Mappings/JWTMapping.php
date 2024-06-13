<?php

namespace App\Mappings;

use Illuminate\Http\Request;

class JWTMapping
{
    public static function mapTokenResponse(?string $token = null, ?string $refreshToken = null): array
    {
        $data = [
            'token' => [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl')
            ]
        ];

        if (!is_null($refreshToken)) {
            $data['refresh_token'] = [
                'token' => $refreshToken,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.refresh_ttl')
            ];
        }

        return [
            'status' => !is_null($token) ? 'Authenticated' : 'Unauthenticated',
            'data' => $data
        ];
    }

    public static function mapCredentials(Request $request): array
    {
        $credentials = ['password' => $request->password];
        if ($request->has('email')) {
            $credentials['email'] = $request->email;
        } elseif ($request->has('username')) {
            $credentials['username'] = $request->username;
        }

        return $credentials;
    }
}
