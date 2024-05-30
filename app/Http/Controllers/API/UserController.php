<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends ApiBaseController
{
    public function __construct(
        protected UserService $userService
    )
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $users = $this->userService->all();
        //$users = User::paginate($request->get('amount', 10));
        return response()->json($users);
    }

    public function show(User $user)
    {
        return $this->showResponse($user);
    }

}
