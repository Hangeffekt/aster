@extends('welcome')

@section("title", $Title)

@section("content")
@include("include/profileSideMenu")
<div class="col-md-9">

    <div class="tcontent thead">
        <div>Azonosító</div>
        <div>Rendelés dátuma</div>
        <div>Állapot</div>
        <div>Rendelés összege</div>
        <div></div>
    </div>
    
    @foreach($Orders as $object)
    <div class="tcontent">
        <div class="rend_id">{{ $object->id }}</div>
        <div><strong class="mobil-cim">Rendelés dátuma: </strong>{{ $object->created_at }}</div>
        <div><strong class="mobil-cim">Állapot: </strong>{{ $object->status }}</div>
        <?php
        
        $sum_price = $object->delivery_cost;
        $sum_price += $object->payment_cost;
        $prices = 0;

        
        foreach($Products as $product){
            if($product["order_id"] == $object->id){
                $prices = $product["qty"] * $product["price"];
                $sum_price += $prices;
            }
        }
        
        ?>
        <div><strong class="mobil-cim">Rendelés összege</strong>{{ $sum_price }}</div>
        <div><a href="/order/{{ $object->id }}">Részletek</a></div>
    </div>

    @endforeach
    {{ $Orders->onEachSide(5)->links() }}
</div>
@endsection