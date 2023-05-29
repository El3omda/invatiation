<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield('title', __('inc.n13'))
    </title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/logo.png') }}">

    {{-- Css --}}

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300&family=Ubuntu:wght@300&display=swap"
        rel="stylesheet">

    {{-- Font Awsome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Additional Css --}}
    @yield('css')


    @if (App::getLocale() == 'ar')
        <style>
            * {
                font-family: 'Cairo';
            }

            .dir {
                direction: rtl !important;
            }
        </style>
    @else
        <style>
            * {
                font-family: 'Ubuntu';
            }
        </style>
    @endif

    <style>
        ::-webkit-scrollbar {
            width: 5px
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(250, 44, 99, 1);
        }

        .copyright-area {
            background: #202020;
            padding: 25px 0;
        }

        .copyright-text p {
            margin: 0;
            font-size: 14px;
            color: #878787;
        }

        .copyright-text p a {
            color: #ff5e14;
        }

        .footer-menu li {
            display: inline-block;
            margin-left: 20px;
        }

        .footer-menu li:hover a {
            color: #ff5e14;
        }

        .footer-menu li a {
            font-size: 14px;
            color: #878787;
        }
    </style>

</head>

<body>

    {{-- Navigation Bar --}}
    <nav class="navbar navbar-expand-lg bg-body-tertiary dir">
        <div class="container-fluid">
            <a class="navbar-brand" href="/{{ App::getLocale() }}">
                <img width="60px" src="{{ asset('assets/images/logo.png') }}" alt="logo">
            </a>
            <button class="navbar-toggler dispr" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" aria-current="page" href="/{{ App::getLocale() }}">{{ __('inc.n1') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="/{{ App::getLocale() }}/about">{{ __('inc.n2') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="/{{ App::getLocale() }}/contact">{{ __('inc.n3') }}</a>
                    </li>
                    <li class="nav-item">
                        @if (App::getLocale() == 'ar')
                            <a class="nav-link fw-bold" style="font-family: 'Ubuntu' !important;"
                                href="/en">English</a>
                        @else
                            <a class="nav-link fw-bold" style="font-family: 'Cairo' !important;"
                                href="/ar">العربية</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    {{-- Js --}}

    {{-- Jquery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>

    {{-- Moment.js --}}
    <script src="{{ asset('assets/js/momment.js') }}"></script>

    {{-- Additional JS --}}
    @yield('jss')
</body>

</html>
