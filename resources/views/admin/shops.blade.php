@extends('admin.app')

@section("title", "Shops")

@section("content")
    <div class="col-12">
            <h4>Shops</h4><a href="/admin/shops/create" class="btn btn-warning">New shop</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>Status</td>
                        <td>Town</td>
                        <td>Address</td>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Shops as $Shop)
                    <tr class="table-dark">
                        <td>{{ $Shop->shop_name }}</td>
                        <td>{{ $Shop->status }}</td>
                        <td>{{ $Shop->town }}</td>
                        <td>{{ $Shop->address }}</td>
                        <td><a href="{{ route('shops.edit', $Shop->shop_id) }}" class="btn btn-warning">Modify</a></td>
                        <td>
                            <form action="{{ route('shops.destroy', $Shop->shop_id) }}" method="post">
                                @csrf
                                @method ('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <div class="col-4">
            @if($ShopData == 'new')
            
            <a href="/shop" class="col-12 btn btn-outline-warning">Close</a>
            @elseif($ShopData != null)
            
            <a href="/shop" class="col-12 btn btn-outline-warning">Close</a>
            @endif
@endsection