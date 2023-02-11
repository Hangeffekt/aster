@extends('admin.app')

@section("title", "Main datas")

@section("content")

<div class="col-12 card">
    <h3 class="card-header">Meta datas</h3>
    <div class="card-body">
    <form action="{{ route('admin.metatagUpdate') }}" method="post">
    @csrf
        <div class="form-group">
            <label for="analytics">Analytics</label>
            <input type="text" class="form-control" name="analytics" id="" value="{{ $data->analytics }}">
        </div>
        <div class="form-group">
            <label for="keywords">Keywords</label>
            <input type="text" class="form-control" name="keywords" id="" value="{{ $data->keywords }}">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" id="" value="{{ $data->description }}">
        </div>
        <input type="hidden" name="id" value="{{ $data->id }}">
        <div class="form-group">
            <button class="btn btn-block btn-primary" type="submit">Update</button>
        </div>
    </form>
    <a href="{{ URL::previous() }}" class="btn btn-outline-warning">Back</a>
</div>

@endsection