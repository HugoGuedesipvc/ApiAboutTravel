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

    public function index()
    {

    }

    public function store(Request $request, Trip $trip)
    {
        if (!$this->checkShared($trip)) {
            return $this->unauthorizedResponse();
        }

        $rating = $request->rating;

        $trip->ratings()->attach(auth()->id(), ['rating' => $rating]);

        $trip->loadMissing(['ratings']);

        return $this->createResponse($trip);
    }

    public function show($id)
    {
    }

    public function update(Request $request, Trip $trip)
    {

        if (!$this->checkShared($trip)) {
            return $this->unauthorizedResponse();
        }

        $rating = $request->rating;

        $trip->ratings()->updateExistingPivot(auth()->id(), ['rating' => $rating]);

        $trip->loadMissing(['ratings']);

        return $this->createResponse($trip);

    }

    public function destroy($id)
    {
    }
}
