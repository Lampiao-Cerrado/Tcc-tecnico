<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/painel-antigo.css') }}">
</head>
<body>

    @yield('content')

    <!-- scripts globais do painel -->
    <script src="{{ asset('js/admin-dashboard.js') }}" defer></script>

    {{-- scripts específicos de cada página --}}
    @yield('scripts')

</body>
</html>
