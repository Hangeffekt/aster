@extends('admin.app')

@section("title", "Brands")

@section("content")
<div class="col-4 card mx-auto mt-3">
    <h3 class="card-header">New brand</h3>
    <div class="card-body">
    <form action="{{ route('admin.brandStore') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
            <label for="title">Name</label>
            <input type="text" class="form-control" name="name" id="" placeholder="Name" value="{{ old('title') }}">
            <span class="text-danger">@error('name'){{ $message }} @enderror</span>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <input type="checkbox" class="form-control" name="status" id="">
        </div>
        <div class="form-group">
            <label for="active">Garantie(mounth)</label>
            <input type="text" class="form-control" name="garantie" id="">
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile" name="mainImage">
            <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
        <div class="form-group">
            <button class="btn btn-block btn-primary" type="submit">Create</button>
        </div>
    </form>
    <a href="{{ URL::previous() }}" class="btn btn-outline-warning">Back</a>
</div>

@endsection