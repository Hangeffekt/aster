@extends('admin.app')

@section("title", "Brands")

@section("content")

<div class="col-12 card">
    <h3 class="card-header">{{ $data->name }}</h3>
    <div class="card-body">
    <form action="{{ route('admin.brandUpdate') }}" method="post" enctype="multipart/form-data">
    @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="" value="{{ $data->name }}">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <input type="checkbox" class="form-control" name="status" id="" 
            @if($data->status == 1)
                checked
            @endif
            >
        </div>
        <div class="form-group">
            <label for="garantie">Garantie(mounth)</label>
            <input type="text" class="form-control" name="garantie" id="" value="{{ $data->garantie }}">
        </div>
        <input type="hidden" name="id" value="{{ $data->id }}">
        @if($data->image != null)
            <img class="col-12 m-auto" src="@php echo Request::root().Storage::url($data->image);@endphp">
            @csrf
            <div class="form-group">
                <label for="">Delete</label>
                <input type="checkbox" class="form-control"  name="deleteImage" id="" value="true">
            </div>
        @else
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="mainImage">
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
        @endif
        <div class="form-group">
            <button class="btn btn-block btn-primary" type="submit">Update</button>
        </div>
    </form>
    <a href="{{ URL::previous() }}" class="btn btn-outline-warning">Back</a>
</div>

@endsection