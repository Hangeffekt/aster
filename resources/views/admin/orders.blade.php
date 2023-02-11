@extends('admin.app')

@section("title", "Orders")

@section("content")
    <div class="col-12">
        <h4>Orders</h4>
        <a href="/admin/orders/create" class="btn btn-warning">New order</a>
    </div>
    
    @if($Orders != "" || $Orders != null)
        <div class="col-12">
        <table class="table table-hover">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>status</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach($Orders as $Order)
                <tr class="table-dark">
                    <td>{{ $Order->id }}</td>
                    <td>{{ $Order->status }}</td>
                    <td>
                        <a href="/admin/orders/{{ $Order->id }}/edit" class="btn btn-warning">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $Orders->onEachSide(50)->links() }}
    </div>
    @else
        <div class="col-12 alert alert-info">There is no products!</div>
    @endif
    
@endsection