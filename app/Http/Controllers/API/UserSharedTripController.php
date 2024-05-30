<?php

namespace App\Http\Controllers\API;

use App\Services\TripService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserSharedTripController extends ApiBaseController
{
    public function __construct(protected UserService $userService, protected TripService $tripService)
    {
        parent::__construct();

    }

    public function index()
    {
        $userSharedTrips = $this->user
            ->usersharedTrips()
            ->with('ratings')
            ->paginate(20);

        return response()->json($userSharedTrips);
    }

    public function show($id)
    {
        $userSharedTrip = $this->user
            ->usersharedTrips()
            ->with('ratings')
            ->find($id);

        return $this->showResponse($userSharedTrip);
    }

    public function store(Request $request)
    {
        $trip = $this->tripService->find($request->trip_id);

        if (!$this->checkOwnership($trip)) {
            return $this->unauthorizedResponse();
        }

        $this->tripService->updateShared($trip, true);
        $user = $this->userService->find($request->user_id);
        $user->usersharedTrips()->attach($trip);

        $trip->loadMissing("userSharedTrips");

        return $this->createResponse($trip);
    }

    public function destroy(Request $request)
    {

        $trip = $this->tripService->find($request->trip_id);

        if (!$this->checkOwnership($trip)) {
            return $this->unauthorizedResponse();
        }

        $user = $this->userService->find($request->user_id);
        $user->userSharedTrips()->detach($trip);
        $this->tripService->updateShared($trip, false);

        return $this->deleteResponse($trip);
    }


}
