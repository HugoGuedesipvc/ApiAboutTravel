<?php

namespace App\Http\Controllers\API;

use App\Services\TripService;
use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    protected  TripService $tripService;
    public function __construct(TripService $tripService)
    {
        $this->tripService = $tripService;
    }
    public function index()
    {
        return $this->tripService->all();
    }

    public function getTripRecyclerView(Request $request)
    {
        $perScroll = $request->get('per_scroll', 20);
        return $this->tripService->getTripAmount($perScroll);
    }

    public function store(Request $request)
    {
        $this->tripService->store(
            auth()->user(),
            $request->name,
            $request->country,
            $request->location,
            $request->date,
            $request->description,
            $request->image,
            $request->latitude,
            $request->longitude,
            $request->shared
        );
    }

    public function show($id)
    {
        return $this->tripService->find($id);
    }

    public function update(Request $request, $id)
    {
        $this->tripService->update(
            $this->tripService->find($id),
            auth()->user(),
            $request->name,
            $request->country,
            $request->location,
            $request->date,
            $request->description,
            $request->image,
            $request->latitude,
            $request->longitude,
            $request->shared
        );

        //File code
        /*
        if($request->hasFile("imagens"))
        {
            $imagens = [];

            foreach($request->file("imagens") as $imagem)
            {
                $imagens[] = RiftStorage::store($imagem,"receitas");
            }

            $this->imagemService->massStore($receita,$imagens);
        }

        if($request->has("imagens_delete"))
        {
            $this->imagemService->deleteByIds($request->imagens_delete);
        }
        */
    }

    public function destroy($id)
    {
        $this->tripService->delete($id);
    }

    public function getTripShared()
    {
        return $this->tripService->getTripShared();
    }
}
