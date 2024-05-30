<?php

namespace App\Http\Controllers\API;

use App\Models\Trip;
use App\Services\TripService;
use Illuminate\Http\Request;

class UserRatedTripController extends ApiBaseController
{
    public function __construct(protected TripService $tripService)
    {
        parent::__construct();
    }

    public function store(Request $request, Trip $trip)
    {
        if (!$this->checkShared($trip)) {
            return $this->unauthorizedResponse();
        }

        $this->tripService->attachRating($trip, $this->user, $request->integer('rating'));

        $userRatedTrip = $trip->ratings()->where('user_id', $this->user->id)->first();

        return $this->createResponse($trip);
    }

    public function update(Request $request, Trip $trip)
    {

        if (!$this->checkShared($trip)) {
            return $this->unauthorizedResponse();
        }

        $status = $this->tripService->updateRating($trip, $this->user, $request->integer('rating'));

        $userRatedTrip = $trip->ratings()->where('user_id', $this->user->id)->first();

        return $this->updateResponse($status, $userRatedTrip);
    }

    public function destroy(Trip $trip)
    {
        if (!$this->checkShared($trip)) {
            return $this->unauthorizedResponse();
        }

        $status = $this->$trip->detachRating($trip, $this->user);

        return $this->deleteResponse($status);
    }
}
