@extends('welcome')

@section("title", $Title)

@section("content")
<div class="col-12">
    @include("include/cart_check")
</div>

<div class="col-12 cart-title">Rendelés összegzése</div>
<div class="col-6">
    <div class="sum-cart-div-head">Szállítás</div>
    @if($deliveryInfo != null)
        <div class="payment_type_card">
            <div class="row justify-content-between">
                <div class="bold">
                    {{ $deliveryInfo->shop_name }}
                </div>
                <div class="bold"><span class="payment_cost">{{ $deliveryInfo->cost }}</span> Ft</div>
            </div>
            <div>Cím:</div>
            <div>{{ $DeliveryAddress->zip_code }} {{ $DeliveryAddress->town }}</div>
            <div>{{ $DeliveryAddress->street }} {{ $DeliveryAddress->street_type }} {{ $DeliveryAddress->number_floor }}</div>
        </div>
    @endif
    @if($deliveryShop != null)
        <div class="payment_type_card">
            <div class="row justify-content-between">
                <div class="bold">
                    {{ $deliveryShop->shop_name }}
                </div>
                <div class="bold"><span class="payment_cost">{{ $deliveryShop->cost }}</span> Ft</div>
            </div>
            <div>Cím:</div>
            <div>{{ $deliveryShop->postal_code }} {{ $deliveryShop->town }}</div>
            <div>{{ $deliveryShop->address }}</div>
        </div>
    @endif
</div>
<div class="col-6">
    <div class="sum-cart-div-head">Fizetés</div>
        <div class="payment_type_card">
            <div class="row justify-content-between">
                <div class="bold">
                    {{ $Payment->name }}
                </div>
                <div class="bold"><span class="payment_cost">{{ $Payment->cost }}</span> Ft</div>
            </div>
            <div>Cím:</div>
            <div>{{ $InvoiceAddress->zip_code }} {{ $InvoiceAddress->town }}</div>
            <div>{{ $InvoiceAddress->street }} {{ $InvoiceAddress->street_type }} {{ $InvoiceAddress->number_floor }}</div>
        </div>
</div>

<div class="col-12 cart-title">
    Termékek
</div>
<div class="col-12">
    <?php
        $sumPrice = 0;
    ?>
    @foreach ($ProductData as $object)
        <div class="cart-div">
            <div class="col-6">
                <div class="cart-name"><a href="/product/{{ $object->url }}">{{ $object->name }}</a></div>
            </div>
            <div class="col-3">
                <div class="bold">{{ $object->cart_quantity }}<span class="qty-qty">db</span></div>
                <div>{{ $object->price }} Ft/db</div>
                <?php
                    $price = $object->price *  $object->cart_quantity;
                    $sumPrice += $price
                ?>
            </div>
            <div class="col-3 cart-price-block">
                <div class="cart-price bold">{{ $price }} Ft</div>
            </div>
        </div>
    @endforeach
</div>

    @csrf
<div class="col-12 sum-cart-div">
    <?php
        $sumPrice = 0;
    ?>
    @foreach ($ProductData as $object)
    <?php
        $price = $object->price *  $object->cart_quantity;
        $sumPrice += $price;
    ?>
    @endforeach
    <?php
        if($deliveryInfo != null){
            $sumPrice += $deliveryInfo->cost;
        }
        if($deliveryShop != null){
            $sumPrice += $deliveryShop->cost;
        }
        
        $sumPrice += $Payment->cost;
    ?>
<form action="{{ route('shop.finishCheckout') }}" method="post">
    @csrf
<div class="col-5 comment-box">
    <div class="cart-title comment-title">Megjegyzés a rendeléshez<i class="fas fa-chevron-down"></i></div>
    <div class="form-group">
        <textarea name="comment" id="comment" class="form-control"></textarea>
    </div>
</div>

    <div class="sub-total">Végösszeg</div>

    <div class="sub-total-price"><span id="sub_total_price">{{ $sumPrice }}</span> Ft</div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="aszf" id="">Tudomásul veszem és elfogadom a(z) ÁSZF-t.
        <div class="text-danger">@error('aszf') A mező kitöltése kötelező! @enderror</div>
    </div>
    <button type="submit" class="btn-cart">Megrendelés</button>
    </form>
</div>

@endsection