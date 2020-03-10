@extends('template.main')
@section('title', 'Panel de usuario/a: '. Auth::user()->name)
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br/>
    @endif
    {!! Form::open(['route'=>['home.update',  Auth::user()->id], 'method'=>'PUT', 'files'=>true, 'class'=>'form-horizontal']) !!}
    <div class="container">
        <div class="row">
            <!-- Columna Izquierda -->
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="text-center">
                    <img src='{{asset(Auth::user()->imagen)}}' class='avatar img-circle img-thumbnail' alt='imagen' width='165' height='auto'>
                    <h6>Sube una foto personal</h6>
                    <div class="form-group">
                        {!! Form::file('imagen', ['class'=>'form-control text-center center-block well well-sm', 'accept'=>'image/jpeg']) !!}
                    </div>
                </div>
            </div>
            <!-- Columna de la derecha-->
            <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
                <div class="form-group">
                    {!! Form::label('name', 'Nombre:', ['class'=>'col-lg-3 control-label']) !!}
                    <div class="col-lg-6">
                        {!! Form::text('name', Auth::user()->name, ['class'=>'form-control', 'required', 'placeholder'=>'Nombre Completo'])!!}
                    </div>
                  </div>
                <div class="form-group">
                        {!! Form::label('email', 'Correo Electrónico:', ['class'=>'col-lg-3 control-label']) !!}
                        <div class="col-lg-6">
                            {!! Form::email('email', Auth::user()->email, ['class'=>'form-control', 'required', 'placeholder'=>'direccion@dominio.com'])!!}
                        </div>
                </div>
                <div class="form-group">
                        {!! Form::label('password', 'Contraseña:', ['class'=>'col-lg-3 control-label']) !!}
                        <div class="col-lg-6">
                            {!! Form::password('password', ['class'=>'form-control'])!!}
                        </div>
                </div>
                <div class="form-group">
                        {!! Form::label('tipo', 'Tipo:', ['class'=>'col-lg-3 control-label']) !!}
                        <div class="col-lg-6">
                            @if (Auth::user()->tipo == 'admin')
                                {!! Form::label('tipo', "Administrador", ['class' => 'label label-warning'])!!}
                            @else
                                {!! Form::label('tipo', "Normal", ['class' => 'label label-info'])!!}
                            @endif
                        </div>
                </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        {!!Form::submit('Actualizar', ['class'=>'btn btn-primary'])!!}
                        {{link_to('/', $title = 'Volver', $attributes = ['class'=>'btn btn-default'], $secure = null)}}

                        {!! Form::close() !!}
                        <br><br>

                        @if (session('acceso'))
                            <h6>Aténticado a las: {{session('acceso')}}</h6>
                        @endif

                        @if (!isset($_COOKIE['acceso']))
                            @php
                                setcookie('acceso',1, time() + 60* 60 * 24 * 365); // Un año
                            @endphp
                            <h6>Visitas al panel este año: 1 </h6>
                        @else
                            @php
                                $acceso = $_COOKIE['acceso'] + 1;
                                setcookie('acceso',$acceso, time() + 60 * 60 * 24 * 365); // Un año
                            @endphp
                            <h6>Visitas al panel este año: {{$_COOKIE['acceso']}}</h6>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i>Mis compras
            </h2>
        </div>
        {!! Form::open(['route'=>'home', 'method'=>'GET', 'class'=>'form-inline']) !!}
        <div class="form-group">
                {!! Form::date('fechaInicio', \Carbon\Carbon::yesterday(), ['class'=>'form-control']) !!}
                {!! Form::date('fechaFin', \Carbon\Carbon::tomorrow(), ['class'=>'form-control']) !!}
                {!! Form::submit('Buscar Venta', ['class'=>'btn btn-primary'])!!}
        </div>
        {!! Form::close() !!}
        @if (count($compras) > 0)
            <table class='table table-bordered table-striped'>
                <thead>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Fecha</th>
                    <th class="text-center">Importe</th>
                    <th class="text-center">Acción</th>
                </thead>
                <tbody>
                    @foreach ($compras as $compra)
                        <tr>
                            <td>{{$compra->id}}</td>
                            <td>{{$compra->codigo}}</td>
                            <td>{{DateTime::createFromFormat('Y-m-d H:i:s', $compra->fecha)->format('d/m/Y')}}</td>
                            <td class="text-center">{{$compra->total}} €</td>
                            <td class="text-center">
                                    <a class='btn btn-info' href='{{route('home.compra', $compra->id)}}' title='Ver Venta' data-toggle='tooltip'><span class='glyphicon glyphicon-search'></span></a>
                                    <a class='btn btn-warning' href='{{route('home.pdf', $compra->id)}}' title='Descargar Factura' data-toggle='tooltip'><span class='glyphicon glyphicon-file'></span></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else
            <p class='lead'><em>No se ha encontrado datos de compras.</em></p>
        @endif

        <div class='text-center'>
                {!! $compras->render()!!}
        </div>
<br><br>
@endsection
