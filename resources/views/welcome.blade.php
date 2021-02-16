<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<meta name="viewport" name="csrf-token" content="{{ csrf_token() }} content="width=device-width, initial-scale=1">-->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel project03</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">

    <!-- Javascripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
        (function() {
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            };
        })();
    </script>

    <script>
        (function() {
            window.Data = {
                link: "{{ $data ?? '' }}"

            };
        })();
    </script>


</head>

<body>
    <div id="app">
        <hello></hello>
    </div>
</body>

</html>