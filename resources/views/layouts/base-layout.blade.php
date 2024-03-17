<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body>
    <main class="bg-purple-50 ">
        @yield('content')
    </main>


    @livewireScripts
    @vite('resources/js/app.js')
</body>

</html>
