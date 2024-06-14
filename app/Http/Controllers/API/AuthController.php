<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticateRequest;
use App\Http\Requests\RefreshTokenRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mappings\JWTMapping;
use App\Services\JWTService;
use App\Services\UserService;
use Riftweb\Storage\Classes\RiftStorage;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class AuthController extends Controller
{
    public function __construct(protected UserService $userService, protected JWTService $jwtService)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'refresh']]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me()
    {
        $user = null;
        if ($status = auth()->check()) {
            $user = auth()->user();
        }

        return response()->json([
            'status' => $status ? 'Authenticated' : 'Unauthenticated',
            'user' => $user
        ]);
    }

    public function register(RegisterUserRequest $request)
    {
        $user = $this->userService
            ->store(
                $request->name,
                $request->email,
                $request->username,
                $request->password,
                $request->phone_number,
                optional(RiftStorage::store($request->file('profilePicture'), 'users'))->path,
                $request->description,
            );

        $status = !is_null($user);

        return response()->json([
            'status' => $status ? 'success' : 'error',
            'data' => $user
        ], $status ? ResponseAlias::HTTP_CREATED : ResponseAlias::HTTP_BAD_REQUEST);
    }

    public function update(UpdateUserRequest $request)
    {
        $user = auth()->user();

        $status = $this->userService
            ->update(
                $user,
                $request->name,
                $request->email,
                $request->username,
                $request->password,
                $request->phoneNumber,
                optional(RiftStorage::store($request->file('profilePicture'), 'users'))->path,
                $request->description,
            );

        $user->refresh();

        return response()->json([
            'status' => $status ? 'success' : 'error',
            'data' => $user
        ], $status ? ResponseAlias::HTTP_OK : ResponseAlias::HTTP_BAD_REQUEST);
    }

    public function refresh(RefreshTokenRequest $request)
    {
        try {
            $tokens = $this->jwtService->refreshToken($request->refresh_token);

            return $this->respondWithToken(
                $tokens['token'],
                $tokens['refreshToken']
            );
        } catch (Throwable $e) {
            report($e);
            return response()->json([
                'error' => $e->getMessage()
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        }
    }

    private function respondWithToken(?string $token = null, ?string $refreshToken = null)
    {
        return response()->json(
            JWTMapping::mapTokenResponse($token, $refreshToken)
        );
    }

    public function login(AuthenticateRequest $request)
    {
        $credentials = JWTMapping::mapCredentials($request);

        $token = $this->jwtService->getTokenWithCredentials($credentials);
        if (!$token) {
            return response()->json(
                ['error' => 'Unauthorized'],
                ResponseAlias::HTTP_UNAUTHORIZED
            );
        }

        $refreshToken = $this->jwtService->getRefreshTokenWithCredentials($credentials);

        return $this->respondWithToken($token, $refreshToken);
    }

    public function destroy()
    {
        $user = auth()->user();
        $status = $this->userService->delete($user);

        return response()->json([
            'status' => $status ? 'success' : 'error',
        ], $status ? ResponseAlias::HTTP_OK : ResponseAlias::HTTP_BAD_REQUEST);

    }

}
