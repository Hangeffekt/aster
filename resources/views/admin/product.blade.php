@extends('admin.app')

@section("title", "Brands")

@section("content")
    <div class="col-12">
        <h4>Products</h4>
        <a href="/admin/product/create" class="btn btn-warning">New product</a>
    </div>
    
    @if($data != "" || $data != null)
        <div class="col-12">
        <table class="table table-hover">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Active</td>
                    <td>Order</td>
                    <td>Price</td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $ProductInfo)
                <tr class="table-dark">
                    <td>{{ $ProductInfo->name }}</td>
                    <td>{{ $ProductInfo->status }}</td>
                    <td>{{ $ProductInfo->order }}</td>
                    <td>{{ $ProductInfo->price }}</td>
                    <td>
                        <a href="/admin/product/{{ $ProductInfo->id }}" class="btn btn-warning">Modify</a>
                    </td>
                    <td>
                    <form action="{{ route('admin.productDelete') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $ProductInfo->id }}">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $data->onEachSide(5)->links() }}
    </div>
    @else
        <div class="col-12 alert alert-info">There is no products!</div>
    @endif
    
@endsection