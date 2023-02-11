<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Catalog;
use App\Models\Brand;

class CatalogController extends Controller
{
    function catalogs(Request $request){

        if($request->id != null){
            $parent_id = $request->id;
        }
        else {
            $parent_id = $request->mode;
        }
        
        if($request->mode == "new"){
            $catalog = "new";
            $catalogs = DB::table('catalogs')->where('parent_id', $parent_id)->get();
            $back_id = DB::table('catalogs')->where('id', $parent_id)->first();
            $catalog_list = DB::table('catalogs')->get();
        }
        else if($request->mode == "modify"){
            $catalog = DB::table('catalogs')->where('id', $request->mode_id)->first();
            $catalogs = DB::table('catalogs')->where('parent_id', $parent_id)->get();
            $back_id = DB::table('catalogs')->where('id', $parent_id)->first();
            $catalog_list = DB::table('catalogs')->get();
        }
        else if($request->mode == null){
            $catalog = null;
            $catalogs = DB::table('catalogs')->where('parent_id', 0)->get();
            $back_id = null;
            $catalog_list = null;
        }
        else {
            $catalog = null;
            $catalogs = DB::table('catalogs')->where('parent_id', $parent_id)->get();
            $back_id = DB::table('catalogs')->where('id', $parent_id)->first();
            $catalog_list = null;
        }

        return view("admin.catalog", ["data"=>$catalogs, "CatalogData"=>$catalog, "BackId"=>$back_id, "CatalogList"=>$catalog_list]);
    }

    function updateCatalog(Request $request){
        //validate $request

        $request->validate([
            "name"=>"required"
        ]);

        //if validate successfuly

        if($request->active == null){
            $active = 0;
        }
        else {
            $active = 1;
        }

        if($request->order == null){
            $order = "";
        }
        else {
            $order = $request->order;
        }

        $url = str_replace(["Ö", "ö", "Ü", "ü", "Ó", "ó", "Ő", "ő", "Ú", "ú", "É", "é", "Á", "á", "Ű", "ű", "Í", "í"], ["o","o","u","u","o","o","o","o","u","u","e","e","a","a","u","u","i","i",], $request->name);
        $url = str_replace([" ", "_"], "-", $request->name);

        //count sub category
        $parent_category = DB::table('catalogs')->where('parent_id', $request->parent_id)->get();

        $parent_category = (count($parent_category));

        $affected = DB::table('catalogs')
              ->where('id', $request->parent_id)
              ->update(['sub_menu_qty' => $parent_category]);

        $affected = DB::table('catalogs')
              ->where('id', $request->id)
              ->update(['name' => $request->name, 
              'active' => $active, 
              'order' => $order,
              'parent_id' => $request->parent_id,
              'url' => $url]);

        return back()->with("success", "Successfuly update!");
    }

    function createCatalog(Request $request){
        //validate $request

        $request->validate([
            "name"=>"required"
        ]);

        //if validate successfuly

        if($request->active == null){
            $active = 0;
        }
        else {
            $active = 1;
        }

        if($request->order == null){
            $order = "0";
        }
        else {
            $order = $request->order;
        }

        
        $url = str_replace(["Ö", "ö", "Ü", "ü", "Ó", "ó", "Ő", "ő", "Ú", "ú", "É", "é", "Á", "á", "Ű", "ű", "Í", "í"], ["o","o","u","u","o","o","o","o","u","u","e","e","a","a","u","u","i","i",], $request->name);
        $url = str_replace([" ", "_"], "-", $request->name);

        //count sub category
        $parent_category = DB::table('catalogs')->where('parent_id', $request->parant_id)->get();

        $parent_category = count($parent_category)+1;

        $affected = DB::table('catalogs')
              ->where('id', $request->parent_id)
              ->update(['sub_menu_qty' => $parent_category]);

        $query = DB::table('catalogs')->insert([
            'name' => $request->name, 
            'active' => $active,
            'order' => $order,
            'parent_id' => $request->parent_id,
            'url' => $url
        ]);
        return redirect('admin/catalog')->with("success", "New catalog created!");
    }

    function deleteCatalog(Request $request){
        $query = DB::table('catalogs')->where('id', '=', $request->id)->delete();

        return redirect('/catalog')->with("success", "Catalog successfuly deleted!");
    }

    public function show(Request $request){

        $catalog_title = DB::table('catalogs')->where('url', $request->id)->first();

        $order = "gross_price";
        $order_direction = "ASC";
        $query_brand_list = array(1, 2, 3, 4, 5, 6, 7, 8, 9);
        $brands = array();

        //filters
        if($request->order_nema == "price_up" || $request->order_nema == null){
            $order = "gross_price";
            $order_direction = "ASC";
            $request->session()->put("order", "price_up");
        }
        else if($request->order_nema == "price_down"){
            $order = "gross_price";
            $order_direction = "DESC";
            $request->session()->put("order", "price_down");
        }
        else if($request->order_nema == "brand"){
            if(session("brand") == null){
                $brands = array();
            }
            else{
                $brands = session("brand");
                if (($key = array_search($request->order_value_1, $brands)) !== false) {
                    unset($brands[$key]);
                }
            }
            
            array_push($brands, $request->order_value_1);
            $request->session()->put("brand", $brands);
        }
        else if($request->order_nema == "removebrand"){
            $brands = session("brand");
            if($brands != null){
                if (($key = array_search($request->order_value_1, $brands)) !== false) {
                    unset($brands[$key]);
                }
                if (($key = array_search("style", $brands)) !== false) {
                    unset($brands[$key]);
                }
            }

            if($brands == null || $brands == []){
                $request->session()->put("brand", null);
            }
            else{
                $request->session()->put("brand", $brands);
            }
        }
        else {
            $order = "gross_price";
            $order_direction = "ASC";
        }

        if($request->id == null){
            $product = null;
        }
        else{
            if(session("order") != null && session("order") == "price_up"){
                $order = "gross_price";
                $order_direction = "ASC";
            }
            else if(session("order") != null && session("order") == "price_down"){
                $order = "gross_price";
                $order_direction = "DESC";
            }

            if(session("brand") == null || session("brand") == []){
                $query_brand_list = array(1, 2, 3, 4, 5, 6, 7, 8, 9);
            }
            else{
                $query_brand_list = session("brand");
            }

            $product = DB::table('products')
                ->leftjoin('product_prices', 'products.id', '=', 'product_prices.product_id')
                ->leftjoin('product_descriptions', 'products.id', '=', 'product_descriptions.product_id')
                ->leftjoin('product_images', 'products.id', '=', 'product_images.product_id')
                ->where('category_id', $catalog_title->id)
                ->whereIn('brand_id', $query_brand_list)
                ->where('active', 1)
                ->orderBy($order, $order_direction)
                ->paginate(15);
        }
        
        $brand_list = null;
        $brand_array = null;
        $brand_product = DB::table('products')
                ->where('category_id', $catalog_title->id)
                ->where('active', 1)
                ->get();

        if($brand_product != null){
            foreach ($brand_product as $product_list){
                $brand_list = DB::table('brands')
                    ->where('id', $product_list->brand_id)->first();

                $ok = 1;

                if($brand_array == null){
                    $brand_array = [];
                    $brand_array1 = array("id" => $brand_list->id, "name" => $brand_list->name);
                    $query_brand_list = array("id" => $brand_list->id);
                    array_push($brand_array, $brand_array1);
                }
                else{
                    for($i = 0; $i<count($brand_array); $i++){
                         
                        if($brand_array[$i]["name"] == $brand_list->name){
                            $ok = 1;
                            break;
                        }
                        else{
                            $ok = 0;
                        }
                    }

                    if($ok == 0){
                        array_push($query_brand_list, ["id" => $brand_list->id]);
                        array_push($brand_array, $brand_array1 = ["id" => $brand_list->id, "name" => $brand_list->name]);
                    }
                }
            }
        }
        if($brand_array != null){
            asort($brand_array);
            json_encode($brand_array);
        }
        

        return view("catalog", ["ProductData"=>$product, "catalogName"=>$request->id, "BrandList"=>$brand_array, "title"=>$catalog_title->name]);

    }
}
