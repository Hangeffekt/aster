<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;

class BrandController extends Controller
{
    function brands(Request $request){

        if($request->id == null){
            $brand = null;
        }
        else if($request->id == "new"){
            $brand = "new";
        }
        else {
            $brand = Brand::where('id', $request->id)->first();
        }
    
        $brands = Brand::orderby("name")->get();

        return view("admin.brand", ["data"=>$brands, "brandData"=>$brand]);
    }

    public function createBrand(Request $request) {
        //validate $request
        $request->validate([
            "name"=>"required|unique:brands"
        ]);

        //if validate successfuly

        if($request->active == null){
            $active = 0;
        }
        else {
            $active = 1;
        }

        $path = $request->file('mainImage')->store("public/brand/");

        $affected = DB::table('brands')->insert([
            'name' => $request->name,
            'garantie' => $request->garantie,
            'active' => $active,
            'image' => $path
        ]);

        return back()->with("success", "New brand created!");
    }

    public function updateBrand(Request $request){
        $image = DB::table('brands')
            ->where('id', $request->id)->first();

        if($request->active == null){
            $active = 0;
        }
        else {
            $active = 1;
        }

        if($request->file('mainImage') != null){
            $path = $request->file('mainImage')->store("public/brand/");
        }
        else{
            $path = $image->image;
        }
        
        $affected = DB::table('brands')
            ->where('id', $request->id)
            ->update(['active' => $active, 'garantie' => $request->garantie, 'image' => $path]);

        if($request->deleteImage != null){
            if(Storage::delete($image->image)){
                $query = DB::table('brands')->where('id', '=', $request->id)->update(['image' => null]);

                return back()->with("success", "Image successfuly delete!");
            }
        }

        return back()->with("success", "Successfuly update!");
    }

    public function deleteBrand(Request $request){
        $image = DB::table('brands')
            ->where('id', $request->id)->first();

        if(Storage::delete("public/".$image->image)){
            $query = DB::table('brands')->where('id', '=', $request->id)->delete();

            return redirect('brand')->with("success", "Brand successfuly deleted!");
        }
        else{
            return back()->with("fail", "Somthing went wrong!");
        }
    }
}
