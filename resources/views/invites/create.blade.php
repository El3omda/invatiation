@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">

    <style>
        * {
            font-family: 'Cairo', Arial, Helvetica, sans-serif;
        }
    </style>
@endsection

@php

    // $tz = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['REMOTE_ADDR']))['geoplugin_timezone'];
    // echo '<br>' . $tz . '<br>';
    // if ($tz == null) {
    date_default_timezone_set('Asia/Riyadh');
    // } else {
    // date_default_timezone_set($tz);
    // }
@endphp

@section('content')
    <div class="container mt-5">
        <h1 class="text-center fw-bold">
            {{ __('invite.n1') }}
        </h1>

        <form action="{{ route('invStore', App::getLocale()) }}" method="POST" style="direction: rtl"
            enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="row mt-5">
                {{-- Photo --}}
                <div class=" col-md-12 mb-3">
                    <label for="formFile" class="form-label fw-bold">{{ __('invite.n2') }}</label>
                    <input class="form-control" type="file" name="photo" id="formFile">
                </div>

                {{-- Owner --}}
                <div class="col">
                    <label for="owner" class="form-label fw-bold" style="">{{ __('invite.n3') }}</label>
                    <input type="text" id="owner" name="owner" value="{{ old('owner') }}"
                        class="form-control shadow-none py-2 fw-bold" placeholder="" aria-label="Invite Owner">
                </div>

                {{-- Event --}}
                <div class="col">
                    <label for="event" class="form-label fw-bold" style="">{{ __('invite.n4') }}</label>
                    <input type="text" id="event" name="event" value="{{ old('event') }}"
                        class="form-control shadow-none py-2 fw-bold" placeholder="" aria-label="{{ __('invite.n4') }}">
                </div>

                <hr class="mt-5">

                <p class="text-danger fw-bold text-center">
                    @error('dateMiladi')
                        @if (App::getLocale() == 'ar')
                            يلزم أدخال تاريخ
                        @else
                            Please Enter A Valid Date
                        @endif
                    @enderror
                    @error('dateHijri')
                        @if (App::getLocale() == 'ar')
                            يلزم أدخال تاريخ
                        @else
                            Please Enter A Valid Date
                        @endif
                    @enderror
                </p>

                {{-- Date Type --}}
                <div class="col-12 mt-3">
                    <label for="inputAddress" class="form-label fw-bold" style="">{{ __('invite.n5') }}</label>
                    <div class="d-flex justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="dateT" value="Hijri" id="Hijri">
                            <label class="form-check-label" for="Hijri" id="HijriText">
                                {{ __('invite.n6') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="dateT" value="Miladi" id="Miladi"
                                checked>
                            <label class="form-check-label" for="Miladi" id="MiladiText">
                                {{ __('invite.n7') }}
                            </label>
                        </div>
                    </div>
                </div>

                <hr class="mt-5">

                {{-- Miladi --}}
                <div class="col-6 mt-3" style="display: none;" id="MiladiBox">
                    <label for="inputDate" class="form-label fw-bold" style="">{{ __('invite.n9') }}</label>
                    <input type="date" class="form-control dateMiladi" id="inputDate" value="{{ old('dateMiladi') }}"
                        name="dateMiladi">
                </div>

                {{-- Hijiri --}}
                <div class="col-6 mt-3" style="display: none;" id="HijriBox">
                    <label for="inputAddress" class="form-label fw-bold" style="">{{ __('invite.n8') }}</label>
                    <input type='text' class="form-control dateHijri" id="hijri-date-input" value="{{ old('dateHijri') }}"
                        name="dateHijri" />
                </div>

                {{-- Event Time --}}
                <div class="col-6 mt-3">
                    <label for="inputTime" class="form-label fw-bold" style="">{{ __('invite.n10') }}</label>
                    <input type="time" class="form-control" id="inputTime" name="time" value="{{ date('H:i') }}">
                </div>

                {{-- Event Description --}}
                <div class="col-12 mt-3">
                    <label for="description" class="form-label fw-bold" style="">{{ __('invite.n11') }}</label>
                    <textarea id="description" style="resize: none;" rows="5" name="description" maxlength='250'
                        onkeyup="handle()" class="form-control shadow-none py-2 fw-bold" placeholder=""
                        aria-label="{{ __('invite.n11') }}">{{ old('description') }}</textarea>
                    <p class="fw-bold" id='remaining'></p>
                </div>

                {{-- recaptcha --}}
                {{-- <div class="col-12 my-3">
                    {!! NoCaptcha::renderJs() !!}
                    {!! NoCaptcha::display() !!}
                </div> --}}
            </div>

            <button type="submit" class="fw-bold btn btn-primary w-100 mb-3">{{ __('invite.n12') }}</button>
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
    {{-- Recaptcha --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script src="{{ asset('assets/js/hijri.js') }}"></script>

    <script>
        // Handel Date Type
        if ($('#Miladi').is(':checked')) {
            $('#MiladiBox').show();
        } else {
            $('#MiladiBox').slideUp();
        }


        $('#Hijri').click(function() {
            $('#MiladiBox').slideUp();
            $('#HijriBox').slideDown();
            $('.dateMiladi').val('');
        });
        $('#Miladi').click(function() {
            $('#HijriBox').slideUp();
            $('#MiladiBox').slideDown();
            $('.dateHijri').val('');
        });


        $('#HijriText').click(function() {
            $('#MiladiBox').slideUp();
            $('#HijriBox').slideDown();
            $('.dateMiladi').val('');
        });
        $('#MiladiText').click(function() {
            $('#HijriBox').slideUp();
            $('#MiladiBox').slideDown();
            $('.dateHijri').val('');
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
                showSwitcher: false,
                locale: '{{ App::getLocale() == 'ar' ? 'ar-SA' : 'en-us' }}'
            });
        });
    </script>
@endsection
