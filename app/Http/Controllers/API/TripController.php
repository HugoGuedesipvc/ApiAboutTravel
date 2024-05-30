<?php

namespace App\Http\Controllers\API;

use App\Models\Trip;
use App\Services\CountryService;
use App\Services\TripService;
use Illuminate\Http\Request;
use Riftweb\Storage\Classes\RiftStorage;

class TripController extends ApiBaseController
{
    public function __construct(
        protected TripService    $tripService,
        protected CountryService $countryService
    )
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $trips = $this->user
            ->trips()
            ->with(['ratings', 'userSharedTrips'])
            ->paginate(
                $request->get('amount', 20),
                page: $request->get('page', 1)
            );


        return response()->json($trips);
    }

    public function show(Trip $trip)
    {
        if (!$this->checkOwnership($trip, true)) {
            return $this->unauthorizedResponse();
        }

        $trip->loadMissing(['ratings', 'userSharedTrips']);

        return $this->showResponse($trip);
    }

    public function update(Request $request, Trip $trip)
    {
        if (!$this->checkOwnership($trip)) {
            return $this->unauthorizedResponse();
        }

        $status = $this->tripService
            ->update(
                $trip,
                $request->label,
                $request->country_iso2,
                $request->location,
                $request->date('date'),
                $request->description,
                optional(RiftStorage::store($request->file('image'), 'trips'))->path,
                $request->float('latitude'),
                $request->float('longitude'),
                $request->boolean('shared')
            );

        $trip->refresh();

        return $this->updateResponse($status, $trip);
    }

    public function store(Request $request)
    {
        $trip = $this->tripService
            ->store(
                $this->user,
                $request->label,
                $this->countryService->findByIso2($request->country_iso2),
                $request->location,
                $request->date('date'),
                $request->description,
                optional(RiftStorage::store($request->file('image'), 'trips'))->path,
                $request->float('latitude'),
                $request->float('longitude'),
                $request->boolean('shared')
            );

        return $this->createResponse($trip);
    }

    public function destroy(Trip $trip)
    {
        if (!$this->checkOwnership($trip)) {
            return $this->unauthorizedResponse();
        }

        return $this->deleteResponse(
            $this->tripService->delete($trip)
        );
    }
}
