<?php

namespace App\Http\Controllers\API;

use App\Models\Local;
use App\Models\Trip;
use App\Services\LocalFileService;
use App\Services\LocalService;
use App\Services\LocalTypeService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Riftweb\Storage\Classes\RiftStorage;
use Throwable;

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
            ->paginate(
                $request->get('amount', 20),
                page: $request->get('page', 1)
            );

        return response()->json($locals);
    }

    public function show(Trip $trip, Local $local)
    {
        if (!$this->checkOwnership($trip, true)) {
            return $this->unauthorizedResponse();
        }

        $local->loadMissing(['ratings', 'localFiles', 'localType']);

        return $this->showResponse($local);
    }

    public function update(Request $request, Trip $trip, Local $local)
    {
        if (!$this->checkOwnership($trip)) {
            return $this->unauthorizedResponse();
        }

        $localType = $request->has('local_type_id')
            ? $this->localTypeService->find($request->local_type_id)
            : $local->localType;

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
                $this->storeFile($local, $file);
            }
        }

        $local->loadMissing(['localFiles', 'localType'])
            ->refresh();

        return $this->updateResponse($status, $local);
    }

    private function storeFile(Local $local, ?UploadedFile $file = null): void
    {
        try {
            $filePath = RiftStorage::store($file, 'locals');
            $this->localFileService->store($local, $filePath->fileName, $filePath->path);
        } catch (Throwable $e) {
            report($e);
        }
    }

    public function store(Request $request, Trip $trip)
    {
        $localType = $this->localTypeService
            ->find($request->local_type_id);

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
                $this->storeFile($local, $file);
            }
        }

        $local->loadMissing(['localFiles', 'localType']);

        return $this->createResponse($local);
    }

    public function destroy(Trip $trip, Local $local)
    {
        if (!$this->checkOwnership($trip)) {
            return $this->unauthorizedResponse();
        }

        return $this->deleteResponse(
            $this->localService->delete($local)
        );
    }
}
