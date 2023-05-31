@extends('layout')

@section('title')
    {{ $invite->event }}
@endsection

@section('css')
    {{-- Open Graph --}}

    <meta name="description" content="نقدم لك خدمة انشاء دعوات لمناسباتك مع امكانية مشاركة رابط الدعوة مع من تحب">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="https://inv.almiqias.com/{{ $invite->link }}/ar">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $invite->event }}">
    <meta property="og:description" content="{{ $invite->description }}">
    <meta property="og:image"
        content="{{ !empty($invite->photo) ? 'https://inv.almiqias.com/' . $invite->photo : 'https://inv.almiqias.com/assets/images/default.jpg' }}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="inv.almiqias.com">
    <meta property="twitter:url" content="https://inv.almiqias.com/{{ $invite->link }}/ar">
    <meta name="twitter:title" content="{{ $invite->event }}">
    <meta name="twitter:description" content="{{ $invite->description }}">
    <meta name="twitter:image"
        content="{{ !empty($invite->photo) ? 'https://inv.almiqias.com/' . $invite->photo : 'https://inv.almiqias.com/assets/images/default.jpg' }}">

    <link rel="stylesheet" href="https://pbutcher.uk/flipdown/css/flipdown/flipdown.css">
    <style>
        .rotor-group-heading,
        .countUp h3,
        .example h3 {
            font-family: 'Cairo' !important;
        }

        .flipdown {
            width: fit-content !important;
            height: 70px !important;
            margin: auto !important;
            direction: rtl !important;
        }

        ul#countdown {
            width: 70%;
            margin: 0 auto;
            padding: 15px 0 20px 0;
            color: #fff;
            border: 1px solid #adafb2;
            border-width: 1px 0;
            overflow: hidden;
            font-family: "Arial Narrow", Arial, sans-serif;
            font-weight: bold;
        }

        ul#countdown li {
            margin: 0 -3px 0 0;
            padding: 0;
            display: inline-block;
            width: 25%;
            font-size: 72px;
            font-size: 6vw;
            text-align: center;
        }

        ul#countdown li .label {
            color: #333;
            font-size: 18px;
            font-size: 1.5vw;
            text-transform: uppercase;
            font-family: 'Cairo';
        }

        @media (max-width: 800px) {
            ul#countdown li .label {
                font-size: 20px;
            }
        }

        @media (max-width: 500px) {
            ul#countdown li .label {
                font-size: 18px;
            }

            ul#countdown {
                width: 100%;
            }
        }
    </style>

    {{-- Media Print --}}
    <style>
        @media print {
            .dispr {
                display: none !important;
            }
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

    // echo '<br>' . date_default_timezone_get() . '<br>';

    function HijriToJD($m, $d, $y)
    {
        return (int) ((11 * $y + 3) / 30) + 354 * $y + 30 * $m - (int) (($m - 1) / 2) + $d + 1948440 - 385;
    }

    // Count Down Time Stamp

    #Check Date Type
    if (!empty($invite->date)) {
        if ($invite->dateType == 'Miladi') {
            $d = DateTime::createFromFormat('Y-m-d H:i', $invite->date . ' ' . $invite->time);
            $timeS = $d->getTimestamp();
        } else {
            $exploadeDate = explode('-', $invite->date);

            $date = HijriToJD($exploadeDate[1], $exploadeDate[2], $exploadeDate[0]);

            $originalDate = jdtogregorian($date);
            $newDate = date('Y-m-d', strtotime($originalDate));

            $d = DateTime::createFromFormat('Y-m-d H:i', $newDate . ' ' . $invite->time);
            $timeS = $d->getTimestamp();
        }
    }

@endphp

@section('content')
    <div class="container">

        {{-- Show Options If client Own This Invitation --}}
        @if ($invite->ip == $_SERVER['REMOTE_ADDR'])
            <div class="d-flex justify-content-between my-5 dispr">
                <div>
                    <a href="{{ route('invEdit', [$invite->id, App::getLocale()]) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
                <div>
                    <form action="{{ route('invDelete', [App::getLocale(), $invite->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endif

        {{-- Invitation Data --}}
        <div class="text-center mb-5">

            {{-- Image Of Invitation Owner --}}
            @if (!empty($invite->photo))
                <div class="mb-4">
                    <img src="{{ $invite->photo }}" class="img-fluid rounded-circle"
                        style="height: 200px;width: 200px;padding: 5px;border: 1px solid rgba(250,44,99,1);" alt="">
                </div>
            @else
                <div class="mb-4">
                    <img src="{{ asset('assets/images/default.jpg') }}" class="img-fluid rounded-circle"
                        style="height: 200px;width: 200px;padding: 5px;border: 1px solid rgba(250,44,99,1);" alt="">
                </div>
            @endif

            {{-- Name Of Invitation Owner --}}
            <h3 class="fw-bold">
                {{ $invite->owner }}
            </h3>
            <br>

            {{-- Invitation Description --}}
            <h4 class="fw-bold dir" style="
            @if (!preg_match('/[^A-Za-z0-9]/', $invite->description))
            @else
            direction: rtl !important;
            @endif
            ">

                @if (!preg_match('/[^A-Za-z0-9]/', $invite->description))
                    {{-- <sup><sup><i class="fa-sharp fa-solid fa-quote-left" style="color: rgba(250,44,99,1);"></i></sup></sup> --}}
                    en
                @else
                    <sup><sup><i class="fa-sharp fa-solid fa-quote-right" style="color: rgba(250,44,99,1);"></i></sup></sup>
                @endif

                {{ $invite->description }}

                @if (!preg_match('/[^A-Za-z]/', $invite->description))
                    {{-- <sup><sup><i class="fa-sharp fa-solid fa-quote-left" style="color: rgba(250,44,99,1);"></i></sup></sup> --}}
                    en
                @else
                    <sub><sub><i class="fa-sharp fa-solid fa-quote-left" style="color: rgba(250,44,99,1);"></i></sub></sub>
                @endif

                @if (preg_match('/[^A-Za-z0-9]/', $invite->description))
                    English
                @else
                    Arabic
                @endif
            </h4>

            <br>
            {{-- Invitation Date And Time --}}
            @if (!empty($invite->date))
                <h4 class="fw-bold">
                    @if (App::getLocale() == 'ar')
                        يوم
                    @else
                        On
                    @endif
                    <span style="color: rgba(250,44,99,1);">
                        {{ $day }}
                    </span>

                    @if (App::getLocale() == 'ar')
                        الموافق
                    @else
                        At
                    @endif
                    <span style="color: rgba(250,44,99,1);">{{ $invite->date }}</span>
                    @if ($invite->dateType == 'Hijri')
                        @if (App::getLocale() == 'ar')
                            هـ
                        @else
                            Hijri
                        @endif
                    @else
                        @if (App::getLocale() == 'ar')
                            مـ
                        @else
                            AD
                        @endif
                    @endif
                    <br><br>
                    @if (App::getLocale() == 'ar')
                        المناسبة
                    @else
                        Event
                    @endif : {{ $invite->event }}
                </h4>
            @endif
        </div>

        @if (!empty($invite->date))
            {{-- Count Down --}}
            <div class="example">
                <h3 class="fw-bold text-center mb-4">{{ __('invite.s15') }}</h3>

                <div id="flipdown" class="flipdown"></div>
            </div>

            {{-- Count Up --}}
            <div class="countUp" style="display: none;">
                <h3 class="fw-bold text-center">{{ __('invite.s1') }}</h3>

                <ul id="countdown" class="text-dark">

                    <li id="days">
                        <div class="number">00</div>
                        <div class="label">{{ __('invite.s5') }}</div>
                    </li>
                    <li id="hours">
                        <div class="number">00</div>
                        <div class="label">{{ __('invite.s4') }}</div>
                    </li>
                    <li id="minutes">
                        <div class="number">00</div>
                        <div class="label">{{ __('invite.s3') }}</div>
                    </li>
                    <li id="seconds">
                        <div class="number">00</div>
                        <div class="label">{{ __('invite.s2') }}</div>
                    </li>
                </ul>
            </div>
        @endif

        {{-- Share Invite --}}
        <div class="mt-5 text-center w-75 mx-auto dispr" style="direction: rtl">
            <a onclick="copyLink()" id="copyLink" class="btn btn-secondary mb-2">
                <input type="text" style="width: 0;display: none;" value="{{ url()->full() }}" id="url">
                <i class="fa-solid fa-copy"></i>
                <span>{{ __('invite.s6') }}</span>
            </a>

            <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->full() }}" target="_blank"
                class="btn btn-primary mb-2">
                <i class="fab fa-facebook-f m-r-7"></i>
                {{ __('invite.s8') }}
            </a>

            <a target="_blank"
                href="https://twitter.com/intent/tweet?text=لقد تم دعوتك من خلال {{ $invite->owner }} الي {{ $invite->event }}&url={{ url()->full() }}"
                class="btn btn-primary mb-2" style="background-color: #1DA1F2 !important;">
                <i class="fab fa-twitter m-r-7"></i>
                {{ __('invite.s9') }}
            </a>

            <a target="_blank"
                href="https://mail.google.com/mail/u/0/?view=cm&to&su=&body=https%3A%2F%2F{{ url()->full() }}%0A&bcc&cc&fs=1&tf=1"
                class="btn btn-danger mb-2">
                <i class="fa fa-envelope m-r-7"></i>
                {{ __('invite.s10') }}
            </a>

            <a target="_blank"
                href="whatsapp://send?text=لقد تم دعوتك من خلال {{ $invite->owner }} الي {{ $invite->event }} \n {{ url()->full() }}"
                data-action="share/whatsapp/share" class="btn btn-success mb-2">
                <i class="fab fa-whatsapp m-r-7"></i>
                {{ __('invite.s11') }}
            </a>

            <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url={{ url()->full() }}"
                class="btn btn-primary mb-2" style="background-color: #0072b1 !important;">
                <i class="fab fa-linkedin m-r-7"></i>
                {{ __('invite.s12') }}
            </a>

            <a target="_blank"
                href="https://telegram.me/share/url?url={{ url()->full() }}&text=لقد تم دعوتك من خلال {{ $invite->owner }} الي {{ $invite->event }}"
                class="btn btn-primary mb-2" style="background-color: #229ED9 !important;">
                <i class="fab fa-telegram m-r-7"></i>
                {{ __('invite.s13') }}
            </a>

            <a href="{{ route('invPDF', [App::getLocale(), $invite->id]) }}" class="btn btn-danger mb-2">
                <i class="fa-solid fa-file-pdf"></i>
                {{ __('invite.s14') }}
            </a>
        </div>

        <br>
        <br>

        <div class="text-center dispr mb-3">
            <a href="/add/{{ App::getLocale() }}"
                style="background: linear-gradient(90deg, rgba(250,44,99,1) 0%, rgba(251,167,15,1) 100%);"
                class="btn fw-bold text-white p-3 mt-5">{{ __('home.h2') }}</a>
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


    <footer class="text-center py-3 text-white fw-bold mt-5"
        style="background: linear-gradient(90deg, rgba(250,44,99,1) 0%, rgba(251,167,15,1) 100%);">
        {{ __('inc.n4') }} {{ date('Y') }}
    </footer>
@endsection

@section('jss')
    <script>
        function copyLink() {
            var copyText = document.getElementById("url");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);
            $('#copyLink span').text("{{ __('invite.s60') }}");
            setTimeout(function() {
                $('#copyLink span').text("{{ __('invite.s6') }}");
            }, 3000)
        }
    </script>

    @if (!empty($invite->date))
        {{-- Count Down --}}
        <script src="https://pbutcher.uk/flipdown/js/flipdown/flipdown.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {

                // Set up FlipDown
                var flipdown = new FlipDown({{ $timeS }}, {
                        headings: ["{{ __('invite.s5') }}", "{{ __('invite.s4') }}", "{{ __('invite.s3') }}",
                            "{{ __('invite.s2') }}"
                        ],
                    })

                    // Start the countdown
                    .start()

                    // Do something when the countdown ends
                    .ifEnded(() => {
                        $('.example').slideUp();
                        $('.countUp').delay(1000).slideDown();
                    });
            });
        </script>

        {{-- Count Up --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
        @if ($invite->dateType == 'Miladi')
            <script>
                /* --------------------------
                 * GLOBAL VARS
                 * -------------------------- */
                // The date you want to count down to
                var targetDate = new Date("{{ $invite->date }} {{ $invite->time }}");

                targetDate.setHours(targetDate.getHours() - 1);

                // Other date related variables
                var days;
                var hrs;
                var min;
                var sec;

                /* --------------------------
                 * ON DOCUMENT LOAD
                 * -------------------------- */
                $(function() {
                    // Calculate time until launch date
                    timeToLaunch();
                    // Transition the current countdown from 0
                    numberTransition('#days .number', days, 1000, 'easeOutQuad');
                    numberTransition('#hours .number', hrs, 1000, 'easeOutQuad');
                    numberTransition('#minutes .number', min, 1000, 'easeOutQuad');
                    numberTransition('#seconds .number', sec, 1000, 'easeOutQuad');
                    // Begin Countdown
                    setTimeout(countDownTimer, 1001);
                });

                /* --------------------------
                 * FIGURE OUT THE AMOUNT OF
                   TIME LEFT BEFORE LAUNCH
                 * -------------------------- */
                function timeToLaunch() {
                    // Get the current date
                    var currentDate = new Date();

                    // Find the difference between dates
                    var diff = (currentDate - targetDate) / 1000;
                    var diff = Math.abs(Math.floor(diff));

                    // Check number of days until target
                    days = Math.floor(diff / (24 * 60 * 60));
                    sec = diff - days * 24 * 60 * 60;

                    // Check number of hours until target
                    hrs = Math.floor(sec / (60 * 60));
                    sec = sec - hrs * 60 * 60;

                    // Check number of minutes until target
                    min = Math.floor(sec / (60));
                    sec = sec - min * 60;
                }

                /* --------------------------
                 * DISPLAY THE CURRENT
                   COUNT TO LAUNCH
                 * -------------------------- */
                function countDownTimer() {

                    // Figure out the time to launch
                    timeToLaunch();

                    // Write to countdown component
                    $("#days .number").text(days);
                    $("#hours .number").text(hrs);
                    $("#minutes .number").text(min);
                    $("#seconds .number").text(sec);

                    // Repeat the check every second
                    setTimeout(countDownTimer, 1000);
                }

                /* --------------------------
                 * TRANSITION NUMBERS FROM 0
                   TO CURRENT TIME UNTIL LAUNCH
                 * -------------------------- */
                function numberTransition(id, endPoint, transitionDuration, transitionEase) {
                    // Transition numbers from 0 to the final number
                    $({
                        numberCount: $(id).text()
                    }).animate({
                        numberCount: endPoint
                    }, {
                        duration: transitionDuration,
                        easing: transitionEase,
                        step: function() {
                            $(id).text(Math.floor(this.numberCount));
                        },
                        complete: function() {
                            $(id).text(this.numberCount);
                        }
                    });
                };
            </script>
        @else
            <script>
                /* --------------------------
                 * GLOBAL VARS
                 * -------------------------- */
                // The date you want to count down to
                var targetDate = new Date("{{ $newDate }} {{ $invite->time }}");
                targetDate.setHours(targetDate.getHours() - 1);
                // Other date related variables
                var days;
                var hrs;
                var min;
                var sec;

                /* --------------------------
                 * ON DOCUMENT LOAD
                 * -------------------------- */
                $(function() {
                    // Calculate time until launch date
                    timeToLaunch();
                    // Transition the current countdown from 0
                    numberTransition('#days .number', days, 1000, 'easeOutQuad');
                    numberTransition('#hours .number', hrs, 1000, 'easeOutQuad');
                    numberTransition('#minutes .number', min, 1000, 'easeOutQuad');
                    numberTransition('#seconds .number', sec, 1000, 'easeOutQuad');
                    // Begin Countdown
                    setTimeout(countDownTimer, 1001);
                });

                /* --------------------------
                 * FIGURE OUT THE AMOUNT OF
                   TIME LEFT BEFORE LAUNCH
                 * -------------------------- */
                function timeToLaunch() {
                    // Get the current date
                    var currentDate = new Date();

                    // Find the difference between dates
                    var diff = (currentDate - targetDate) / 1000;
                    var diff = Math.abs(Math.floor(diff));

                    // Check number of days until target
                    days = Math.floor(diff / (24 * 60 * 60));
                    sec = diff - days * 24 * 60 * 60;

                    // Check number of hours until target
                    hrs = Math.floor(sec / (60 * 60));
                    sec = sec - hrs * 60 * 60;

                    // Check number of minutes until target
                    min = Math.floor(sec / (60));
                    sec = sec - min * 60;
                }

                /* --------------------------
                 * DISPLAY THE CURRENT
                   COUNT TO LAUNCH
                 * -------------------------- */
                function countDownTimer() {

                    // Figure out the time to launch
                    timeToLaunch();

                    // Write to countdown component
                    $("#days .number").text(days);
                    $("#hours .number").text(hrs);
                    $("#minutes .number").text(min);
                    $("#seconds .number").text(sec);

                    // Repeat the check every second
                    setTimeout(countDownTimer, 1000);
                }

                /* --------------------------
                 * TRANSITION NUMBERS FROM 0
                   TO CURRENT TIME UNTIL LAUNCH
                 * -------------------------- */
                function numberTransition(id, endPoint, transitionDuration, transitionEase) {
                    // Transition numbers from 0 to the final number
                    $({
                        numberCount: $(id).text()
                    }).animate({
                        numberCount: endPoint
                    }, {
                        duration: transitionDuration,
                        easing: transitionEase,
                        step: function() {
                            $(id).text(Math.floor(this.numberCount));
                        },
                        complete: function() {
                            $(id).text(this.numberCount);
                        }
                    });
                };
            </script>
        @endif
    @endif
@endsection
