<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Cart;

class CartController extends Controller
{
    function show(Request $request){

        $product = DB::table('carts')
            ->leftjoin('products', 'carts.product_id', '=', 'products.id')
            ->where('user_id', session("LoggedUser"))->get();

        return view("cart", ["ProductData"=>$product, "Title"=>"Kosár"]);
    }

    function refreshCart(Request $request){

        //validate $request

        $request->validate([
            "product_id"=>"required|numeric",
            "quantity"=>"required|numeric"
        ]);

        $affected = DB::table('carts')
            ->where('cart_id', $request->product_id)
            ->where('user_id', session("LoggedUser"))
            ->update(['cart_quantity' => $request->quantity]);

        return redirect('cart')->with("success", "Kosarát frissítettük!");
    }

    function deleteCart(Request $request){

        $request->validate([
            "product_id"=>"required|numeric"
        ]);

        $affected = DB::table('carts')
            ->where('cart_id', $request->product_id)->delete();
            

        return redirect('cart')->with("success", "A terméket töröltük a kosárból!");
    }

    function delivery(Request $request){

        $level = 0;
        $delivery_obj = null;
        $run = 0;

        $product = DB::table('carts')
            ->leftjoin('products', 'carts.product_id', '=', 'products.id')
            ->where('user_id', session("LoggedUser"))->get();
        
        $cart_info = DB::table('cart_infos')
            ->where('user_id', session("LoggedUser"))->first();

        foreach($product as $objekt){
            $delivery = DB::table('shippings')
                ->where('id', $objekt->shipping)
                ->where('active', 1)->first();

            if($run == 0){
                $delivery_obj = $delivery;
                $run = 1;
            }
            else{
                if($level < $delivery->level){
                    $level = $delivery->level;
                    $delivery_obj = $delivery;
                }
            }
        }

        $takeover = DB::table('shops')
            ->where("status", 1)
            ->where("takeover", 1)->get();

        $shipping_address = DB::table('user_addresses')
            ->where('user_id', session("LoggedUser"))->get();
        
        $ps_lists = DB::table('public_spaces')->get();

        if(count($product) == 0){
            return back();
        }
        else{
            return view("delivery", ["takeover"=>$takeover, 'ps_lists'=>$ps_lists, "ProductData"=>$product,"CartInfo"=>$cart_info, "Delivery"=>$delivery_obj, "ShippingAddress"=>$shipping_address, "Title"=>"Szállítás és fizetés"]);
        }
        
    }

    function finishDelivery(Request $request){

        //validate $request
        $request->validate([
            "delivery_type"=>"required|numeric"
        ]);

        $cart_info = DB::table('cart_infos')
            ->where("user_id", session("LoggedUser"))->first();

        //choose delivery
        if($request->delivery_type == 0){
            $delivery_address = DB::table('user_addresses')
                ->where("user_id", session("LoggedUser"))
                ->where("id", $request->delivery_address)->first();

            //which delivery use the product
            $level = 0;
            $delivery_obj = null;
            $run = 0;

            $product = DB::table('carts')
                ->leftjoin('products', 'carts.product_id', '=', 'products.id')
                ->where('user_id', session("LoggedUser"))->get();

            foreach($product as $objekt){
                $delivery = DB::table('shippings')
                    ->where('id', $objekt->shipping)
                    ->where('active', 1)->first();

                if($run == 0){
                    $delivery_obj = $delivery;
                    $run = 1;
                }
                else{
                    if($level < $delivery->level){
                        $level = $delivery->level;
                        $delivery_obj = $delivery;
                    }
                }
            }
            
            if($delivery_address != null){
                //if cart_info exists
                if($cart_info != null){
                    $affected = DB::table('cart_infos')
                        ->where('user_id', session("LoggedUser"))
                        ->update(['takeover' => null,'delivery_id' => $delivery_obj->id, 'delivery_address'=>$request->delivery_address]);
                       
                    return redirect("/payment");
                }
                //if cart_info not exists
                else{
                    $affected = DB::table('cart_infos')->insert([
                        'user_id' => session("LoggedUser"),
                        'delivery_id' => $delivery_obj->id,
                        'delivery_address' => $request->delivery_address
                    ]);

                    return redirect("/payment");
                }
            }
            else{
                
                return redirect("/delivery")->with("fail", "Hiba történt, kérjük próbálja meg újra");
            }
        }
        //choose takeover
        else {
            $takeover = DB::table('shops')
                ->where("status", 1)
                ->where("shop_id", $request->delivery_type)
                ->where("takeover", 1)->first();
                
            //if cart_info exists
            if($cart_info != null){
                if($takeover == null){
                    return redirect("/delivery")->with("fail", "Hiba történt, kérjük próbálja meg újra");
                }
                else {
                    $affected = DB::table('cart_infos')
                        ->where('user_id', session("LoggedUser"))
                        ->update(['takeover' => $request->delivery_type, 'delivery_id'=>null, 'delivery_address'=>null]);

                    return redirect("payment");
                }
            }
            //if cart_info not exists
            else {
                if($takeover == null){
                    return redirect("/delivery")->with("fail", "Hiba történt, kérjük próbálja meg újra");
                }
                else {
                    $affected = DB::table('cart_infos')->insert([
                        'user_id' => session("LoggedUser"),
                        'takeover' => $request->delivery_type,
                        'delivery_address' => null
                    ]);

                    return redirect("payment");
                }
            }
            
        }
    }

    public function payment(Request $request){

        $product = DB::table('carts')
            ->leftjoin('products', 'carts.product_id', '=', 'products.id')
            ->where('user_id', session("LoggedUser"))->get();

        $payment = DB::table('payments')
            ->where('active', 1)->get();
        

        $cart_info = DB::table('cart_infos')
            ->where('user_id', session("LoggedUser"))->first();
        
            if($cart_info->delivery_id != null){
                $delivery =DB::table('shippings')
                    ->where('id', $cart_info->delivery_id)->first();
            }
            else{
                $delivery =DB::table('shops')
                    ->where('shop_id', $cart_info->takeover)->first();
            }

        $invoice_address = DB::table('user_invoices')
            ->where('user_id', session("LoggedUser"))->get();

        $ps_lists = DB::table('public_spaces')->get();
        
        if($delivery == null){
            return redirect("/delivery")->with("fail", "Hiba történt, kérjük próbálja meg újra");
        }
        else{
            return view("payment", ["ProductData"=>$product, 'ps_lists'=>$ps_lists, "CartInfo"=>$cart_info, "deliveryInfo"=>$delivery, "paymantMethods"=>$payment, "InvoiceAddress"=>$invoice_address, "Title"=>"Fizetés"]);
        }
    }

    public function finishPayment(Request $request){
        $request->validate([
            "payment_type"=>"required|numeric",
            "payment_address"=>"required|numeric"
        ]);
        
        $payment_address = DB::table('user_invoices')
            ->where("id", $request->payment_address)
            ->where("user_id", session("LoggedUser"))->first();

        if($payment_address != null){
            $payment_type = DB::table('payments')
                ->where("id", $request->payment_type)->first();
            
            if($payment_type != null){
                $affected = DB::table('cart_infos')
                    ->where('user_id', session("LoggedUser"))
                    ->update(['payment_id' => $request->payment_type, 'invoice_address'=>$request->payment_address]);

                return redirect("/checkout");
            }
            else{
                return redirect("/payment")->with("fail", "Hiba történt, kérjük próbálja meg újra");
            }
        }
        else{
            return redirect("/payment")->with("fail", "Hiba történt, kérjük próbálja meg újra");
        }
    }

    public function checkout(Request $request){

        $product = DB::table('carts')
            ->leftjoin('products', 'carts.product_id', '=', 'products.id')
            ->where('user_id', session("LoggedUser"))->get();

        $delivery_info = DB::table('cart_infos')
            ->where('user_id', session("LoggedUser"))->first();
        
        if($delivery_info->delivery_id != null){
            $delivery = DB::table('shippings')
                ->where('id', $delivery_info->delivery_id)->first();
            $delivery_shop = null;
        }
        else{
            $delivery_shop = DB::table('shops')
                ->where('shop_id', $delivery_info->takeover)->first();
            $delivery = null;
        }

        $user_address = DB::table('user_addresses')
            ->where('user_id', session("LoggedUser"))
            ->where('id', $delivery_info->delivery_address)->first();

        $payment = DB::table('payments')
            ->where('id', $delivery_info->payment_id)->first();

        $invoice_address = DB::table('user_invoices')
            ->where('user_id', session("LoggedUser"))
            ->where('id', $delivery_info->invoice_address)->first();

        return view("checkout", ["ProductData"=>$product, "deliveryInfo"=>$delivery, "deliveryShop"=>$delivery_shop, "DeliveryAddress"=>$user_address, "Payment"=>$payment, "InvoiceAddress"=>$invoice_address, "Title"=>"Ellenörzés"]);
    }

    public function finishCheckout(Request $request){

        $products_array = array();
        $array_count = 0;

        $request->validate([
            "aszf"=>"required"
        ]);

        $product = DB::table('carts')
            ->leftjoin('products', 'carts.product_id', '=', 'products.id')
            ->where('user_id', session("LoggedUser"))->get();

        $delivery_info = DB::table('cart_infos')
            ->where('user_id', session("LoggedUser"))->first();
        
        if($delivery_info->delivery_id != null){
            $delivery = DB::table('shippings')
                ->where('id', $delivery_info->delivery_id)->first();
            $shop = 0;
        }
        else{
            $delivery = DB::table('shops')
                ->where('shop_id', $delivery_info->takeover)->first();
            $shop = 1;
        }

        $user_address = DB::table('user_addresses')
            ->where('user_id', session("LoggedUser"))
            ->where('id', $delivery_info->delivery_address)->first();

        if($shop == 1){
            $first_name = $delivery->shop_name;
            $last_name = "";
            $zip_code = $delivery->postal_code;
            $town = $delivery->town;
            $street = $delivery->address;
            $street_type = null;
            $number_floor = null;
        }
        else if($user_address == null){
            $first_name = null;
            $last_name = null;
            $zip_code = null;
            $town = null;
            $street = null;
            $street_type = null;
            $number_floor = null;
        }
        
        else{
            $first_name = $user_address->first_name;
            $last_name = $user_address->last_name;
            $zip_code = $user_address->zip_code;
            $town = $user_address->town;
            $street = $user_address->street;
            $street_type = $user_address->street_type;
            $number_floor = $user_address->number_floor;
        }

        $payment = DB::table('payments')
            ->where('id', $delivery_info->payment_id)->first();

        $invoice_address = DB::table('user_invoices')
            ->where('user_id', session("LoggedUser"))
            ->where('id', $delivery_info->invoice_address)->first();

        foreach($product as $objekt){
            if($array_count == 0){
                $products_array = "product=".$objekt->name.";qty=".$objekt->cart_quantity.";price=".$objekt->price;
                $array_count = 1;
                
            }
            else{
                $products_array = $products_array."|product=".$objekt->name.";qty=".$objekt->cart_quantity.";price=".$objekt->price;
            }
        }

        $date = date("Y-m-d H:i:s");

        $affected = DB::table('orders')->insert([
            'user_id' => session("LoggedUser"),
            'status' => 1,
            'delivery_mode' => $delivery->shop_name,
            'delivery_first_name' => $first_name,
            'delivery_last_name' => $last_name,
            'delivery_zip_code' => $zip_code,
            'delivery_town' => $town,
            'delivery_street' => $street,
            'delivery_street_type' => $street_type,
            'delivery_number_floor' => $number_floor,
            'delivery_cost' => $delivery->cost, 
            'payment_mode' => $payment->name,
            'invoice_first_name' => $invoice_address->first_name,
            'invoice_last_name' => $invoice_address->last_name,
            'invoice_zip_code' => $invoice_address->zip_code,
            'invoice_town' => $invoice_address->town,
            'invoice_street' => $invoice_address->street,
            'invoice_street_type' => $invoice_address->street_type,
            'invoice_number_floor' => $invoice_address->number_floor,
            'invoice_tax_number' => $invoice_address->tax_number,
            'payment_cost' => $payment->cost,
            'comment' => $request->comment,
            'products' => $products_array
        ]);

        $affected = DB::table('cart_infos')
            ->where('user_id', session("LoggedUser"))->delete();

        $affected = DB::table('carts')
            ->where('user_id', session("LoggedUser"))->delete();
        
        return redirect("/thankyou");
    }

    public function thankyou(Request $request){
        return view("thankyou", ["Title"=>"Sikeres rendelés!"]);
    }
}
