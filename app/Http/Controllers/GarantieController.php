<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Garantie;

class GarantieController extends Controller
{
    function Garantie(Request $request){

        if($request->id == null){
            $garantie = null;
        }
        else if($request->id == "new"){
            $garantie = "new";
        }
        else {
            $garantie = DB::table('garanties')->where('id', $request->id)->first();
        }
    
        $garanties = DB::table('garanties')->paginate(15);

        return view("admin.garantie", ["data"=>$garanties, "garantieData"=>$garantie]);
    }

    public function createGarantie(Request $request) {
        //validate $request
        $request->validate([
            "name"=>"required|unique:garanties",
            "inside_name"=>"required",
            "garantie"=>"required|numeric",
        ]);

        //if validate successfuly

        if($request->active == null){
            $active = 0;
        }
        else {
            $active = 1;
        }

        $affected = DB::table('garanties')->insert([
            'name' => $request->name,
            'inside_name' => $request->inside_name,
            'garantie' => $request->garantie,
            'active' => $active
        ]);

        return back()->with("success", "New garantie created!");
    }

    public function updateGarantie(Request $request){

        //validate $request
        $request->validate([
            "name"=>"required|unique:garanties",
            "inside_name"=>"required",
            "garantie"=>"required|numeric",
        ]);

        //if validate successfuly

        if($request->active == null){
            $active = 0;
        }
        else {
            $active = 1;
        }

        $affected = DB::table('garanties')
            ->where('id', $request->id)
            ->update(['name' => $request->name, 'inside_name' => $request->inside_name, 'garantie' => $request->garantie, 'active' => $active]);

        return back()->with("success", "Successfuly update!");
    }

    public function deleteGarantie(Request $request){
        $query = DB::table('garanties')->where('id', '=', $request->id)->delete();

        return redirect('admin/garantie')->with("success", "Garantie successfuly deleted!");
    }
    
}
