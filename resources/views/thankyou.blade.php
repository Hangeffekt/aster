@extends('welcome')

@section("title", $Title)

@section("content")

<div class="col-12">
    @include("include/cart_check")
</div>

Köszönjük a rendelést! =)


@endsection