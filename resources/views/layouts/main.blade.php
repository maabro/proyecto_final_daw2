<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Soccermarkt · Football stats</title>
    <link rel="icon" type="image/svg" href="{{ asset('favicon.svg') }}" sizes="32x32">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://kit.fontawesome.com/02dda62dae.js" crossorigin="anonymous"></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body>
    <x-header></x-header>
    <section class="container">
        @section('content')
        @show
    </section>
    <x-footer></x-footer>
    <script>
        $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $('#scroll-top').click(function(){  
		    $('html, body').animate({scrollTop:0}, 'slow');
		    return false;
	    });
        });
    </script>
</body>
</html>