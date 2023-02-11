<div class="col-xxl-3 col-xl-3 col-md-4 leftmenu">
	<div class="leftmenu-szuro">Szűrő</div>
    <div class="filter">
        <label><strong>Rendezés</strong></label>
        <a href="/catalog/{{ $catalogName }}/price_up"><input type="checkbox" name="price_up" id=""
        @if( session('order') == 'price_up' )
            checked
        @endif
        >Ár szerint növekvő</a>
        <a href="/catalog/{{ $catalogName }}/price_down"><input type="checkbox" name="price_down" id=""
        @if( session("order") == "price_down" )
            checked
        @endif
        >Ár szerint csökkenő</a>
    </div>
    <div class="filter">
        <label><strong>Márka:</strong></label>
        @if($BrandList != null)
            @for($i = 0; $i < count($BrandList); $i++)
                <a 
                @if(session("brand") != null && in_array($BrandList[$i]["id"], session("brand")))
                    href="/catalog/{{ $catalogName }}/removebrand/{{ $BrandList[$i]["id"] }}"
                @else
                    href="/catalog/{{ $catalogName }}/brand/{{ $BrandList[$i]["id"] }}"
                @endif
                ><input type="checkbox" name="marka" value="{{ $BrandList[$i]["name"] }}"
                    @if(session("brand") != null && in_array($BrandList[$i]["id"], session("brand"))){
                        checked
                    }
                    @endif
                >{{ $BrandList[$i]["name"] }}</a>
            @endfor
        @endif
    </div>
    <div class="filter">
        @foreach(json_decode($Filters) as $FilterName=>$filtervalues)
            {{ $FilterName }}
            @foreach($filtervalues as $index=>$value)
                {{ $FilterName }}
            @endforeach
        @endforeach
    </div>
</div>