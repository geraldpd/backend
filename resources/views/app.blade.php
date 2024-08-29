@extends('layouts.default')

@section('content')
    <h4>Laravel REST API with OAuth2 Authentication</h4>

    <div class="mt-6">
        <a href="{{ route('login') }}" class="underline">Login</a>
        <br>
        <a href="{{ route('register') }}" class="underline">Register</a>
    </div>

    <div class="mt-6">
        <a href="/docs" class="underline">Documentation</a>
    </div>
@endsection