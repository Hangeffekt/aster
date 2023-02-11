<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Carts;
use App\Models\Shipping;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Products = Product::orderby("name")->paginate(5);

        return view("admin.product", ["data"=>$Products]);
    }

    //search
    public function search(Request $request)
    {
        $Products = Product::where('name', 'LIKE', '%'.$request->search.'%')
        ->orWhere("brand", 'LIKE', '%'.$request->search.'%')
        ->orWhere("catalog_id", 'LIKE', '%'.$request->search.'%')
        ->paginate(15);

        return view("search", compact("Products"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Catalogs = Catalog::orderby("name")->get();
        $Brands = Brand::orderby("name")->get();
        $deliveries = Shipping::orderby("shop_name")->get();

        return view("admin.createproduct", compact("Catalogs", "Brands", "deliveries"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "brand"=>"required",
            "name"=>"required",
            "article_number"=>"required",
            "ean"=>"required",
            "delivery"=>"required|numeric",
            "price"=>"required|numeric",
            "qty"=>"numeric",
            "catalog_id"=>"required",
            "qty"=>"numeric"
        ]);

        if($request->status == null){
            $status = 0;
        }
        else {
            $status = 1;
        }

        if($request->order == null){
            $order = "0";
        }
        else {
            $order = $request->order;
        }

        $url = str_replace(["Ö", "ö", "Ü", "ü", "Ó", "ó", "Ő", "ő", "Ú", "ú", "É", "é", "Á", "á", "Ű", "ű", "Í", "í"], ["o","o","u","u","o","o","o","o","u","u","e","e","a","a","u","u","i","i",], $request->name);
        $url = str_replace([" ", "_"], "-", $url);

        //if validate successfuly

        $images=array();
        if($files=$request->file('images')){
            foreach($files as $file){
                $path = $file->store($request->directory);
                $images[]=$path;
            }
        }
        
        $newProduct = new Product;
        $newProduct->brand = $request->brand;
        $newProduct->name = $request->name;
        $newProduct->ean = $request->ean;
        $newProduct->price = $request->price;
        $newProduct->qty = $request->qty;
        $newProduct->article_number = $request->article_number;
        $newProduct->catalog_id = $request->catalog_id;
        $newProduct->shipping = $request->delivery;
        $newProduct->websiteimages = $request->websiteimages;
        $newProduct->status = $status;
        $newProduct->order = $order;
        $newProduct->url = $url;
        $newProduct->images = json_encode($images);
        $newProduct->save();

        return redirect('admin/products')->with("success", "New product created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $product = Product::where("url", $request->id)->first();

        $brand = Brand::where("name", $product->brand)->first();

        $ProductsQty = Product::where("brand", $product->brand)->get();

        return view("product", ["ProductData"=>$product, "BrandList"=>$brand, "ProductsQty"=>$ProductsQty, "Shippings"=>null, "Title"=>$product->name]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Product $product)
    {
        $ProductData = Product::find($request->id);
        $Catalogs = Catalog::orderby("name")->get();
        $Brands = Brand::orderby("name")->get();
        $Deliveries = Shipping::orderby("shop_name")->get();

        return view("admin.editproduct", compact("Catalogs", "Brands", "ProductData", "Deliveries"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            "brand"=>"required",
            "name"=>"required",
            "article_number"=>"required",
            "ean"=>"required|numeric",
            "delivery"=>"required|numeric",
            "price"=>"required|numeric",
            "qty"=>"numeric",
            "catalog_id"=>"required",
            "qty"=>"numeric"
            
        ]);

        if($request->status == null){
            $status = 0;
        }
        else {
            $status = 1;
        }

        if($request->order == null){
            $order = "0";
        }
        else {
            $order = $request->order;
        }

        $url = str_replace(["Ö", "ö", "Ü", "ü", "Ó", "ó", "Ő", "ő", "Ú", "ú", "É", "é", "Á", "á", "Ű", "ű", "Í", "í"], ["o","o","u","u","o","o","o","o","u","u","e","e","a","a","u","u","i","i",], $request->name);
        $url = str_replace([" ", "_"], "-", $url);

        //delete images if choosed
        
        $data = Product::find($request->id);
        if($data->images != null){
            $images = json_decode($data->images);
        }
        else {
            $images = array();
        }

        if($request->deleteImages != null){
            foreach($request->deleteImages as $index=>$deleteImage){
                $images[$index] = null;
            }
        }
        
        if($images != null){
            foreach($images as $index=>$image){
                
                if($image == null){
                    unset($images[$index]);
                }
            }
        }
        
        //add images to array
        if($files=$request->file('images')){
            foreach($files as $file){
                $path = $file->store($request->directory);
                array_push($images, $path);
            }
        }

        //reindex array
        $images = array_values($images);
        
        //update datas
        $Product = Product::find($request->id);
        $Product->brand = $request->brand;
        $Product->name = $request->name;
        $Product->ean = $request->ean;
        $Product->price = $request->price;
        $Product->qty = $request->qty;
        $Product->article_number = $request->article_number;
        $Product->catalog_id = $request->catalog_id;
        $Product->shipping = $request->delivery;
        $Product->status = $status;
        $Product->order = $order;
        $Product->url = $url;
        $Product->images = json_encode($images);
        $Product->websiteimages = $request->websiteimages;
        $Product->save();

        return redirect('admin/products')->with("success", "Product updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function addToCart(Request $request){

        //validate $request
        $request->validate([
            "product_id"=>"required|numeric",
            "quantity"=>"required|numeric"
        ]);

        $cart = Carts::where('product_id', $request->product_id)
            ->where('user_id', session("LoggedUser"))->get();
        
        if(count($cart) == 0){
             $affected = Carts::insert([
                "user_id" => session("LoggedUser"),
                "product_id" => $request->product_id,
                "cart_quantity" => $request->quantity
            ]);
        }
        else {

            foreach ($cart as $object){
                $qty = $object->cart_quantity + $request->quantity;
            }
            
            $affected = Carts::where('product_id', $request->product_id)
                ->where('user_id', session("LoggedUser"))
                ->update(["cart_quantity" => $qty
            ]);
        }

        return redirect("/cart");
    }

    public function importProduct() 
    {
        $Catalogs = Catalog::where("sub_menu", 1)->orderby("name", "ASC")->get();
        $Brands = Brand::orderby("name", "ASC")->get();
        $Deliveries = Shipping::orderby("shop_name", "ASC")->get();
        return view("admin.import", compact("Catalogs", "Brands", "Deliveries"));
    }

    public function import(Request $request) 
    {
        Excel::import(new ProductsImport, request()->file('importProducts'));
        
        return redirect('admin/importproduct')->with("success", "Update success!");
    }
}
