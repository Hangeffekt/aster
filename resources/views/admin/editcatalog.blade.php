@extends('admin.app')

@section("title", "Edit catalog")

@section("content")
<div class="col-4 card mx-auto mt-3">
    <h3 class="card-header">{{ $editCatalog->name }}</h3>
    <div class="card-body">
    <form action="{{ route('catalogs.update', $editCatalog->id) }}" method="post">
    @csrf
    @method("PATCH")
    <div class="form-group">
            <label for="title">Name</label>
            <input type="text" class="form-control" name="name" id="" placeholder="Name" value="{{ $editCatalog->name }}">
            <span class="text-danger">@error('name'){{ $message }} @enderror</span>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <input type="checkbox" class="form-control" name="status" id="" value="1"
            @if($editCatalog->status == 1)
                checked
            @endif
            >
            <span class="text-danger">@error('status'){{ $message }} @enderror</span>
        </div>
        <div class="form-group">
            <label for="order">Order</label>
            <input type="number" class="form-control" name="order" id="" value="{{ $editCatalog->order }}">
            <span class="text-danger">@error('order'){{ $message }} @enderror</span>
        </div>
        <div class="form-group">
            <label for="parent_category">Parant category</label>
            <select name="parent_id" id="" class="custom-select">
                <option value="0">Main category</option>
                @foreach($Catalogs as $Catalog)
                    <option value="{{ $Catalog->id }}"
                    @if($Catalog->id == $editCatalog->parent_id)
                        selected
                    @endif
                    >{{ $Catalog->name }}</option>
                @endforeach
            </select>
            <span class="text-danger">@error('parent_id'){{ $message }} @enderror</span>
        </div>
        <div class="form-group">
            <label for="status">Sub menu</label>
            <input type="checkbox" class="form-control" name="sub_menu" id="" value="1"
            @if($editCatalog->sub_menu == 1)
                checked
            @endif
            >
            <span class="text-danger">@error('sub_menu'){{ $message }} @enderror</span>
        </div>
        <div class="form-group">
            <button class="btn btn-block btn-primary" type="submit">Update</button>
        </div>
    </form>
</div>
@endsection