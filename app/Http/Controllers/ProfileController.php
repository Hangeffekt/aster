<?php

namespace App\Http\Controllers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserInvoice;
use App\Models\PublicSpace;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(Request $request){

        $user = User::where('id', session("LoggedUser"))->first();

        $user_address = UserAddress::where('user_id', session("LoggedUser"))
            ->where('active', 1)->first();
                
        $invoice_address = UserInvoice::where('user_id', session("LoggedUser"))
            ->where('active', 1)->first();
        
        $orders = DB::table('orders')
            ->where('user_id', session("LoggedUser"))
            ->orderBy("id", "desc")->limit(5)->get();

        if($orders != null){
            $ordered_products = null;
            foreach($orders as $order_object_array){
                $orders_array = explode("|", $order_object_array->products);

                foreach($orders_array as $orders_object){
                    $products = explode(";", $orders_object);

                    $product_name = explode("=", $products[0]);

                    $product_qty = explode("=", $products[1]);

                    $product_price = explode("=", $products[2]);

                    $product_array = array("order_id"=>$order_object_array->id, $product_name[0]=>$product_name[1], $product_qty[0]=>$product_qty[1], $product_price[0]=>$product_price[1]);
                    if($ordered_products == null){
                        $ordered_products = array($product_array);
                    }
                    else {
                        array_push($ordered_products, $product_array);
                    }
                    
                }
            }
        }

        json_encode($ordered_products);

        return view("profile", ["User"=>$user, 'UserAddress'=>$user_address, 'InvoiceAddress'=>$invoice_address, "Orders"=>$orders, "Products"=>$ordered_products, "Title"=>"Profil"]);

    }

    public function editProfile(Request $request){

        $user = User::where('id', session("LoggedUser"))->first();

        return view("editProfile", ["User"=>$user, "Title"=>"Profil"]);
    }

    public function modifyProfile(Request $request){

        $request->validate([
            "first_name"=>"required",
            "last_name"=>"required",
            "email"=>"required|email",
            "telephone"=>"numeric"
        ]);

        if(session("LoggedUser") != null){
            $id = session("LoggedUser");
        }
        else if($request->id != null){
            $id = $request->id;
        }
        else{
            return back()->with("success", "Hiba történt!");
        }

        $user = User::where('id', $id)
            ->update(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'email' => $request->email, 'telephone' => $request->telephone]);

        return back()->with("success", "A változásokat sikeresn mentettük!");
    }

    public function modifyPassword(Request $request){

        $request->validate([
            "old_password"=>"required",
            "new_password"=>"required|min:6|max:12",
            "new_password_repeat"=>"same:new_password"
        ]);

        $password = Hash::make($request->new_password);

        $user = User::where("id", session("LoggedUser"))->first();

        if(Hash::check($request->old_password, $user->password)){
            $user = User::where('id', session("LoggedUser"))
            ->update(['password' => $password]);
            return back()->with("success", "Az új jelszót sikeresn mentettük!");
        }
        else{
            return back()->with("password_error", "A régi jelszó nem megfelelő");
        }
        
    }

    public function address(Request $request){

        $user = User::where('id', session("LoggedUser"))->first();

        //set admin or user want to modify
        if(session("Admintoltotkaposzta")){
            $user_id = $request->userid;
        }
        else if(session("LoggedUser")){
            $user_id = session("LoggedUser");
        }

        //set to wanna modify address

        if($request->addressid == null){
            $modify_address = null;
        }
        else{
            $modify_address = UserAddress::where('user_id', $user_id)
                ->where('id', '=', $request->addressid)->first();
        }

        //list of user adresses

        $user_address = UserAddress::where('user_id', $user_id)->get();
        
        $ps_lists = PublicSpace::get();

        if(session("Admintoltotkaposzta")){
            return view("admin.address", ["User"=>$user, 'UserAddress'=>$user_address, 'ps_lists'=>$ps_lists, 'modify_address'=>$modify_address]);
        }
        else if(session("LoggedUser")){
            return view("address", ["User"=>$user, 'UserAddress'=>$user_address, 'ps_lists'=>$ps_lists, 'modify_address'=>$modify_address, "Title"=>"Szállítási cím"]);
        }
        else {
            return back()->with("fail", "Something went wrong!");
        }
    }

    public function invoice(Request $request){

        $user = User::where('id', session("LoggedUser"))->first();

        if($request->addressid == null){
            $modify_address = null;
        }
        else{
            $modify_address = UserInvoice::where('user_id', session("LoggedUser"))
                ->where('id', '=', $request->addressid)->first();
        }

        $user_address = UserInvoice::where('user_id', session("LoggedUser"))->get();
        
        $ps_lists = PublicSpace::get();

        return view("invoice", ["User"=>$user, 'InvioceAddress'=>$user_address, 'ps_lists'=>$ps_lists, 'modify_address'=>$modify_address, "Title"=>"Szállítási cím"]);

    }

    public function addDelivery(Request $request){
        //validate $request
        
        $request->validate([
            "first_name"=>"required",
            "zip_code"=>"required|numeric",
            "town"=>"required",
            "street"=>"required",
            "street_type"=>"required",
            "number_floor"=>"required"
        ]);

        if($request->active == "on"){
            
            $user_address = UserAddress::where('user_id', session("LoggedUser"))
                ->where('active', 1)->first();

            if($user_address != null){
                $affected = UserAddress::where('id', $user_address->id)
                ->update(['active' => 0]);
            }

            $active = 1;
        }
        else {
            $active = 0;
        }

        $affected = DB::table('user_addresses')->insert([
            'user_id' => session("LoggedUser"),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'zip_code' => $request->zip_code,
            'town' => $request->town,
            'street' => $request->street,
            'street_type' => $request->street_type,
            'number_floor' => $request->number_floor,
            'active' => $active
        ]);

        /** Success message */

        $success = "A szállítási címet mentettük!";
        
        /* If on copy to invoice table */

        if($request->copy_invoice == "on"){

            $user_invoice = UserInvoice::where('user_id', session("LoggedUser"))
                ->where('active', 1)->first();

            if($user_invoice != null){
                $affected = UserInvoice::where('user_id', $user_invoice->id)
                    ->update(['active' => 0]);
            }

            $affected = DB::table('user_invoices')->insert([
                'user_id' => session("LoggedUser"),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'zip_code' => $request->zip_code,
                'town' => $request->town,
                'street' => $request->street,
                'street_type' => $request->street_type,
                'number_floor' => $request->number_floor,
                'active' => 1
            ]);

            $success = "A szállítási és számlázási címet mentettük!";
        }

        return back()->with("success", $success);

    }

    public function addInvoice(Request $request){
        //validate $request

        $request->validate([
            "first_name"=>"required",
            "zip_code"=>"required|numeric",
            "town"=>"required",
            "street"=>"required",
            "street_type"=>"required",
            "number_floor"=>"required"
        ]);

        if($request->active == "on"){
            
            $user_address = UserInvoice::where('user_id', session("LoggedUser"))
                ->where('active', 1)->first();

            if($user_address != null){
                $affected = UserInvoice::where('id', $user_address->id)
                ->update(['active' => 0]);
            }

            $active = 1;
        }
        else {
            $active = 0;
        }

        $affected = DB::table('user_invoices')->insert([
            'user_id' => session("LoggedUser"),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'zip_code' => $request->zip_code,
            'town' => $request->town,
            'street' => $request->street,
            'street_type' => $request->street_type,
            'number_floor' => $request->number_floor,
            'active' => $active
        ]);

        /** Success message */

        $success = "A számlázási címet mentettük!";
        
        /* If on copy to invoice table */

        if($request->copy_invoice == "on"){

            $user_invoice = UserAddress::where('user_id', session("LoggedUser"))
                ->where('active', 1)->first();

            if($user_address != null){
                $affected = UserAddress::where('id', $user_invoice->id)
                    ->update(['active' => 0]);
            }
            
            $affected = DB::table('user_addresses')->insert([
                'user_id' => session("LoggedUser"),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'zip_code' => $request->zip_code,
                'town' => $request->town,
                'street' => $request->street,
                'street_type' => $request->street_type,
                'number_floor' => $request->number_floor,
                'active' => 1
            ]);

            $success = "A számlázási és szállítási címet mentettük!";
        }

        return back()->with("success", $success);

    }

    public function deleteDelivery(Request $request){

        $query = UserAddress::where('id', '=', $request->address_id)
            ->where('user_id', '=', session("LoggedUser"))->delete();

        return redirect('address')->with("success", "A szállítási címet töröltük!");
    }

    public function deleteInvoice(Request $request){

        $query = UserInvoice::where('id', '=', $request->address_id)
            ->where('user_id', '=', session("LoggedUser"))->delete();

        return redirect('invoice')->with("success", "A számlázásai címet töröltük!");
    }

    public function modifyDelivery(Request $request){
        //validate $request

        $request->validate([
            "address_id"=>"required|numeric",
            "first_name"=>"required",
            "zip_code"=>"required|numeric",
            "town"=>"required",
            "street"=>"required",
            "street_type"=>"required",
            "number_floor"=>"required"
        ]);

        //set the user id
        if(session("LoggedUser")){
            $user_id = session("LoggedUser");
        }
        else{
            $user_id = $request->user_id;
        }

        if($request->active == "on"){
            
            $user_address = UserAddress::where('user_id', $user_id)
                ->where('active', 1)->first();

            if($user_address != null){
                $affected = UserAddress::where('id', $user_address->id)
                ->update(['active' => 0]);
            }

            $active = 1;
        }
        else {
            $active = 0;
        }

        $affected = DB::table('user_addresses')
            ->where('user_id', $user_id)
            ->where('id', $request->address_id)
            ->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'zip_code' => $request->zip_code,
            'town' => $request->town,
            'street' => $request->street,
            'street_type' => $request->street_type,
            'number_floor' => $request->number_floor,
            'active' => $active
        ]);

        /** Success message */

        $success = "A szállítási címet módosítottuk!";
        
        /* If on copy to invoice table */

        if($request->copy_invoice == "on"){

            $user_invoice = UserInvoice::where('user_id', $user_id)
                ->where('active', 1)->first();

            if($user_invoice != null){
                $affected = UserInvoice::where('id', $user_invoice->id)
                    ->update(['active' => 0]);
            }

            $affected = DB::table('user_invoices')->insert([
                'user_id' => $user_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'zip_code' => $request->zip_code,
                'town' => $request->town,
                'street' => $request->street,
                'street_type' => $request->street_type,
                'number_floor' => $request->number_floor,
                'active' => 1
            ]);

            $success = "A szállítási és számlázási címet módosítottuk!";
        }

        return back()->with("success", $success);
    }

    public function modifyInvoices(Request $request){
        //validate $request

        $request->validate([
            "address_id"=>"required|numeric",
            "first_name"=>"required",
            "zip_code"=>"required|numeric",
            "town"=>"required",
            "street"=>"required",
            "street_type"=>"required",
            "number_floor"=>"required"
        ]);

        //set the user id
        if(session("LoggedUser")){
            $user_id = session("LoggedUser");
        }
        else{
            $user_id = $request->user_id;
        }

        if($request->active == "on"){
            
            $user_address = UserInvoice::where('user_id', $user_id)
                ->where('active', 1)->first();

            if($user_address != null){
                $affected = UserInvoice::where('id', $user_address->id)
                ->update(['active' => 0]);
            }

            $active = 1;
        }
        else {
            $active = 0;
        }

        $affected = DB::table('user_invoices')
            ->where('user_id', $user_id)
            ->where('id', $request->address_id)
            ->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'zip_code' => $request->zip_code,
            'town' => $request->town,
            'street' => $request->street,
            'street_type' => $request->street_type,
            'number_floor' => $request->number_floor,
            'active' => $active
        ]);

        /** Success message */

        $success = "A szállítási címet módosítottuk!";
        
        /* If on copy to invoice table */

        if($request->copy_invoice == "on"){

            $user_address = UserAddress::where('user_id', $user_id)
                ->where('active', 1)->first();

            if($user_address != null){
                $affected = UserAddress::where('id', $user_address->id)
                    ->update(['active' => 0]);
            }
            
            $affected = DB::table('user_addresses')->insert([
                'user_id' => $user_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'zip_code' => $request->zip_code,
                'town' => $request->town,
                'street' => $request->street,
                'street_type' => $request->street_type,
                'number_floor' => $request->number_floor,
                'active' => 1
            ]);

            $success = "A szállítási és számlázási címet módosítottuk!";
        }

        return back()->with("success", $success);
    }

    function order(Request $request){

        $user = User::where('id', session("LoggedUser"))->first();
        
        $order = DB::table('orders')
                ->where('user_id', session("LoggedUser"))
                ->where('id', $request->id)->first();
        
                if($order != null){
                    $ordered_products = null;
                        $orders_array = explode("|", $order->products);
        
                        foreach($orders_array as $orders_object){
                            $products = explode(";", $orders_object);
        
                            $product_name = explode("=", $products[0]);
        
                            $product_qty = explode("=", $products[1]);
        
                            $product_price = explode("=", $products[2]);
        
                            $product_array = array("order_id"=>$order->id, $product_name[0]=>$product_name[1], $product_qty[0]=>$product_qty[1], $product_price[0]=>$product_price[1]);
                            if($ordered_products == null){
                                $ordered_products = array($product_array);
                            }
                            else {
                                array_push($ordered_products, $product_array);
                            }
                            
                        }
                }

            $ps_lists = DB::table('public_spaces')->get();

        return view("order", ["User"=>$user, 'Orders'=>$order, 'ps_lists'=>$ps_lists, "ProductData"=>$ordered_products, "Title"=>"Rendelés"]);
    }

    function orders(Request $request){

        $user = User::where('id', session("LoggedUser"))->first();

        $orders = DB::table('orders')
                ->where('user_id', session("LoggedUser"))
                ->orderBy("id", "desc")->paginate(10);

                if($orders != null){
                    $ordered_products = null;
                    foreach($orders as $order_object_array){
                        $orders_array = explode("|", $order_object_array->products);
        
                        foreach($orders_array as $orders_object){
                            $products = explode(";", $orders_object);
        
                            $product_name = explode("=", $products[0]);
        
                            $product_qty = explode("=", $products[1]);
        
                            $product_price = explode("=", $products[2]);
        
                            $product_array = array("order_id"=>$order_object_array->id, $product_name[0]=>$product_name[1], $product_qty[0]=>$product_qty[1], $product_price[0]=>$product_price[1]);
                            if($ordered_products == null){
                                $ordered_products = array($product_array);
                            }
                            else {
                                array_push($ordered_products, $product_array);
                            }
                            
                        }
                    }
                }

        return view("orders", ["User"=>$user, "Orders"=>$orders, "Products"=>$ordered_products, "Title"=>"Rendelések"]);
    }

    //admin controllers
    public function adminUsers(Request $request){
        $users = DB::table('users')->paginate(10);

        return view("admin.users", ["Users"=>$users, "Title"=>"Users"]);
    }

    public function adminUser(Request $request){

        $user = User::where("id", $request->userid)->first();

        $user_address = UserAddress::where("user_id", $request->userid)
        ->where("active", $request->userid)
        ->first();

        $invoice_address = UserInvoice::where("user_id", $request->userid)
        ->where("active", $request->userid)
        ->first();

        $ps_lists = DB::table('public_spaces')->get();

        return view("admin.user", ["User"=>$user, "modify_address"=>$user_address, "modify_invoice"=>$invoice_address, "Title"=>"User", "ps_lists"=>$ps_lists, "Orders"=>null]);
    }
}
