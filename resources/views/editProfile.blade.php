@extends('welcome')

@section("title", "Brands")

@section("content")

@include("include/profileSideMenu")
<div class="col-md-9">
	<div class="row">
        <div class="col-6">
            <div class="col-12 profil-cim">Adatok módosítása</div>
            <form action="{{ route('user.editprofile') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">Vezetéknév*</label>
                    <input type="text" name="first_name" id="" class="form-control" 
                    @if(old('first_name') != null)
                        value="{{ old('first_name') }}"
                    @else
                        value="{{ $User->first_name }}"
                    @endif
                    >
                    <span class="text-danger">@error('first_name'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="">Keresztnév*</label>
                    <input type="text" name="last_name" id="" class="form-control"
                    @if(old('last_name') != null)
                        value="{{ old('last_name') }}"
                    @else
                        value="{{ $User->last_name }}"
                    @endif
                    >
                    <span class="text-danger">@error('last_name'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="">E-mail cím*</label>
                    <input type="text" name="email" id="" class="form-control"
                    @if(old('email') != null)
                        value="{{ old('email') }}"
                    @else
                        value="{{ $User->email }}"
                    @endif
                    >
                    <span class="text-danger">@error('email'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="">Telefonszám</label>
                    <input type="number" name="telephone" id="" class="form-control"
                    @if(old('telephone') != null)
                        value="{{ old('telephone') }}"
                    @else
                        value="{{ $User->telephone }}"
                    @endif
                    
                    >
                    <span class="text-danger">@error('telephone'){{ $message }} @enderror</span>
                </div>
                <button type="submit" class="btn-cart">Mentés</button>
            </form>
            <div class="field-note">* kitöltése kötelező</div>
        </div>
        <div class="col-6">
            <div class="col-12 profil-cim">Jelszó módosítása</div>
            <form action="{{ route('user.modifypassword') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">Régi jelszó*</label>
                    <input type="password" name="old_password" id="" class="form-control">
                    <span class="text-danger">@error('old_password'){{ $message }} @enderror</span>
                    @if(Session::get('password_error') != null)
                        <span class="text-danger">{{ Session::get('password_error') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="">Új jelszó*</label>
                    <input type="password" name="new_password" id="" class="form-control">
                    <span class="text-danger">@error('new_password'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label for="">Új jelszó megerősítése*</label>
                    <input type="password" name="new_password_repeat" id="" class="form-control">
                    <span class="text-danger">@error('new_password_repeat'){{ $message }} @enderror</span>
                </div>
                <button type="submit" class="btn-cart">Mentés</button>
            </form>
            <div class="field-note">* kitöltése kötelező</div>
        </div>
    </div>
</div>
@endsection