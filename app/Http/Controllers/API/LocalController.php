<?php

namespace App\Http\Controllers\API;

use App\Models\Local;
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
        $locals = $trip->locals()
            ->with(['localFiles', 'localType'])
            ->paginate($request->get('amount', 20),
                page: $request->get('page', 1));

        return response()->json($locals);
    }

    public function show(Trip $trip, Local $local)
    {
        $local->loadMissing(['ratings', 'localFiles', 'localType']);

        return $this->showResponse($local);
    }

    public function update(Request $request, Trip $trip, Local $local)
    {
        if ($request->has('local_type-id')) {
            $localType = $this->localTypeService->find($request->local_type_id);
        } else {
            $localType = $local->localType;
        }

        $status = $this->localService
            ->update(
                $local,
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
                $this->localFileService->store($local, $filePath->fileName, $filePath->path);
            }
        }

        $local->loadMissing(['localFiles', 'localType']);

        $local->refresh();
        return $this->updateResponse($status, $local);
    }

    public function store(Request $request, Trip $trip)
    {

        $localType = $this->localTypeService->find($request->local_type_id);

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
                $this->localFileService->store($local, $filePath->fileName, $filePath->path);
            }
        }

        $local->loadMissing(['localFiles', 'localType']);

        return $this->createResponse($local);

    }

    public function destroy(Trip $trip, Local $local)
    {

        $status = $this->localService->delete($local);

        return $this->deleteResponse($status);
    }
}
