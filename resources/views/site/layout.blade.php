<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    {{-- CSS global --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

</head>

<body>

    
    @include('site.header')

    <main>
        @yield('content')
    </main>

    
    @include('site.footer')

   
   <script src="{{ asset('js/script.js') }}"></script>

    
    @yield('scripts')

</body>
</html>
