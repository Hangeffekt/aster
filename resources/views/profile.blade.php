@extends('welcome')

@section("title", $Title)

@section("content")

@include("include/profileSideMenu")
<div class="col-md-9">
	<div class="row">
		<div class="col-md-6 col-sm-12">
			<p><strong>Szállítási cím</strong></p>
			@if($UserAddress == null)
				<div class="empty-cart">Nincs beállítva aktív szállítási cím!</div>
			@else
				<div class="card">
					<h5 class="card-header">{{ $UserAddress->first_name }} {{ $UserAddress->last_name }}</h5>
				
					<div class="card-body">
						<p>{{ $UserAddress->zip_code }} {{ $UserAddress->town }}</p>
						<p>{{ $UserAddress->street }} {{ $UserAddress->ps_name }} {{ $UserAddress->number_floor }}</p>
					</div>
				</div>
			@endif
		</div>
		<div class="col-md-6 col-sm-12">
			<p><strong>Számlázási cím</strong></p>
			@if($InvoiceAddress == null)
				<div class="empty-cart">Nincs beállítva aktív számlázási cím!</div>
			@else
				<div class="card">
					<h5 class="card-header">{{ $InvoiceAddress->first_name }} {{ $InvoiceAddress->last_name }}</h5>
				
					<div class="card-body">
						<p>{{ $InvoiceAddress->zip_code }} {{ $InvoiceAddress->town }}</p>
						<p>{{ $InvoiceAddress->street }} {{ $InvoiceAddress->ps_name }} {{ $InvoiceAddress->number_floor }}</p>
					</div>
				</div>
			@endif
		</div>
	</div>
	<div class="col-12 profil-cim">Korábbi rendelések</div>
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
</div>

@endsection