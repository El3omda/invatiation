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

    <br><br><br><br>
    <center>
        <img style="border-radius: 50%;padding: 5px;border: 1px solid rgba(250,44,99,1);" width="200px" height="200px"
            src="{{ !empty($invite->photo) ? 'https://inv.almiqias.com/' . $invite->photo : 'https://inv.almiqias.com/assets/images/default.jpg' }}" alt="Logo" />
        <br>

        {{-- Name Of Invitation Owner --}}
        <h1>
            {{ $owner }}
        </h1>

        <br>



        <h2 style="display: inline-block;">

            <sup><sup><sup><sup><img style="" width="20px"
                                src="https://i.ibb.co/4RnzQKH/double-quotes-2.jpg" /></sup></sup></sup></sup>

            {{ $description }}

            <sub><sub><sub><sub><img width="20px" src="https://i.ibb.co/7SXy4Vz/down.jpg" /></sub></sub></sub></sub>

        </h2>

        <br>

        <h2>
            <span style="color: rgba(250,44,99,1);;"> {{ $day }}</span> {{ $str2 }} {{ $event }} {{ $str1 }}

            <br>

            {{ $dateT }} {{ $invite->date }} {{ $str3 }}
        </h2>

        <br>
    </center>

</body>

</html>
