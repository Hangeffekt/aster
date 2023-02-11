@extends('welcome')

@section("title", $Title)

@section("content")

<div class="container">
    <div class="row">

        <div class="col-9 ">
            @include("include/cart_check")
            <?php
            $sumPrice = 0;
            ?>
            
            @if(count($ProductData) == 0)
                <div class="empty-cart">A kosarad üres!</div>
                <a class="btn-empty" href="/">Vissza a főoldalra</a>
            @else
                <div class="cart-title">Kosár</div>
                @foreach ($ProductData as $object)
                    <div class="cart-div">
                        <div class="col-6">
                            <div class="cart-name"><a href="/product/{{ $object->url }}">{{ $object->name }}</a></div>
                        </div>
                        <div class="col-3">
                            <form action="{{ route('shop.refreshCart') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="number" class="form-control" name="quantity" value="{{ $object->cart_quantity }}"> <span class="qty-qty">db</span>
                                </div>
                                <input type="hidden" name="product_id" value="{{ $object->cart_id }}">
                                <button type="submit" class="btn btn-success">Frissít</button>
                            </form>
                            <?php
                                $price = $object->price *  $object->cart_quantity;
                                $sumPrice += $price
                            ?>
                        </div>
                        <div class="col-3 cart-price-block">
                            <div class="cart-price">{{ $price }} Ft</div>
                            <div class="cart-buttons">
                                <form action="{{ route('shop.deleteCart') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $object->cart_id }}">
                                    <button type="submit" class="btn">Törlés</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="col-3 sum-cart-div">
            <div class="sum-cart-div-head">Rendelés összegzése</div>
            <div class="sum-cart-flex">
                <div>Összesen:</div>
                <div>{{ $sumPrice }}</div>
            </div>
            <hr>
            <div class="sub-total">Végösszeg</div>
            <?php
                /*$sumPrice += szállítás;*/
            ?>
            <div class="sub-total-price">{{ $sumPrice }} Ft</div>
            <a class="btn-cart" href="/delivery">Folytatás</a>
        </div>
        
    </div>
</div>   
@endsection