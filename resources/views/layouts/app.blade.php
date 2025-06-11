<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <!-- Tambahkan CSS di sini -->
    </head>
    <body>
        @include('partials.navbar')

        <div>
            @yield('content')
        </div>
        <div>
            @include('partials.footer')
        </div>
        <!-- Tambahkan JS di sini -->
        @yield('scripts')
    </body>
</html>
