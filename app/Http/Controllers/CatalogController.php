<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.catalogs', [
            'Catalogs' => Catalog::get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Catalogs = Catalog::orderby("name")->get();

        return view("admin.createcatalog", ["Catalogs"=>$Catalogs]);
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
            "name"=>"required",
            "parent_id"=>"required|integer",
            "status"=>"required_with:1,null",
            "sub_menu"=>"required_with:1,null",
            "order"=>"required|integer",
        ]);

        $url = str_replace(["Ö", "ö", "Ü", "ü", "Ó", "ó", "Ő", "ő", "Ú", "ú", "É", "é", "Á", "á", "Ű", "ű", "Í", "í"], ["o","o","u","u","o","o","o","o","u","u","e","e","a","a","u","u","i","i",], $request->name);
        $url = str_replace([" ", "_"], "-", $url);

        $newCatalog = new Catalog;
        $newCatalog->name = $request->name;
        $newCatalog->parent_id = $request->parent_id;
        $newCatalog->sub_menu = $request->sub_menu;
        $newCatalog->status = $request->status;
        $newCatalog->order = $request->order;
        $newCatalog->url = $url;
        $newCatalog->save();

        return redirect('admin/catalogs')->with("success", "New catalog created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $catalog_title = Catalog::where('url', $request->id)->first();

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
            $order = "price";
            $order_direction = "ASC";
        }

        if($request->id == null){
            $product = null;
        }
        else{
            if(session("order") != null && session("order") == "price_up"){
                $order = "price";
                $order_direction = "ASC";
            }
            else if(session("order") != null && session("order") == "price_down"){
                $order = "price";
                $order_direction = "DESC";
            }

            if(session("brand") == null || session("brand") == []){
                $query_brand_list = array(1, 2, 3, 4, 5, 6, 7, 8, 9);
            }
            else{
                $query_brand_list = session("brand");
            }

            $product = Product::where('catalog_id', $catalog_title->name)
                ->where('status', 1)
                ->orderBy($order, $order_direction)
                ->paginate(15);
        }

        
        
        $brand_list = null;
        $brand_array = null;
        $brand_product = Product::where('catalog_id', $catalog_title->name)
                ->where('status', 1)
                ->get();

        if($brand_product != null){
            foreach ($brand_product as $product_list){
                $brand_list = DB::table('brands')
                    ->where('name', $product_list->brand)->first();

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

        return view("catalog", ["ProductData"=>$product, "catalogName"=>$request->id, "BrandList"=>$brand_array, "title"=>$catalog_title->name, "Filters"=>$catalog_title->filters]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Catalog $catalog)
    {
        $editCatalog = Catalog::find($catalog->id);

        $Catalogs = Catalog::orderby("name")->get();

        return view("admin.editcatalog", ["editCatalog"=>$editCatalog, "Catalogs"=>$Catalogs]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catalog $catalog)
    {
        $request->validate([
            "name"=>"required",
            "parent_id"=>"required|integer",
            "sub_menu"=>"required_with:1,null",
            "status"=>"required_with:1,null",
            "order"=>"required|integer",
        ]);

        $url = str_replace(["Ö", "ö", "Ü", "ü", "Ó", "ó", "Ő", "ő", "Ú", "ú", "É", "é", "Á", "á", "Ű", "ű", "Í", "í", " ", "_"], ["o","o","u","u","o","o","o","o","u","u","e","e","a","a","u","u","i","i","-","-"], $request->name);

        $Catalog = Catalog::find($catalog->id);
        $Catalog->name = $request->name;
        $Catalog->parent_id = $request->parent_id;
        $Catalog->sub_menu = $request->sub_menu;
        $Catalog->status = $request->status;
        $Catalog->order = $request->order;
        $Catalog->url = $url;
        $Catalog->save();

        return redirect('admin/catalogs')->with("success", "Successfuly update!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Catalog $catalog)
    {
        $Catalog = Catalog::find($request->id);
        $Catalog->delete();

        return back()->with("success", "Brand successfuly deleted!");
    }
}
