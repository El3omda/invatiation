@extends('layout')

@section('title')
    {{ __('invite.n15') }}
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">

    <style>
        * {
            font-family: 'Cairo', Arial, Helvetica, sans-serif;
        }
    </style>
@endsection

@php

    $tz = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['REMOTE_ADDR']))['geoplugin_timezone'];
    // echo '<br>' . $tz . '<br>';
    if ($tz == null) {
        date_default_timezone_set('Asia/Riyadh');
    } else {
        date_default_timezone_set($tz);
    }

@endphp

@section('content')
    <div class="container mt-3">

        <form action="{{ route('invDelete', [App::getLocale(), $invite->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">
                <i class="fas fa-trash"></i>
            </button>
        </form>

        <h1 class="text-center fw-bold">
            {{ __('invite.n15') }}
        </h1>

        <form action="{{ route('invUpdate', [App::getLocale(), $invite->id]) }}" method="POST" style="direction: rtl"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mt-5">
                {{-- Photo --}}
                <div class=" col-md-12 mb-3">
                    <label for="formFile" class="form-label fw-bold">{{ __('invite.n2') }}</label>
                    <input class="form-control" type="file" name="photo" id="formFile">
                    @if (!empty($invite->photo))
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ $invite->photo }}" target="_blank"
                                    class="btn btn-link text-decoration-none text-primary fw-bold">{{ __('invite.n17') }}</a>
                            </div>
                            <div>
                                <a href="{{ route('destroyPhoto', [App::getLocale(), $invite->id]) }}"
                                    class="btn btn-link text-decoration-none text-danger fw-bold">{{ __('invite.n18') }}</a>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Owner --}}
                <div class="col">
                    <label for="owner" class="form-label fw-bold" style="">{{ __('invite.n3') }}</label>
                    <input type="text" id="owner" name="owner" class="form-control shadow-none py-2 fw-bold"
                        placeholder="" value="{{ $invite->owner }}" aria-label="Invite Owner">
                </div>

                {{-- Event --}}
                <div class="col">
                    <label for="event" class="form-label fw-bold" style="">{{ __('invite.n4') }}</label>
                    <input type="text" id="event" name="event" value="{{ $invite->event }}"
                        class="form-control shadow-none py-2 fw-bold" placeholder="" aria-label="{{ __('invite.n4') }}">
                </div>

                {{-- Date Type --}}
                <div class="col-12 mt-3">
                    <label for="inputAddress" class="form-label fw-bold" style="">{{ __('invite.n5') }}</label>
                    <div class="d-flex justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="dateT" value="Hijri" id="Hijri"
                                @if ($invite->dateType == 'Hijri') checked @endif>
                            <label class="form-check-label" for="Hijri" id="HijriText">
                                {{ __('invite.n6') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="dateT" value="Miladi" id="Miladi"
                                @if ($invite->dateType == 'Miladi') checked @endif>
                            <label class="form-check-label" for="Miladi" id="MiladiText">
                                {{ __('invite.n7') }}
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Miladi --}}
                <div class="col-6 mt-3" style="display: none;" id="MiladiBox">
                    <label for="inputDate" class="form-label fw-bold" style="">{{ __('invite.n9') }}</label>
                    @if ($invite->dateType == 'Miladi')
                        <input type="date" class="form-control" id="inputDate" value="{{ $invite->date }}"
                            name="dateMiladi">
                    @else
                        <input type="date" class="form-control" id="inputDate" value=""
                            name="dateMiladi">
                    @endif
                </div>

                {{-- Hijiri --}}
                <div class="col-6 mt-3" style="display: none;" id="HijriBox">
                    <label for="inputAddress" class="form-label fw-bold" style="">{{ __('invite.n8') }}</label>
                    @if ($invite->dateType == 'Hijri')
                        <input type='text' class="form-control" id="hijri-date-input" name="dateHijri"
                            value="{{ $invite->date }}" />
                    @else
                        <input type='text' class="form-control" id="hijri-date-input" name="dateHijri" value="" />
                    @endif
                </div>

                {{-- Event Time --}}
                <div class="col-6 mt-3">
                    <label for="inputTime" class="form-label fw-bold" style="">{{ __('invite.n10') }}</label>
                    <input type="time" class="form-control" id="inputTime" name="time"
                        value="{{ $invite->time }}">
                </div>

                {{-- Event Description --}}
                <div class="col-12 mt-3">
                    <label for="description" class="form-label fw-bold" style="">{{ __('invite.n11') }}</label>
                    <textarea id="description" style="resize: none;" rows="5" name="description" maxlength='250'
                        onkeyup="handle()" class="form-control shadow-none py-2 fw-bold" placeholder=""
                        aria-label="{{ __('invite.n11') }}">{{ $invite->description }}</textarea>
                    <p class="fw-bold" id='remaining'></p>
                </div>
            </div>

            <button type="submit" class="fw-bold btn btn-primary w-100">{{ __('invite.n15') }}</button>
            <a href="/{{ $invite->link }}/{{ App::getLocale() }}"
                class="fw-bold btn btn-success w-100 mt-2 mb-3">{{ __('invite.n16') }}</a>
        </form>
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


    <footer class="text-center py-3 text-white fw-bold mt-5"
        style="background: linear-gradient(90deg, rgba(250,44,99,1) 0%, rgba(251,167,15,1) 100%);">
        {{ __('inc.n4') }} {{ date('Y') }}
    </footer>
@endsection

@section('jss')
    <script src="{{ asset('assets/js/hijri.js') }}"></script>

    <script>
        // Handel Date Type
        if ($('#Miladi').is(':checked')) {
            $('#MiladiBox').show();
        } else {
            $('#MiladiBox').slideUp();
        }

        if ($('#Hijri').is(':checked')) {
            $('#HijriBox').show();
        } else {
            $('#HijriBox').slideUp();
        }

        $('#HijriText').click(function() {
            $('#MiladiBox').slideUp();
            $('#HijriBox').slideDown();
        });

        $('#Hijri').click(function() {
            $('#MiladiBox').slideUp();
            $('#HijriBox').slideDown();
        });

        $('#MiladiText').click(function() {
            $('#HijriBox').slideUp();
            $('#MiladiBox').slideDown();
        });
        $('#Miladi').click(function() {
            $('#HijriBox').slideUp();
            $('#MiladiBox').slideDown();
        });

        // Textarea Max Length
        function handle() {
            let element = document.getElementById('description')
            let value = element.value
            let maxLength = element.maxLength
            document.getElementById('remaining').innerText =
                `{{ __('invite.n13') }}   ${maxLength - Number(value.length)}`

        }

        $(function() {
            $("#hijri-date-input").hijriDatePicker({
                hijri: true,
                useCurrent: true,
                showSwitcher: false
            });
        });
    </script>
@endsection
