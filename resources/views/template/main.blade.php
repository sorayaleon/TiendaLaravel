<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{asset('favicon.ico')}}">

    <title>@yield('title','Default')</title>

    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/micss.css') }}">

    <script src="{{ asset('plugins/jquery/js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ asset('plugins/cookies/js/cookies.js') }}"></script>




</head>
<body>
    @include('template.nav')
    <section>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-header clearfix">
                            <h3 class="pull-left">@yield('title','Default')</h3>
                        </div>
                            @include('flash::message')
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <br><br><br>
    @include('template.foot')
    <div id="cajacookies">
            <p><button onclick="aceptarCookies()" class="pull-right"><i class="fa fa-times"></i> Aceptar y cerrar</button>
                Esta página utiliza cookies propias y de terceros con el fin de mejorar el servicio. Si continuas navegando, aceptas su uso.
                Puedes informarte sobre cómo cambiar la configuración de tu navegador u obtener más información sobre la ley de cookies
                <a style="color:Gainsboro " href="http://www.interior.gob.es/politica-de-cookies" rel="nofollow" target="_blank">siguiendo este enlace</a>.
            </p>
        </div>
</body>
</html>
