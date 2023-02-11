@extends('admin.app')

@section("title", "Catalogs")

@section("content")
    <div class="col-12">
    <h4>Catalog</h4><a href="/admin/catalogs/create" class="btn btn-warning">New catalog</a>
    </div>
    @if(count($Catalogs) != 0)
    <div class="col-12">
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
            @foreach($Catalogs as $Catalog)
            <tr class="table-dark">
                <td>{{ $Catalog->name }}</td>
                <td>{{ $Catalog->status }}</td>
                <td><a href="{{ route('catalogs.edit', $Catalog->id) }}" class="btn btn-warning">Modify</a></td>
                <td>
                <form action="{{ route('catalogs.destroy', $Catalog->id) }}" method="post">
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
    @else
        <div class="col-12 alert alert-info">There is no catalogs!</div>
    @endif
@endsection