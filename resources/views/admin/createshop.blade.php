@extends('admin.app')

@section("content")
<div class="col-12">
    <form action="{{ route('shops.store') }}" method="post">
        @csrf
        <div class="form-group">
                <label for="title">Name</label>
                <input type="text" class="form-control" name="shop_name" id="" placeholder="Name" value="{{ old('title') }}">
                <span class="text-danger">@error('name'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="active">Status</label>
                <input type="checkbox" class="form-check" name="status" id="">
            </div>
            <div class="form-group">
                <label for="postal_code">Postal code</label>
                <input type="number" class="form-control" name="postal_code" id="" placeholder="Postal code" value="{{ old('postal_code') }}">
                <span class="text-danger">@error('postal_code'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="town">Town</label>
                <input type="text" class="form-control" name="town" id="" placeholder="Town" value="{{ old('town') }}">
                <span class="text-danger">@error('town'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address" id="" placeholder="Address" value="{{ old('address') }}">
                <span class="text-danger">@error('address'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="telephone">Telephone</label>
                <input type="text" class="form-control" name="telephone" id="" placeholder="Telephone" value="{{ old('telephone') }}">
                <span class="text-danger">@error('telephone'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" name="email" id="" placeholder="E-mail" value="{{ old('email') }}">
                <span class="text-danger">@error('email'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="Open">Open</label>
                <input type="text" class="form-control" name="open" id="" placeholder="Open" value="{{ old('open') }}">
                <span class="text-danger">@error('open'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="Open">Takeover</label>
                <input type="checkbox" class="form-check" name="takeover" id="" placeholder="Takeover">
                <span class="text-danger">@error('open'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <button class="btn btn-block btn-primary" type="submit">Create</button>
            </div>
        </form>
    </div>
@endsection