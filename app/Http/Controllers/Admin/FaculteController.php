<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFaculteRequest;
use App\Http\Requests\UpdateFaculteRequest;
use App\Http\Resources\FaculteResource;
use App\Models\Faculte;
use Illuminate\Http\Response;

class FaculteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFaculteRequest $request
     * @return Response
     */
    public function store(StoreFaculteRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Faculte $faculte
     * @return Response
     */
    public function show(Faculte $faculte)
    {

        return FaculteResource::make($faculte);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Faculte $faculte
     * @return Response
     */
    public function edit(Faculte $faculte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateFaculteRequest $request
     * @param Faculte $faculte
     * @return Response
     */
    public function update(UpdateFaculteRequest $request, Faculte $faculte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Faculte $faculte
     * @return Response
     */
    public function destroy(Faculte $faculte)
    {
        //
    }
}
