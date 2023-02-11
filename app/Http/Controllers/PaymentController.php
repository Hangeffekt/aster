<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;

class PaymentController extends Controller
{
    function payments(Request $request){
        if($request->id == null){
            $payment = null;
        }
        else if($request->id == "new"){
            $payment = "new";
        }
        else {
            $payment = DB::table('payments')->where('id', $request->id)->first();
        }
        $payments = DB::table('payments')->get();

        return view("admin.payment", ["data"=>$payments, "PaymentData"=>$payment]);
    }

    function updatePayment(Request $request){
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

        $affected = DB::table('payments')
              ->where('id', $request->id)
              ->update(['name' => $request->name, 'content' => $request->content, 'active' => $active, 'cost' => $cost]);

        return back()->with("success", "Successfuly update!");
    }

    function createPayment(Request $request){
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

        $query = DB::table('payments')->insert([
            'name' => $request->name,
            'active' => $active,
            'content' => $request->content,
            'cost' => $cost
        ]);
        return redirect('/admin/payment')->with("success", "New payment created!");
    }

    function deletePayment(Request $request){
        $query = DB::table('payments')->where('id', '=', $request->id)->delete();

        return redirect('/admin/payment')->with("success", "Payment successfuly deleted!");
    }
}
