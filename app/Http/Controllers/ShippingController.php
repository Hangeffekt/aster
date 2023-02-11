<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Shipping;

class ShippingController extends Controller
{
    function shippings(Request $request){
        if($request->id == null){
            $shipping = null;
        }
        else if($request->id == "new"){
            $shipping = "new";
        }
        else {
            $shipping = DB::table('shippings')->where('id', $request->id)->first();
        }
        
        $shippings = DB::table('shippings')->get();

        return view("admin.shipping", ["data"=>$shippings, "ShippingData"=>$shipping]);
    }

    function updateShipping(Request $request){
        //validate $request

        $request->validate([
            "name"=>"required",
            "content"=>"required"
        ]);

        //if validate successfuly

        if($request->active == null){
            $active = 0;
        }
        else {
            $active = 1;
        }

        if($request->cost == null){
            $cost = 0;
        }
        else{
            $cost = $request->cost;
        }

        $affected = DB::table('shippings')
              ->where('id', $request->id)
              ->update(['name' => $request->name, 'content' => $request->content, 'active' => $active, 'cost' => $cost, 'level' => $request->level]);

        return back()->with("success", "Successfuly update!");
    }

    function createShipping(Request $request){
        //validate $request

        $request->validate([
            "name"=>"required",
            "content"=>"required"
        ]);

        //if validate successfuly

        if($request->active == null){
            $active = 0;
        }
        else {
            $active = 1;
        }

        if($request->cost == null){
            $cost = 0;
        }
        else{
            $cost = $request->cost;
        }

        $query = DB::table('shippings')->insert([
            'name' => $request->name,
            'active' => $active,
            'content' => $request->content,
            'cost' => $cost,
            'level' => $request->level
        ]);
        return redirect('shipping')->with("success", "New payment created!");
    }

    function deleteShipping(Request $request){
        $query = DB::table('shippings')->where('id', '=', $request->id)->delete();

        return redirect('/shipping')->with("success", "Payment successfuly deleted!");
    }
}
