<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Listado de Usuarios/as</title>
     <link rel="stylesheet" href="{{ asset('css/imprimir.css') }}">
    <style type="text/css">
        .wrapper{
            width: 80%;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
    </style>

</head>
<body>
        <section>
                <div class="wrapper">
                    <div class="container-fluid">
                        <div class="row">
                                <div class="row">
                                        <div class="col-xs-12">
                                            <h2 class="page-header">
                                                <img class="img-responsive" src='{{public_path('/recursos')}}/laravel-red2.png' alt='imagen' width='40'>
                                                <i class="fa fa-globe"></i>Tienda Laravel: Listado de usuarios/as
                                            </h2>
                                        </div>
                                    </div>
    @if (count($users) > 0)

    <table class='table table-bordered table-striped'>
        <thead>
            <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>E-Mail</th>
            <th class="text-center">Tipo</th>
            <th class="text-center">Imagen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td class="text-center">
                        @if ($user->tipo == 'admin')
                            <span class>Admin</span>
                        @else
                            <span>Normal</span>
                        @endif

                    </td>
                    <td class="text-center">
                            <img src='{{storage_path('app/'.$user->imagen)}}' class='avatar img-circle' alt='imagen' width='35' height='35'>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@else
    <p class='lead'><em>No se ha encontrado datos de usuarios/as.</em></p>
@endif
<h6>Creado: {{date('H:m:s d/m/Y')}}</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
</body>
</html>

