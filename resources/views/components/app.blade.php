<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>LaraInsta</title>

    {{-- Fonts --}}
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap --}}
    <link rel="stylesheet" href="{{asset('lib/css/app.css')}}">

    {{-- Main CSS --}}
    <link rel="stylesheet" href="{{asset('lib/css/main.css')}}">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{asset('lib/css/style.css')}}">

    {{-- Font Awesome --}}
    <link href="{{asset('lib/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

    {{-- Unicons --}}
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"/>

</head>
<body>
    <!-- Essential javascripts for application to work-->
    <script src="{{asset('lib/js/jquery.min.js')}}"></script>
    <script src="{{asset('lib/js/popper.min.js')}}"></script>
    <script src="{{asset('lib/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('lib/js/app.js')}}"></script>

    <div class="container">
        <div class="row">
            @auth
                <div class="col-2">
                    <x-sidebar/>
                </div>
            @else
                <x-header/>
            @endauth

            <div class="col">
                <main>

                    {{ $slot }}

                </main>
                
            </div>
        </div>
    </div>

    <script src="{{asset('lib/js/jquery.min.js')}}"></script>
    <script src="{{asset('lib/js/popper.min.js')}}"></script>
    <script src="{{asset('lib/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('lib/js/app.js')}}"></script>
    
    @stack('scripts')
    
</body>
</html>