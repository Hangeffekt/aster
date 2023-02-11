@extends('admin.app')

@section("content")
<div class="col-4 m-auto">
<form action="{{ route('shops.update', $editShop->shop_id) }}" method="post">
            @csrf
            @method('PATCH')
            <div class="form-group">
                    <label for="title">Name</label>
                    <input type="text" class="form-control" name="shop_name" id="" placeholder="Name" value="{{ $editShop->shop_name }}">
                    <span class="text-danger">@error('shop_name'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="active">Active</label>
                    <input type="checkbox" class="form-control" name="status" id="" value="1" 
                    @if($editShop->status == 1)
                        checked
                    @endif
                    >
                    <span class="text-danger">@error('status'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="postal_code">Postal code</label>
                    <input type="text" class="form-control" name="postal_code" id="" placeholder="Postal code" value="{{ $editShop->postal_code }}">
                    <span class="text-danger">@error('postal_code'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="town">Town</label>
                    <input type="text" class="form-control" name="town" id="" placeholder="Town" value="{{ $editShop->town }}">
                    <span class="text-danger">@error('town'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="address" id="" placeholder="Address" value="{{ $editShop->address }}">
                    <span class="text-danger">@error('address'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="telephone">Telephone</label>
                    <input type="text" class="form-control" name="telephone" id="" placeholder="Telephone" value="{{ $editShop->telephone }}">
                    <span class="text-danger">@error('telephone'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" class="form-control" name="email" id="" placeholder="E-mail" value="{{ $editShop->email }}">
                    <span class="text-danger">@error('email'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="open">Open</label>
                    <input type="text" class="form-control" name="open" id="" placeholder="Open" value="{{ $editShop->open }}">
                    <span class="text-danger">@error('open'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="Open">Takeover</label>
                    <input type="checkbox" class="form-control" name="takeover" id="" value="1" placeholder="Takeover"
                    @if($editShop->takeover == 1)
                        checked
                    @endif
                    >
                    <span class="text-danger">@error('takeover'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="submit">Update</button>
                </div>
            </form>
        </div>
        @endsection