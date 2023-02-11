<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Shop;

class ShopController extends Controller
{
    function shops(Request $request){
        if($request->id == null){
            $shop = null;
        }
        else if($request->id == "new"){
            $shop = "new";
        }
        else {
            $shop = DB::table('shops')->where('id', $request->id)->first();
        }
        $shops = DB::table('shops')->get();

        return view("admin.shop", ["data"=>$shops, "ShopData"=>$shop]);
    }

    function updateShop(Request $request){
        //validate $request

        $request->validate([
            "name"=>"required",
            "postal_code"=>"required|numeric",
            "town"=>"required",
            "address"=>"required",
            "telephone"=>"required",
            "email"=>"required|email"
        ]);

        //if validate successfuly

        if($request->active == null){
            $active = 0;
        }
        else {
            $active = 1;
        }

        if($request->open == null){
            $open = "";
        }
        else {
            $open = $request->open;
        }

        if($request->takeover == null){
            $takeover = 0;
        }
        else {
            $takeover = 1;
        }

        $affected = DB::table('shops')
              ->where('id', $request->id)
              ->update(['name' => $request->name, 
              'active' => $active, 
              'postal_code' => $request->postal_code, 
              'town' => $request->town, 
              'address' => $request->address, 
              'telephone' => $request->telephone, 
              'email' => $request->email, 
              'open' => $open, 
              'takeover' => $takeover]);

        return back()->with("success", "Successfuly update!");
    }

    function createShop(Request $request){
        //validate $request

        $request->validate([
            "name"=>"required",
            "postal_code"=>"required|numeric",
            "town"=>"required",
            "address"=>"required",
            "telephone"=>"required",
            "email"=>"required|email"
        ]);

        //if validate successfuly

        if($request->active == null){
            $active = 0;
        }
        else {
            $active = 1;
        }

        if($request->open == null){
            $open = "";
        }
        else {
            $open = $request->open;
        }

        if($request->takeover == null){
            $takeover = 0;
        }
        else {
            $takeover = 1;
        }

        $query = DB::table('shops')->insert([
            'name' => $request->name, 
            'active' => $active, 
            'postal_code' => $request->postal_code, 
            'town' => $request->town, 
            'address' => $request->address, 
            'telephone' => $request->telephone, 
            'email' => $request->email, 
            'open' => $open, 
            'takeover' => $takeover
        ]);
        return redirect('shop')->with("success", "New shop created!");
    }

    function deleteShop(Request $request){
        $query = DB::table('shops')->where('id', '=', $request->id)->delete();

        return redirect('/shop')->with("success", "Shop successfuly deleted!");
    }
}
