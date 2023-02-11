@extends('admin.app')

@section("title", "Brands")

@section("content")

<div class="col-12">
    <h4>Brand</h4><a href="/admin/brand/create" class="btn btn-warning">New brand</a>
</div>
@if(count($data) != 0)
    <div class="col-8">
    <table class="table table-hover">
        <thead>
            <tr>
                <td>Name</td>
                <td>Status</td>
                <td></td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $BrandInfo)
            <tr class="table-dark">
                <td>{{ $BrandInfo->name }}</td>
                <td>
                    @if($BrandInfo->status == 1)
                        Yes
                    @else
                        No
                    @endif
                </td>
                <td><a href="/admin/brand/{{ $BrandInfo->id }}" class="btn btn-warning">Modify</a></td>
                <td>
                    <a href="/admin/brand/delete/{{ $BrandInfo->id }}" type="submit" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    </div>
@else
    <div class="col-12 alert alert-info">There is no brands!</div>
@endif

@endsection