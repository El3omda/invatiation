<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        * {
            font-family: DejaVu Sans, sans-serif;
        }
    </style>
</head>

<body>

    <img src="https://i.ibb.co/sVw86Hg/image.jpg"
        style="position: absolute;top: -50px;left: -40px;right: -30px;bottom: -20px;width: 785px;height: 1130px;z-index: -1;">

    <br><br><br><br>
    <center>
        <img style="border-radius: 50%;padding: 5px;border: 7px solid #c79435;" width="200px" height="200px"
            src="{{ !empty($invite->photo) ? 'https://inv.almiqias.com/' . $invite->photo : 'https://inv.almiqias.com/assets/images/default.jpg' }}"
            alt="Logo" />
        <br>

        {{-- Name Of Invitation Owner --}}
        <h1 class="en" style="font-size: 50px">
            {{ $owner }}
        </h1>


        <h2 style="display: inline-block;">

            <sup><sup><sup><sup><img style="" width="20px"
                                src="https://i.ibb.co/4RnzQKH/double-quotes-2.jpg" /></sup></sup></sup></sup>

            {{ \App\Http\Controllers\InvitesController::remove_emoji($description) }}

            <sub><sub><sub><sub><img width="20px" src="https://i.ibb.co/7SXy4Vz/down.jpg" /></sub></sub></sub></sub>

        </h2>

        <br>

        @if (App::getLocale() == 'ar')
            <h2>
                {{ $dateT }} {{ $invite->date }} {{ $str3 }}

                <span style="color: rgba(250,44,99,1);;"> {{ $day }}</span> {{ $str2 }}

                <br>
                <br>
                <br>

                <img src="https://i.ibb.co/bbm1xM5/decoration.jpg" style="width: 300px;" alt="">

                <br>
                <br>

                {{ $event }} {{ $str1 }}

                <br>
                <br>

                <img src="https://i.ibb.co/bbm1xM5/decoration.jpg" style="width: 300px;" alt="">

                <br>
            </h2>
        @else
            <h2>

                {{ $str2 }} <span style="color: rgba(250,44,99,1);;"> {{ $day }}</span>

                {{ $str3 }} {{ $invite->date }} {{ $dateT }}

                <br>
                <br>
                <br>

                <img src="https://i.ibb.co/bbm1xM5/decoration.jpg" style="width: 300px;" alt="">

                <br>
                <br>

                {{ $str1 }} {{ $event }}

                <br>
                <br>

                <img src="https://i.ibb.co/bbm1xM5/decoration.jpg" style="width: 300px;" alt="">

                <br>
            </h2>
        @endif

        <br>

        <a href="https://inv.almiqias.com/ar">inv.almiqias.com</a>

    </center>

</body>

</html>
