<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield('title', __('inc.n13'))
    </title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
    </style>
</head>

<body>

    @yield('content')

    @yield('jss')
</body>

</html>
