<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\LocalRepository;
use App\Services\LocalService;
use Illuminate\Http\Request;

class LocalController extends ApiBaseController
{
    public function __construct(
        protected LocalService $localService,
        protected LocalRepository $localRepository,
    )
    {
        parent::__construct();
    }
    public function index()
    {

    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
