<?php

namespace App\Services;

use Exception;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class JWTService
{
    public function refreshToken($refreshToken): array|Throwable
    {
        $user = auth('api')->setToken($refreshToken)->user();

        if (is_null($user)) {
            throw new Exception('Invalid or expired refresh token.', ResponseAlias::HTTP_UNAUTHORIZED);
        }

        if (!auth('api')->getPayload()->get('is_refresh_token')) {
            throw new Exception('Invalid refresh token.', ResponseAlias::HTTP_UNAUTHORIZED);
        }

        return [
            'token' => auth('api')->login($user),
            'refreshToken' => auth('api')->claims(['is_refresh_token' => true])->login($user)
        ];

    }

    public function getTokenWithCredentials(array $credentials): ?string
    {
        try {
            return auth('api')->setTTL(config('jwt.ttl'))->attempt($credentials);
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }

    public function getRefreshTokenWithCredentials($user): ?string
    {
        try {
            return auth('api')
                ->claims(['is_refresh_token' => true])
                ->setTTL(config('jwt.refresh_ttl'))
                ->attempt($user);
        } catch (Throwable $e) {
            report($e);
            return null;
        }
    }
}
