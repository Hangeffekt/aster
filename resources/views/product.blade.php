@extends('welcome')

@section("title", $Title)

@section("content")
    <div class="col-md-8 col-sm-12 js-img product_img">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
			<div class="carousel-inner">
				@if($ProductData->websiteimages != null)
					@foreach(json_decode($ProductData->websiteimages) as $index=>$image)
						<div class="carousel-item carousel-img @if ($loop->first) active @endif">
							<img class="d-block w-100" src="{{ $image }}" alt="{{ $ProductData->name }} {{ $index }}" data-bs-toggle="modal" data-bs-target="#Modal">
						</div>
					@endforeach
				@elseif($ProductData->images != null)
					@foreach(json_decode($ProductData->images) as $index=>$image)
						<div class="carousel-item carousel-img @if ($loop->first) active @endif">
							<img class="d-block w-100" src="{{ Storage::url($image) }}" alt="{{ $ProductData->name }} {{ $index }}" data-bs-toggle="modal" data-bs-target="#Modal">
						</div>
					@endforeach
				@endif
			</div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
				<span class="fas fa-chevron-left" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
				<span class="fas fa-chevron-right" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			</button>
        </div>

		<div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body m-auto align-middle">
					<div id="myModal" class="img-modal">
						<img class="img-modal-content" id="img01">
						<div id="caption"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-sm-12 product-center">
		<p class="nev2"><strong>{{ $ProductData->name }}</strong></p>
		<div class="product-ar">{{ $ProductData->price }} Ft</div>
		<div class="ar-allapot">
			<div class="allapot-ok">Raktáron 
				<i class="fas fa-check"></i>
			</div> 
		</div>
		<form method="post" action="{{ route('shop.addToCart') }}">
			@csrf
			<input type="hidden" name="product_id" value="{{ $ProductData->id }}">
			<div class="termek-lista">
				<input type="hidden" name="quantity" value="1" class="col-3">
				<input type="submit" value="Kosárba" name="cart" class="col-8 btn-cart">
			</div>
			
		</form>
		<div class="phone-order">Rendeljen telefonon</div>
		<p>Hívja ügyfélszolgálatunkat munkanapokon 8:30 és 16:00 között: 
			<a href="tel:06-37-310-116">06-37/310-116</a>
		</p>
		<div class="garancia">
			<div class="phone-order">Garancia</div>
			<div class="gar-content">
				<div class="gar-text">Hivatalos magyar garancia:</div>
				<div class="allapot-ok">{{$BrandList->garantie}} hónap <i class="fas fa-check"></i></div>
			</div>
		</div>
		<div class="szallitas">
			<div class="phone-order">Szállítás</div>
			<div class="szallitas-list">
				@if($Shippings != null)
					<div>Szállítási díj: 
						@foreach($Shippings as $shipping)
							@if($shipping->id == $ProductData->shipping)
								{{ $shipping->cost }}
							@endif
						@endforeach
					Ft</div>
				@endif
				<div>Személyes átvétel: Ingyen</div>
				<div class="varos">Gyöngyösön</div>
				<div class="varos">Jászárokszálláson</div>
			</div>
		</div>
	</div>
	<div class="col-12 info" id="info-bar">
		<a class="" href="#leiras">Leírás</a>
		
	</div>

	<div id="leiras" class="col-12">
		{{ $ProductData->description }}
	</div>

@endsection