<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Brand;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::orderby("name")->get();

        return view("admin.brand", ["data"=>$brands]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.createbrand");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate $request
        $request->validate([
            "name"=>"required|unique:brands"
        ]);

        //if validate successfuly

        if($request->status == null){
            $status = 0;
        }
        else {
            $status = 1;
        }

        $url = str_replace(["Ö", "ö", "Ü", "ü", "Ó", "ó", "Ő", "ő", "Ú", "ú", "É", "é", "Á", "á", "Ű", "ű", "Í", "í"], ["o","o","u","u","o","o","o","o","u","u","e","e","a","a","u","u","i","i",], $request->name);
        $url = str_replace([" ", "_"], "-", $url);

        if($request->file('mainImage') != null){
            $path = $request->file('mainImage')->store("public/brand/");
        }
        else {
            $path = null;
        }

        $newBrand = new Brand;
        $newBrand->name = $request->name;
        $newBrand->garantie = $request->garantie;
        $newBrand->status = $status;
        $newBrand->image = $path;
        $newBrand->url = $url;
        $newBrand->save();

        return redirect("admin/brands")->with("success", "New brand created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::find($id);

        return view("admin.editbrand", ["data"=>$brand]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $BrandImage = Brand::find($request->id);

        if($request->status == null){
            $status = 0;
        }
        else {
            $status = 1;
        }

        $url = str_replace(["Ö", "ö", "Ü", "ü", "Ó", "ó", "Ő", "ő", "Ú", "ú", "É", "é", "Á", "á", "Ű", "ű", "Í", "í"], ["o","o","u","u","o","o","o","o","u","u","e","e","a","a","u","u","i","i",], $request->name);
        $url = str_replace([" ", "_"], "-", $url);

        if($request->file('mainImage') != null){
            $path = $request->file('mainImage')->store("public/brand/");
        }
        else{
            $path = $BrandImage->image;
        }

        $Brand = Brand::find($request->id);
        $Brand->name = $request->name;
        $Brand->garantie = $request->garantie;
        $Brand->status = $status;
        $Brand->url = $url;
        $Brand->save();

        if($request->deleteImage != null){
            if(Storage::delete($BrandImage->image)){

                $BrandImg = Brand::find($request->id);
                $Brand->image = null;
                $Brand->save();

                return back()->with("success", "Image successfuly delete!");
            }
        }

        if($request->file('mainImage') != null){
            $path = $request->file('mainImage')->store("public/brand/");

            $BrandImg = Brand::find($request->id);
                $Brand->image = $path;
                $Brand->save();
        }

        return back()->with("success", "Successfuly update!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $BrandImage = Brand::find($id);

        if(Storage::delete("public/".$BrandImage->image)){
            $Brand = Brand::find($id);
            $Brand->delete();

            return back()->with("success", "Brand successfuly deleted!");
        }
        else{
            return back()->with("fail", "Somthing went wrong!");
        }
    }
}
