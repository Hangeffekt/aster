@extends('admin.app')

@section("title", "New product")

@section("content")
    <div class="col-4 card mx-auto mt-3">
        <h4>New product</h4>
        
        <form action="{{ route('admin.productCreate') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card bg-secondary">
                <h3 class="card-header">Main datas</h3>
                <div class="card-body">
                <div class="form-group">
                        <label for="brand">Brand</label>
                        <select name="brand" id="" class="custom-select">
                            <option value="">Choose a brand!</option>
                            @foreach($Brands as $Brand)
                                <option value="{{ $Brand->name }}">{{ $Brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="" placeholder="Name" value="{{ old('name') }}">
                        <span class="text-danger">@error('name'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="article_number">Article number</label>
                        <input type="text" class="form-control" name="article_number" id="" placeholder="Article number" value="{{ old('type') }}">
                        <span class="text-danger">@error('type'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="ean">Ean</label>
                        <input type="text" class="form-control" name="ean" id="" placeholder="Ean" value="{{ old('ean') }}">
                        <span class="text-danger">@error('ean'){{ $message }} @enderror</span>
                    </div>
                </div>
            </div>
            <div class="card bg-secondary">
                <h3 class="card-header">Catalog and visibility</h3>
                <div class="card-body">
                    <div class="form-group">
                        <label for="category_id">Catalog</label>
                        <select name="catalog_id" id="" class="custom-select">
                            <option value="0">Main category</option>
                            @foreach($Catalogs as $Catalog)
                                <option value="{{ $Catalog->name }}">{{ $Catalog->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <input type="checkbox" class="form-control" name="status" id="">
                    </div>
                    <div class="form-group">
                        <label for="order">Order</label>
                        <input type="text" class="form-control" name="order" id="" placeholder="Order" value="{{ old('order') }}">
                        <span class="text-danger">@error('order'){{ $message }} @enderror</span>
                    </div>
                </div>
            </div>
            <div class="card bg-secondary">
                <h3 class="card-header">Delivery</h3>
                <select name="delivery" id="" class="custom-select">
                    <option value="">Choose a delivery!</option>
                    @foreach($deliveries as $delivery)
                        <option value="{{ $delivery->id }}"
                        @if($delivery->id == old('delivery'))
                                selected
                        @endif>{{ $delivery->shop_name }}</option>
                    @endforeach
                </select>
                <span class="text-danger">@error('delivery'){{ $message }} @enderror</span>
                <div class="card-body">
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
                        <input type="text" class="form-control" name="price" id="" placeholder="Price" value="{{ old('price') }}">
                        <span class="text-danger">@error('price'){{ $message }} @enderror</span>
                    </div>
                    <div class="form-group">
                        <label for="price">Qty</label>
                        <input type="text" class="form-control" name="qty" id="" placeholder="qty" value="{{ old('qty') }}">
                        <span class="text-danger">@error('qty'){{ $message }} @enderror</span>
                    </div>
                </div>
            </div>
            <div class="card bg-secondary">
                <h3 class="card-header">Descriptions</h3>
                <div class="card-body">
                    <div class="form-group">
                        <label for="short_description">Short description</label>
                        <textarea name="short_description" id="" cols="30" rows="10" placeholder="Short description" class="form-control">{{ old('short_description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="" cols="30" rows="10" placeholder="Description" class="form-control">{{ old('description') }}</textarea>
                    </div>
                    
                </div>
            </div>
            <div class="card bg-secondary">
                <h3 class="card-header">Images</h3>
                <?php 
                    use Illuminate\Support\Facades\Storage;
                    $directories = Storage::directories("public/storage");
                ?>
                <div class="card-body">
                    <label for="description">Website images</label>
                    <textarea name="websiteimages" id="" cols="30" rows="10"></textarea>
                <div class="custom-file">
                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Chose a directory</label>
                    @if($directories != null)
                        <select class="custom-select custom-select-lg mb-3" name="directory">
                            <option value="0">Chose a directory</option>
                            @for($i=0; $i<count($directories); $i++)
                                <option value="{{ $directories[$i] }}">{{ $directories[$i] }}</option>
                            @endfor
                        </select>
                    @endif
                </div>
                <input required type="file" class="form-control" name="images[]" placeholder="Images" multiple>
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-block btn-primary" type="submit">Create</button>
            </div>
        </form>
    </div>
@endsection