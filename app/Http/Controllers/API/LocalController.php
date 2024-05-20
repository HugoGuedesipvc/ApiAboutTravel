<?php

namespace App\Http\Controllers\API;

use App\Models\Local;
use App\Models\LocalType;
use App\Models\Trip;
use App\Services\LocalFileService;
use App\Services\LocalService;
use App\Services\LocalTypeService;
use Illuminate\Http\Request;
use Riftweb\Storage\Classes\RiftStorage;

class LocalController extends ApiBaseController
{
    public function __construct(
        protected LocalService     $localService,
        protected LocalFileService $localFileService,
        protected LocalTypeService $localTypeService,
    )
    {
        parent::__construct();
    }

    public function index(Request $request, Trip $trip)
    {
        if (!$this->checkOwnership($trip)) {
            return $this->unauthorizedResponse();
        }

        $locals = $trip->locals()->get();

        return response()->json($locals);
    }

    public function show(Trip $trip, Local $local)
    {
        if (!$this->checkOwnership($local) || !$this->checkOwnership($trip)) {
            return $this->unauthorizedResponse();
        }

        return $this->showResponse($local);
    }

    public function update(Request $request, Trip $trip, Local $local)
    {
        if (!$this->checkOwnership($local) || !$this->checkOwnership($trip)) {
            return $this->unauthorizedResponse();
        }

        $status = $this->localService
            ->update(
                $local,
                $request->local_type_id,
                $request->label,
                $request->float('latitude'),
                $request->float('longitude'),
                $request->description,
                $request->date('date')
            );

        if ($request->has('files')) {
            foreach ($request->file('files') as $file) {
                $filePath = RiftStorage::store($file, 'locals');
                $this->localFileService->store($local->id, $filePath, null);
            }
        }

        $local->refresh();

        return $this->updateResponse($status, $local);
    }

    public function store(Request $request, Trip $trip)
    {
        if (!$this->checkOwnership($trip)) {
            return $this->unauthorizedResponse();
        }

        $localType = LocalType::find($request->local_type_id);

        $local = $this->localService
            ->store(
                $trip,
                $localType,
                $request->label,
                $request->float('latitude'),
                $request->float('longitude'),
                $request->description,
                $request->date('date')
            );

        if ($request->has('files')) {
            foreach ($request->file('files') as $file) {
                $filePath = RiftStorage::store($file, 'locals');
                $this->localFileService->store($local->id, $filePath, null);
            }
        }

        return $this->createResponse($local);

    }

    public function destroy(Trip $trip, Local $local)
    {
        if (!$this->checkOwnership($local) || !$this->checkOwnership($trip)) {
            return $this->unauthorizedResponse();
        }

        $status = $this->localService->delete($local);

        return $this->deleteResponse($status);
    }
}
