<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticateRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Riftweb\Storage\Classes\RiftStorage;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    public function __construct(protected UserService $userService)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(AuthenticateRequest $request)
    {
        $credentials = ['password' => $request->password];
        if ($request->has('email')) {
            $credentials['email'] = $request->email;
        } elseif ($request->has('username')) {
            $credentials['username'] = $request->username;
        }

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(
                ['error' => 'Unauthorized'],
                401
            );
        }

        return $this->respondWithToken($token);
    }

    private function respondWithToken(?string $token = null)
    {
        $status = !is_null($token);

        return response()->json([
            'status' => $status ? 'Authenticated' : 'Unauthenticated',
            'data' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ]
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
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

    public function register(Request $request)
    {
        $user = $this->userService
            ->store(
                $request->name,
                $request->email,
                $request->password,
                $request->username,
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
}
