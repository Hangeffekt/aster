@extends('welcome')

@section("title", "Registration")

@section("content")
    <div class="col-md-12 col-md-offset-12">
        <form action="{{ route('auth.create') }}" method="post">
            @csrf

            @if(Session::get('fail'))
                <div class="alert alert-success">
                    {{ Session('fail') }}
                </div>
            @endif
            <div class="cart-title">Személyes adatok</div>
            <div class="form-group">
                <label for="name">Vezetéknév*</label>
                <input type="text" class="form-control" name="first_name" id="" placeholder="Vezetéknév" value="{{ old('first_name')}}">
                <span class="text-danger">@error('first_name'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="name">Keresztnév*</label>
                <input type="text" class="form-control" name="last_name" id="" placeholder="Keresztnév" value="{{ old('last_name')}}">
                <span class="text-danger">@error('last_name'){{ $message }} @enderror</span>
            </div>
            <div class="cart-title">Fiók adatok</div>
            <div class="form-group">
                <label for="email">E-mail cím*</label>
                <input type="text" class="form-control" name="email" id="" placeholder="E-mail cím" value="{{ old('email')}}">
                <span class="text-danger">@error('email'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="password">Jelszó*</label>
                <input type="password" class="form-control" name="password" id="" placeholder="Jelszó">
                <span class="text-danger">@error('password'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="password">Jelszó megerősítése*</label>
                <input type="password" class="form-control" name="password_replay" id="" placeholder="Jelszó megerősítése">
                <span class="text-danger">@error('password_replay'){{ $message }} @enderror</span>
            </div>
                <button class="btn-cart" type="submit">Regisztráció</button>
        </form>
        <div class="field-note">* kitöltése kötelező</div>

        <!-- Facebook login -->

        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/hu_HU/sdk.js#xfbml=1&version=v12.0&appId=176563988007004&autoLogAppEvents=1" nonce="JqlIasKn"></script>
        <div class="fb-login-button" data-width="" data-size="large" data-button-type="continue_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="false"></div>
    </div>
@endsection