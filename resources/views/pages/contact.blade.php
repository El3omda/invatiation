@extends('layout')

@section('title')
    {{ __('inc.n30') }}
@endsection

@section('css')
    <style>
        .contact .heading h2 {
            font-size: 30px;
            font-weight: 700;
            margin: 0;
            padding: 0;

        }

        .contact .heading h2 span {
            color: #fa2c63;
        }

        .contact .heading p {
            font-size: 15px;
            font-weight: 400;
            line-height: 1.7;
            color: #999999;
            margin: 20px 0 60px;
            padding: 0;
        }

        .contact .form-control {
            padding: 25px;
            font-size: 13px;
            margin-bottom: 10px;
            background: #f9f9f9;
            border: 0;
            border-radius: 10px;
        }

        .contact button.btn {
            padding: 10px;
            border-radius: 10px;
            font-size: 15px;
            background: #fa2c63;
            color: #ffffff;
        }

        .contact .title h3 {
            font-size: 18px;
            font-weight: 600;
        }

        .contact .title p {
            font-size: 14px;
            font-weight: 400;
            color: #999;
            line-height: 1.6;
            margin: 0 0 40px;
        }

        .contact .content .info {
            margin-top: 30px;
        }

        .contact .content .info i {
            font-size: 30px;
            padding: 0;
            margin: 0;
            color: #02434b;
            margin-right: 20px;
            text-align: center;
            width: 20px;
        }

        .contact .content .info h4 {
            font-size: 13px;
            line-height: 1.4;
        }

        .contact .content .info h4 span {
            font-size: 13px;
            font-weight: 300;
            color: #999999;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-3">

        <section class="contact" id="contact">
            <div class="container">
                <div class="heading text-center">
                    <h2>{{ __('inc.n5') }}
                        <span> {{ __('inc.n6') }} </span>
                    </h2>
                    <p class="fw-bold text-secondary">
                        {{ __('inc.n7') }}
                    </p>
                </div>
                <div class="row">

                    <div class="col-md-12">

                        <form action="" method="POST" style="direction: rtl;">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control fw-bold shadow-none" placeholder="{{ __('inc.n8') }}" required>
                                </div>
                                <div class="col-sm-6">
                                    <input type="email" class="form-control fw-bold shadow-none" placeholder="{{ __('inc.n9') }}"
                                        required>
                                </div>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control fw-bold shadow-none" placeholder="{{ __('inc.n10') }}" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control fw-bold shadow-none" rows="5" id="comment" placeholder="{{ __('inc.n11') }}" required></textarea>
                            </div>
                            <button class="btn btn-block fw-bold w-100" type="submit">{{ __('inc.n12') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <footer class="text-center py-3 text-white fw-bold mt-5"
        style="background: linear-gradient(90deg, rgba(250,44,99,1) 0%, rgba(251,167,15,1) 100%);">
        {{ __('inc.n4') }} {{ date('Y') }}
    </footer>
@endsection
