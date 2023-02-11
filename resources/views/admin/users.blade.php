@extends('admin.app')

@section("title", "Users")

@section("content")

<div class="col-12">
    <h4>Users</h4><a href="/admin/brand/new" class="btn btn-warning">Create User</a>
    </div>
    @if(count($Users) != 0)
    <div class="col-8">
    <table class="table table-hover">
        <thead>
            <tr>
                <td>First name</td>
                <td>Last_name</td>
                <td>E-mail</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            @foreach($Users as $user)
            <tr class="table-dark">
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td><a href="/admin/user/{{ $user->id }}" class="btn btn-warning">More info</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $Users->onEachSide(5)->links() }}
    </div>
</div>
@else
    <div class="col-12 alert alert-info">There is no users!</div>
@endif

@endsection