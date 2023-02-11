@extends('welcome')

@section("title", "Login")

@section("content")
<div class="col-md-6 col-md-offset-6">
    <div class="cart-title">Regisztrált vásárlók</div>
    <div class="field note">Ha már van felhasználói fiókja, jelentkezzen be e-mail címével.</div>
    <hr>
    <form action="{{ route('auth.check')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="email">E-mail cím*</label>
            <input type="text" class="form-control" name="email" id="" placeholder="Email" value="{{ old('email')}}">
            <span class="text-danger">@error('email'){{ $message }} @enderror</span>
        </div>
        <div class="form-group">
            <label for="password">Jelszó*</label>
            <input type="password" class="form-control" name="password" id="" placeholder="Password">
            <span class="text-danger">@error('password'){{ $message }} @enderror</span>
        </div>
        <button class="btn-cart" type="submit">Bejelentkezés</button>
    </form>
    <div class="field-note">* kitöltése kötelező</div>
</div>
<div class="col-md-6 col-md-offset-6">
    <div class="cart-title">Regisztrált vásárlók</div>
    <div class="field note">Új fiók létrehozásának számos előnye van: gyorsabb vásárlás, akár több cím mentése, megrendeléseit nyomon követheti.</div>
    <hr>
    <a class="btn-cart" href="/register">Regisztráció</a>
</div>
@endsection