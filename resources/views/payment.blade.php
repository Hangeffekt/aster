@extends('welcome')

@section("title", $Title)

@section("content")

<div class="col-9">
    @include("include/cart_check")
    
    @if(count($paymantMethods) == 0)
        
        <div class="empty-cart alert-warning">Ehhez a termék(ek)hez nem tartoznak számlázási információk!</div>
        <div>Kérjük vegye föl velünk a kapcsolatot telefonon, emailben vagy Facebook-on!</div>
        
    @else
        <form action="{{ route('shop.finishPayment') }}" method="post">
            @csrf
        <div class="cart-title">Kérlek válassz fizetési módot</div>
        @foreach ($paymantMethods as $object)
            <div class="payment_type_card">
                <div class="row justify-content-between">
                    <div class="bold"><input type="radio" name="payment_type" id=""  value="{{ $object->id }}"
                    @if($CartInfo->payment_id == $object->id)
                        checked
                    @endif
                    >{{ $object->name }}
                    </div>
                    <div class="bold"><span class="payment_cost">{{ $object->cost }}</span> Ft</div>
                </div>
            </div>
        @endforeach
    @endif
    
    @if(count($InvoiceAddress) != 0)
        <div class="cart-title">Számlázási cím kiválasztása</div>
        @foreach($InvoiceAddress as $object)
        <div class="invoice_address">
            <div class="row justify-content-between">
                <div class="bold">
                    <input type="radio" name="payment_address" id="" value="{{ $object->id }}"
                    @if($object->active == 1 || ($CartInfo->invoice_address == $object->id))
                        checked
                    @endif
                    > {{ $object->zip_code }} {{ $object->town }}, {{ $object->street }} {{ $object->street_type }} {{ $object->number_floor }}
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

<div class="col-3 sum-cart-div">
    <?php
        $sumPrice = 0;
        $cart_value = 0;
    ?>
    @foreach ($ProductData as $object)
    <?php
        $price = $object->price *  $object->cart_quantity;
        $sumPrice += $price;
        $cart_value += $price;
    ?>
    @endforeach
    <?php
        $sumPrice += $deliveryInfo->cost;
    ?>
    <div class="sum-cart-div-head">Rendelés összegzése</div>
    <div class="sum-cart-flex">
        <div>Kosár értéke:</div>
        <div id="sum_cart_value">{{ $cart_value }}</div>
    </div>
    <div class="sum-cart-flex">
        <div>Szállítás:</div>
        <div id="sum_delivery_cost">{{$deliveryInfo->cost}}</div>
    </div>
    <div class="sum-cart-flex">
        <div>Fizetés:</div>
        <div id="sum_payment_cost">-</div>
    </div>
    <hr>
    <div class="sub-total">Végösszeg</div>
    <?php
        /*$sumPrice += szállítás;*/
    ?>
    <div class="sub-total-price"><span id="sub_total_price">{{ $sumPrice }}</span> Ft</div>
    <button type="submit" class="btn-cart">Folytatás</button>
    </form>
</div>

@if(count($InvoiceAddress) == 0)
<div class="col-12">  
    @include("forms/invoice")
</div>
@endif
    

@endsection