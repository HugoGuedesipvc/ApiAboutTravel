<?php

namespace App\Http\Controllers\API;

use App\Services\TripService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserSharedTripController extends ApiBaseController
{
    public function __construct(
        protected UserService $userService,
        protected TripService $tripService
    )
    {
        parent::__construct();

    }

    public function index()
    {
        $userSharedTrips = $this->user
            ->userSharedTrips()
            ->with(['ratings'])
            ->paginate(20);

        return response()->json($userSharedTrips);
    }

    public function store(Request $request)
    {
        $trip = $this->tripService->find($request->trip_id);

        if (!$this->checkOwnership($trip)) {
            return $this->unauthorizedResponse();
        }

        $userToAttach = $this->userService->find($request->user_id);
        $this->tripService->attachUserSharedTrip($trip, $userToAttach);

        $trip->loadMissing("userSharedTrips");

        $userSharedTrip = $trip->userSharedTrips()
            ->where('user_id', $userToAttach->id)
            ->first();

        return $this->createResponse($userSharedTrip);
    }

    public function destroy(Request $request)
    {
        $trip = $this->tripService->find($request->trip_id);

        if (!$this->checkOwnership($trip)) {
            return $this->unauthorizedResponse();
        }

        $userToDetach = $this->userService->find($request->user_id);
        $status = $this->tripService->detachUserSharedTrip($trip, $userToDetach);

        return $this->deleteResponse($status);
    }
}
