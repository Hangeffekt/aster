@extends('welcome')

@section("title", $title)

@section("content")

@include("include/filter")


<div class="col-xxl-9 col-xl-9 col-md-8">
    <div class="row">
    @if(count($ProductData) > 0)
        @foreach($ProductData as $Product)
            
        
        <div class="termek col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12">
            <div class="kep_leiras">
                @if($Product->websiteimages != null)
                    <img class="col-3 m-auto" src="{{ head(json_decode($Product->websiteimages)) }}" alt="{{ $Product->name }}">
                @elseif($Product->images != null)
                    <img class="col-3 m-auto" src="{{ Storage::url(head(json_decode($Product->images))) }}" alt="{{ $Product->name }}">
                @endif
            </div>	
        
            <a class="termek" href="/product/{{ $Product->url }}" alt="{{ $Product->name }} további információk">
                <div class="nev">{{ $Product->name }} {{ Illuminate\Support\Str::limit($Product->short_description, 50, ' (...)') }}</div>
            </a>
            <div class="ar">{{ $Product->price }} Ft</div>
            <form method="post" action="{{ route('shop.addToCart') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $Product->id }}">
                <input type="hidden" name="quantity" value="1">
                <input type="submit" value="Kosárba" name="kosar" class="btn-cart" alt="kosárba">
            </form>
        </div>
        @endforeach
    @else
        <div class="alert alert-info">Nincs termék a kategóriában!</div>
    @endif
    </div>
</div>
<div class="col-12">
    {{ $ProductData->onEachSide(15)->links() }}
</div>   

@endsection