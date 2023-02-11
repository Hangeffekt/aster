@extends('admin.app')

@section("title", "Import")

@section("content")

<div class="col-4 card mx-auto mt-3">
    <h4>Import</h4>

    <form action="{{ route('admin.import') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" class="form-control" name="importProducts" placeholder="importProducts" multiple>
        <input type="submit" class="btn btn-success">
    </form>
</div>
<div class="col-12 mt-3">
    <div class="card bg-secondary">
        <h3 class="card-header">XLS helper</h3>
        <div class="col">
            <h5 class="card-header">Catalogs</h5>
                @foreach($Catalogs as $Catalog)
                <div>{{ $Catalog->name }}</div>
                @endforeach
        </div>
        <div class="col">
            <h5 class="card-header">Brands</h5>
                @foreach($Brands as $Brand)
                <div>{{ $Brand->name }}</div>
                @endforeach
        </div>
        <div class="col">
            <h5 class="card-header">Delivery(use the id)</h5>
                @foreach($Deliveries as $Delivery)
                <div>{{ $Delivery->shop_name }} => {{ $Delivery->id }} </div>
                @endforeach
        </div>
    </div>
</div>

@endsection