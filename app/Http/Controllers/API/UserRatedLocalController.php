<?php

namespace App\Http\Controllers\API;

use App\Models\Local;
use App\Models\Trip;
use App\Services\LocalService;
use Illuminate\Http\Request;

class UserRatedLocalController extends ApiBaseController
{
    public function __construct(protected LocalService $localService)
    {
        parent::__construct();
    }

    public function store(Request $request, Trip $trip, Local $local)
    {
        if (!$this->checkShared($trip)) {
            return $this->unauthorizedResponse();
        }

        $this->localService->attachRating($local, $this->user, $request->integer('rating'));

        $userRatedLocal = $local->ratings()->where('user_id', $this->user->id)->first();

        return $this->createResponse($userRatedLocal);
    }

    public function update(Request $request, Trip $trip, Local $local)
    {
        if (!$this->checkShared($trip)) {
            return $this->unauthorizedResponse();
        }

        $status = $this->localService->updateRating($local, $this->user, $request->integer('rating'));

        $userRatedLocal = $local->ratings()->where('user_id', $this->user->id)->first();

        return $this->updateResponse($status, $userRatedLocal);
    }

    public function destroy(Trip $trip, Local $local)
    {
        if (!$this->checkShared($trip)) {
            return $this->unauthorizedResponse();
        }

        $status = $this->localService->detachRating($local, $this->user);

        return $this->deleteResponse($status);
    }
}
