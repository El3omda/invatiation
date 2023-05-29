@extends('layout')

@section('title')
    {{ __('inc.n20') }}
@endsection

@section('content')
    <div class="container">

        <div style="width: 90%;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);text-align: center;">
            <img width="200px" src="{{ asset('assets/images/logo.png') }}" alt="logo">
            <h3 class="fw-bold mt-3">
                {{ __('home.h1') }}
            </h3>
        </div>

    </div>

    <footer class="text-center py-3 text-white fw-bold mt-5"
        style="position: absolute;bottom: 0;left: 0;right: 0;background: linear-gradient(90deg, rgba(250,44,99,1) 0%, rgba(251,167,15,1) 100%);">
        {{ __('inc.n4') }} {{ date('Y') }}
    </footer>
@endsection
