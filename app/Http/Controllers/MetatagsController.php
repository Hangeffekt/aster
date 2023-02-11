<?php

namespace App\Http\Controllers;

use App\Models\Metatags;
use Illuminate\Http\Request;

class MetatagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $metatags = Metatags::first();

        return view("admin.main", ["data"=>$metatags]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Metatags  $metatags
     * @return \Illuminate\Http\Response
     */
    public function show(Metatags $metatags)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Metatags  $metatags
     * @return \Illuminate\Http\Response
     */
    public function edit(Metatags $metatags)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Metatags  $metatags
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Metatags $metatags)
    {
        $Metatags = Metatags::find($request->id);
        $Metatags->analytics = $request->analytics;
        $Metatags->keywords = $request->keywords;
        $Metatags->description = $request->description;
        $Metatags->save();

        return back()->with("success", "Successfuly update!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Metatags  $metatags
     * @return \Illuminate\Http\Response
     */
    public function destroy(Metatags $metatags)
    {
        //
    }
}
