<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Riftweb\Storage\Classes\RiftStorage;

class UserController extends ApiBaseController
{
    public function __construct(
        protected UserService $userService
    )
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->userService->all();
    }

    public function me()
    {
        return $this->showResponse($this->user);
    }

    public function show(User $user)
    {
        return $this->showResponse($user);
    }

    public function update(Request $request)
    {

        $status = $this->userService
            ->update(
                $this->user,
                $request->name,
                $request->email,
                $request->username,
                $request->password,
                $request->phone_number,
                optional(RiftStorage::store($request->file('profilePicture'), 'users'))->path,
                $request->description,
            );

        $this->user->refresh();

        return $this->updateResponse($status, $this->user);
    }

    public function store(Request $request)
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

        return $this->createResponse($user);
    }

    public function destroy()
    {
        $status = $this->userService->delete($this->user);

        return $this->deleteResponse($status);
    }
}
