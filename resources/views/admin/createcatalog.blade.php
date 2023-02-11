@extends('admin.app')

@section("title", "Brands")

@section("content")
<div class="col-4 card mx-auto mt-3">
    <h3 class="card-header">New catalog</h3>
    <div class="card-body">
    <form action="{{ route('catalogs.store') }}" method="post">
    @csrf
    <div class="form-group">
            <label for="title">Name</label>
            <input type="text" class="form-control" name="name" id="" placeholder="Name" value="{{ old('title') }}">
            <span class="text-danger">@error('name'){{ $message }} @enderror</span>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <input type="checkbox" class="form-control" name="status" id="" value="1">
        </div>
        <div class="form-group">
            <label for="order">Order</label>
            <input type="number" class="form-control" name="order" id="" value="{{ old('order') }}">
        </div>
        <div class="form-group">
            <label for="parent_category">Parant category</label>
            <select name="parent_id" id="" class="custom-select">
                <option value="0">Main category</option>
                @foreach($Catalogs as $Catalog)
                    <option value="{{ $Catalog->id }}">{{ $Catalog->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="status">Sub menu</label>
            <input type="checkbox" class="form-control" name="sub_menu" id="" value="1">
            <span class="text-danger">@error('sub_menu'){{ $message }} @enderror</span>
        </div>
        <div class="form-group">
            <button class="btn btn-block btn-primary" type="submit">Create</button>
        </div>
    </form>
</div>
@endsection