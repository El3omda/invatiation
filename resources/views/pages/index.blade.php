@extends('layout')

@section('title')
    {{ __('inc.n0') }}
@endsection

@section('content')
    <div class="container mt-2">

        <div class="pt-4"></div>
        <div style="text-align: center;">
            <h3 class="fw-bold mt-5">
                {{ __('home.h1') }}
            </h3>

            <a href="/add/{{ App::getLocale() }}"
                style="background: linear-gradient(90deg, rgba(250,44,99,1) 0%, rgba(251,167,15,1) 100%);"
                class="btn fw-bold text-white p-3 mt-5 mb-3">{{ __('home.h2') }}</a>

        </div>
    </div>


    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8083085385088514"
        crossorigin="anonymous"></script>
    <!-- al -->
    <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-8083085385088514" data-ad-slot="2819449587"
        data-ad-format="auto" data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9VKCZN8NY9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-9VKCZN8NY9');
    </script>


    <div class="text-center py-3 text-white fw-bold mt-5"
        style="background: linear-gradient(90deg, rgba(250,44,99,1) 0%, rgba(251,167,15,1) 100%);">
        {{ __('inc.n4') }} {{ date('Y') }}
    </div>
    </div>
@endsection
