@extends('admin.app')

@section("title", "Modify product")

@section("content")

<div class="col-4 card mx-auto mt-3">

    <h4>Modify product</h4>
                
    <form action="{{ route('admin.productUpdate') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $ProductData->product_id }}">
        <div class="card bg-secondary">
            <h3 class="card-header">Main datas</h3>
            <div class="card-body">
                <div class="form-group">
                    <label for="brand">Brand</label>
                    <select name="brand" id="" class="custom-select">
                        <option value="">Choose a brand!</option>
                        @foreach($Brands as $Brand)
                            <option value="{{ $Brand->name }}"
                            @if($Brand->name == $ProductData->brand)
                                selected
                            @endif
                            >{{ $Brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="" placeholder="Name" value="{{ $ProductData->name }}">
                    <span class="text-danger">@error('name'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="article_number">Article number</label>
                    <input type="text" class="form-control" name="article_number" id="" placeholder="Article number" value="{{ $ProductData->article_number }}">
                    <span class="text-danger">@error('type'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="ean">Ean</label>
                    <input type="text" class="form-control" name="ean" id="" placeholder="Ean" value="{{ $ProductData->ean }}">
                    <span class="text-danger">@error('ean'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="order">Order</label>
                    <input type="text" class="form-control" name="order" id="" placeholder="Order" value="{{ $ProductData->order }}">
                    <span class="text-danger">@error('order'){{ $message }} @enderror</span>
                </div>
            </div>
        </div>
        <div class="card bg-secondary">
            <h3 class="card-header">Category and visibility</h3>
            <div class="card-body">
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="catalog_id" id="" class="custom-select">
                        <option value="0">Main category</option>
                        @foreach($Catalogs as $Catalog)
                            <option value="{{ $Catalog->name }}"
                            @if($Catalog->name == $ProductData->catalog_id)
                                selected
                            @endif
                            >{{ $Catalog->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">@error('catalog_id'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <input type="checkbox" class="form-control" name="status" id=""
                    @if($ProductData->status == 1)
                        checked
                    @endif
                    >
                </div>
            </div>
        </div>
        <div class="card bg-secondary">
            <h3 class="card-header">Delivery</h3>
            <div class="card-body">
                <select name="delivery" id="" class="custom-select">
                    <option value="">Choose a delivery!</option>
                    @foreach($Deliveries as $delivery)
                        <option value="{{ $delivery->id }}"
                        @if($delivery->id == $ProductData->shipping || $delivery->id == old('delivery'))
                            selected
                        @endif>{{ $delivery->shop_name }}</option>
                    @endforeach
                </select>
                <span class="text-danger">@error('delivery'){{ $message }} @enderror</span>
            </div>
        </div>
        <div class="card bg-secondary">
            <h3 class="card-header">Garantie</h3>
            <div class="card-body">
            </div>
        </div>
        <div class="card bg-secondary">
            <h3 class="card-header">Prices, taxes, quantity</h3>
            <div class="card-body">
                <div class="form-group">
                    <label for="price">Tax</label>
                    <input type="text" class="form-control" name="tax" id="" placeholder="Tax" value="{{ old('tax') }}">
                    <span class="text-danger">@error('type'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" name="price" id="" value="{{ $ProductData->price }}" placeholder="Net_price">
                    <span class="text-danger">@error('price'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="price">Qty</label>
                    <input type="text" class="form-control" name="qty" id="" placeholder="qty" value="{{ $ProductData->qty }}">
                    <span class="text-danger">@error('qty'){{ $message }} @enderror</span>
                </div>
            </div>
        </div>
        <div class="card bg-secondary">
            <h3 class="card-header">Descriptions</h3>
            <div class="card-body">
                <div class="form-group">
                    <label for="short_description">Short description</label>
                    <textarea name="short_description" id="" cols="30" rows="10" placeholder="Short description" class="form-control">{{ $ProductData->short_description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="" cols="30" rows="10" placeholder="Description" class="form-control">{{ $ProductData->description }}</textarea>
                </div>
                
            </div>
        </div>
        <?php 
            use Illuminate\Support\Facades\Storage;
            $directories = Storage::directories("public/storage");
        ?>
        @if($ProductData->images != null)
            <div class="card bg-secondary">
                <h3 class="card-header">Images</h3>
                <div class="justify-content">
                @foreach(json_decode($ProductData->images) as $index=>$image)
                    <img class="img-fluid img-thumbnail" src="@php echo Request::root().Storage::url($image);@endphp">
                    <input type="checkbox" name="deleteImages[{{ $index }}]" id="">
                @endforeach
            </div>
        @endif
        <div class="card bg-secondary">
                <h3 class="card-header">Images</h3>
                <div class="card-body">
                    <label for="websiteimages">Website images</label>
                    <textarea name="websiteimages" id="" cols="30" rows="10">@if($ProductData->websiteimages != null)["@foreach(json_decode($ProductData->websiteimages) as $index=>$image){{ $image }}@if (!$loop->last)","@else"@endif @endforeach]@endif</textarea>
                <div class="custom-file">
                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Chose a directory</label>
                    <select class="custom-select custom-select-lg mb-3" name="directory">
                        <option value="0">Chose a directory</option>
                        @for($i=0; $i<count($directories); $i++)
                            <option value="{{ $directories[$i] }}">{{ $directories[$i] }}</option>
                        @endfor
                    </select>
                </div>
                <input type="file" class="form-control" name="images[]" placeholder="Images" multiple>
                </div>
            </div>
        <input type="hidden" name="id" value="{{ $ProductData->id }}">
        <div class="form-group">
            <button class="btn btn-block btn-primary" type="submit">Update</button>
        </div>
    </form>
</div>

@endsection