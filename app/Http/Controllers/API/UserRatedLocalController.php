<?php

namespace App\Http\Controllers\API;

use App\Models\Local;
use App\Models\Trip;
use Illuminate\Http\Request;

class UserRatedLocalController extends ApiBaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

    }

    public function store(Request $request, Trip $trip, Local $local)
    {
        if (!$this->checkShared($trip)) {
            return $this->unauthorizedResponse();
        }

        $rating = $request->rating;

        $local->ratings()->attach(auth()->id(), ['rating' => $rating]);

        $local->loadMissing(['ratings']);

        return $this->createResponse($local);

    }

    public function show($id)
    {
    }

    public function update(Request $request, Trip $trip, Local $local)
    {

        if (!$this->checkShared($trip)) {
            return $this->unauthorizedResponse();
        }

        $rating = $request->rating;

        $local->ratings()->updateExistingPivot(auth()->id(), ['rating' => $rating]);

        $local->loadMissing(['ratings']);

        return $this->createResponse($local);
    }

    public function destroy($id)
    {
    }
}
