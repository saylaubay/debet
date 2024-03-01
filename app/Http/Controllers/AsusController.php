<?php

namespace App\Http\Controllers;

use App\Models\Asus;
use App\Http\Requests\StoreAsusRequest;
use App\Http\Requests\UpdateAsusRequest;

class AsusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAsusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAsusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Asus  $asus
     * @return \Illuminate\Http\Response
     */
    public function show(Asus $asus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asus  $asus
     * @return \Illuminate\Http\Response
     */
    public function edit(Asus $asus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAsusRequest  $request
     * @param  \App\Models\Asus  $asus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAsusRequest $request, Asus $asus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asus  $asus
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asus $asus)
    {
        //
    }
}
