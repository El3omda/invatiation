<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        @font-face {
            font-family: 'arabic';
            src: url('https://inv.almiqias.com/assets/fonts/ar.ttf') format("truetype");
            font-weight: 400;
            font-style: normal;
        }

        @font-face {
            font-family: 'english';
            src: url('https://inv.almiqias.com/assets/fonts/en.ttf') format("truetype");
            font-weight: 400;
            font-style: normal;
        }

        .ar {
            font-family: DejaVu Sans, sans-serif;
        }

        .en {
            font-family: 'english', sans-serif;
        }
    </style>
</head>

<body>

    <img src="https://i.ibb.co/XDnC1Zs/image.jpg"
        style="position: absolute;top: -50px;left: -40px;right: -30px;bottom: -20px;width: 785px;height: 1130px;z-index: -1;">

    <br><br><br><br>
    <center>
        <img style="border-radius: 50%;padding: 5px;border: 2px solid #c79435;" width="200px" height="200px"
            src="{{ !empty($invite->photo) ? 'https://inv.almiqias.com/' . $invite->photo : 'https://inv.almiqias.com/assets/images/default.jpg' }}"
            alt="Logo" />
        <br>

        {{-- Name Of Invitation Owner --}}
        <h1 class="en" style="font-size: 50px">
            {{ $owner }}
        </h1>

        <br>

        <h2 style="display: inline-block;">

            <sup><sup><sup><sup><img style="" width="20px"
                                src="https://i.ibb.co/4RnzQKH/double-quotes-2.jpg" /></sup></sup></sup></sup>

            {{ \App\Http\Controllers\InvitesController::remove_emoji($description) }}

            <sub><sub><sub><sub><img width="20px" src="https://i.ibb.co/7SXy4Vz/down.jpg" /></sub></sub></sub></sub>

        </h2>

        <br>

        <h2>
            <span style="color: rgba(250,44,99,1);;"> {{ $day }}</span> {{ $str2 }}
            {{ $dateT }} {{ $invite->date }} {{ $str3 }}

            <br>
            <br>

            {{ $event }} {{ $str1 }}
        </h2>

        <br>
    </center>

</body>

</html>
