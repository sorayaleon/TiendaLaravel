@extends('template.main')
@section('title', 'Admin | Ver Usuario/a: '. $user->name)
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

    {!! Form::open(['route'=>'users.index', 'method'=>'GET', 'class'=>'form-horizontal']) !!}
    <div class="container">
        <div class="row">
            <!-- Columna Izquierda -->
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="text-center">
                    {{-- Imagen --}}
                    <img src='{{asset($user->imagen)}}' class='avatar img-circle img-thumbnail' alt='imagen' width='225' height='225'>
                </div>
            </div>
            <!-- Columna de la derecha-->
            <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
                {{-- Nombre --}}
                <div class="form-group">
                    {!! Form::label('name', 'Nombre:', ['class'=>'col-lg-3 control-label']) !!}
                    <div class="col-lg-6">
                        {!!Form::label('name', $user->name, ['class'=>'form-control'])!!}
                    </div>
                  </div>
                {{-- Email --}}
                <div class="form-group">
                        {!! Form::label('email', 'Correo Electrónico:', ['class'=>'col-lg-3 control-label']) !!}
                        <div class="col-lg-6">
                            {!! Form::label('email', $user->email, ['class'=>'form-control'])!!}
                        </div>
                </div>
                {{-- Password --}}
                <div class="form-group">
                        {!! Form::label('password', 'Contraseña:', ['class'=>'col-lg-3 control-label']) !!}
                        <div class="col-lg-6">
                            {!! Form::label('password', '***********', ['class'=>'form-control'])!!}
                        </div>
                </div>
                {{-- Tipo --}}
                <div class="form-group">
                        {!! Form::label('tipo', 'Tipo:', ['class'=>'col-lg-3 control-label']) !!}
                        <div class="col-lg-6">
                            @if ($user->tipo == 'admin')
                                {!! Form::label('tipo', "Administrador", ['class' => 'label label-warning'])!!}
                            @else
                                {!! Form::label('tipo', "Normal", ['class' => 'label label-info'])!!}
                            @endif
                        </div>
                </div>
                {{-- Botones --}}
                  <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        {!!Form::submit('Aceptar', ['class'=>'btn btn-primary'])!!}
                        {{link_to(route('users.pdf', $user->id), $title = 'Imprimir', $attributes = ['class'=>'btn btn-default'], $secure = null)}}
                    </div>
                </div>
            </div>
          </div>
        </div>
    {!! Form::close() !!}

@endsection

