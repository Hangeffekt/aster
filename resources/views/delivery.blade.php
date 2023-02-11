@extends('welcome')

@section("title", $Title)

@section("content")


<div class="col-9">
    @include("include/cart_check")
    @if(count($takeover) == 0)
        
        <div class="empty-cart alert-warning">Ehhez a termék(ek)hez nem tartoznak szállítási információk!</div>
        <div>Kérjük vegye föl velünk a kapcsolatot telefonon, emailben vagy Facebook-on!</div>
        
    @else
        <form action="{{ route('shop.finishDelivery') }}" method="post">
            @csrf
        <div class="cart-title">Kérlek válassz szállítási formát</div>
        @foreach ($takeover as $object)
            <div class="delivery_type_card">
                <div class="row justify-content-between">
                    <div class="bold"><input type="radio" name="delivery_type" id=""  value="{{ $object->shop_id }}"
                        @if($CartInfo != null && $CartInfo->takeover == $object->shop_id)
                            checked
                        @endif
                        > Személyes átvétel {{ $object->shop_name }} üzletünkben.
                        <div class="initial">Cím: {{ $object->postal_code }} {{ $object->town }}, {{ $object->address }}</div>
                    </div>
                    
                    <div class="bold"><span class="delivery_cost">0</span> Ft</div>
                </div>
            </div>
        @endforeach
        <div class="delivery_type_card" id="delivery_address_need">
            <div class="row justify-content-between">
                <div class="bold"><input type="radio" name="delivery_type" id=""  value="0"
                    @if($CartInfo != null && $CartInfo->delivery_id != null)
                        checked
                    @endif
                    > {{ $Delivery->shop_name }}
                    <div class="initial">{{ $Delivery->content }}</div>
                </div>
                <div class="bold"><span class="delivery_cost">{{ $Delivery->cost }}</span> Ft</div>
            </div>
            
        </div>
    @endif
    

    @if(count($ShippingAddress) != 0)
        <div class="cart-title">Szállítási cím kiválasztása <i class="fas fa-chevron-down"></i></div>
        @foreach($ShippingAddress as $object)
        <div class="delivery_address">
            <div class="row justify-content-between">
                <div class="bold">
                    <input type="radio" name="delivery_address" id="" value="{{ $object->id }}"
                    @if($object->active == 1 || ($CartInfo != null && $CartInfo->delivery_address == $object->id))
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
    ?>
    @foreach ($ProductData as $object)
    <?php
        $price = $object->price *  $object->cart_quantity;
        $sumPrice += $price
    ?>
    @endforeach
    <div class="sum-cart-div-head">Rendelés összegzése</div>
    <div class="sum-cart-flex">
        <div>Kosár értéke:</div>
        <div id="sum_cart_value">{{ $sumPrice }}</div>
    </div>
    <div class="sum-cart-flex">
        <div>Szállítás:</div>
        <div id="sum_delivery_cost">-</div>
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

@if(count($ShippingAddress) == 0)
    <div class="delivery_address col-12">  
        @include("forms/address")
    </div>
@endif
    

@endsection