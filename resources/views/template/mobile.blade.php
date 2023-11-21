<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simple E-Banking | @yield('title') </title>
    <link rel="icon" href="{{ asset('icons/Logogram.png') }}" type="image/png">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/toast.style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toast.style.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />
    @yield('css')
</head>

<body class="flex justify-center bg-gray-200">
    <div id="app" class="w-[600px] md:w-[500px] bg-slate-50 h-full relative">
        @yield('content')
    </div>
    <script src="{{ asset('js/jquery3.7.js') }}"></script>
    @vite('resources/js/app.js')
    <script src="{{ asset('js/toast.script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js"></script>
    {{-- <script src="{{ asset('node_modules/tw-elements/dist/js/tw-elements.umd.min.js') }}"></script> --}}
    @yield('js')
</body>

</html>
