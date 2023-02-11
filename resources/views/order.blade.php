@extends('welcome')

@section("title", $Title)

@section("content")

@include("include/profileSideMenu")


<div class="col-8">
    <div class="row">
        <div class="col-6">
            <div class="sum-cart-div-head">Szállítás</div>
                <div class="payment_type_card">
                    <div class="row justify-content-between">
                        <div class="bold">
                            {{ $Orders->delivery_mode }}
                        </div>
                        <div class="bold"><span class="payment_cost">{{ $Orders->delivery_cost }}</span> Ft</div>
                    </div>
                    <div>Cím:</div>
                    <div>{{ $Orders->delivery_first_name }} {{ $Orders->delivery_last_name }}</div>
                    <div>{{ $Orders->delivery_zip_code }} {{ $Orders->delivery_town }}</div>
                    <div>{{ $Orders->delivery_street }} {{ $Orders->delivery_street_type }}
                    {{ $Orders->delivery_number_floor }}</div>
                </div>
        </div>
        <div class="col-6">
            <div class="sum-cart-div-head">Fizetés</div>
                <div class="payment_type_card">
                    <div class="row justify-content-between">
                        <div class="bold">
                            {{ $Orders->payment_mode }}
                        </div>
                        <div class="bold"><span class="payment_cost">{{ $Orders->payment_cost }}</span> Ft</div>
                    </div>
                    <div>Cím:</div>
                    <div>{{ $Orders->invoice_first_name }} {{ $Orders->invoice_last_name }}</div>
                    <div>{{ $Orders->invoice_zip_code }} {{ $Orders->invoice_town }}</div>
                    <div>{{ $Orders->invoice_street }} {{ $Orders->invoice_street_type }} 
                    {{ $Orders->invoice_number_floor }}</div>
                </div>
        </div>

    <div class="col-12 cart-title">
        Termékek
    </div>
    <div class="col-12">
        <?php
            $sumPrice = 0;
            $prices = 0;
        ?>
        @foreach ($ProductData as $object)
            <div class="cart-div">
                <div class="col-6">
                    <div class="cart-name">{{ $object["product"] }}</div>
                </div>
                <div class="col-3">
                    <div class="bold">{{ $object["qty"] }}<span class="qty-qty">db</span></div>
                    <div>{{ $object["price"] }} Ft/db</div>
                    <?php
                        $prices = 0;
                        $prices = $object["qty"] * $object["price"];
                        $sumPrice += $prices;
                    ?>
                </div>
                <div class="col-3 cart-price-block">
                    <div class="cart-price bold">{{ $prices }} Ft</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="col-12 sum-cart-div">
    
        <?php
            $sumPrice += $Orders->delivery_cost;
            $sumPrice += $Orders->payment_cost;
        ?>

        <div class="sub-total">Végösszeg</div>

        <div class="sub-total-price"><span id="sub_total_price">{{ $sumPrice }}</span> Ft</div>
    </div>
    </div>
    
</div>

@endsection