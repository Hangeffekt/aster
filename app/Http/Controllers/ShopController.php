<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Nullable;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.shops', [
            'Shops' => Shop::paginate(50)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/createshop');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shop_name' => 'required',
            'postal_code' => 'required',
            'town' => 'required',
            'address' => 'required',
            'telephone' => 'required',
            'email' => 'required',
            'status' => 'nullable',
            'takeover' => 'nullable'
        ]);
        $shop = Shop::create($validated);
        
        return redirect("/admin/shops")->with("success", "Sikeres felvétel!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show( $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        $editShop = Shop::findOrFail($shop->shop_id);

        return view('admin.editShop', compact('editShop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shops  $shops
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        $validated = $request->validate([
            'shop_name' => 'required',
            'postal_code' => 'required',
            'town' => 'required',
            'address' => 'required',
            'telephone' => 'required',
            'email' => 'required',
            'status' => 'required_with:1,null',
            'takeover' => 'required_with:1,null'
        ]);

        Shop::where('shop_id', $shop->shop_id)->update($validated);
        
        return redirect("admin/shops")->with("success", "Sikeres frissítés!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        $deleteShop = Shop::findOrFail($shop->shop_id);
        $deleteShop->delete();
        
        return redirect("/admin/shops")->with("success", "Sikeres törlés!");
    }
}
