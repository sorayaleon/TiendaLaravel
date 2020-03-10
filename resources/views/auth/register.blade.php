@extends('template.main')
@section('title', 'Usuario/a | Registro')
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

    {!! Form::open(['route'=>'register', 'method'=>'POST', 'files'=>true, 'class'=>'form-horizontal']) !!}
    <div class="container">
        <div class="row">
            <!-- Columna Izquierda -->
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="text-center">
                    <img src='{{asset('recursos/sinfoto.png')}}' class='avatar img-circle img-thumbnail' alt='imagen' width='165' height='auto'>
                    <h6>Sube una foto personal</h6>
                    {{-- Imagen --}}
                    <div class="form-group">
                        {!! Form::file('imagen', ['class'=>'form-control text-center center-block well well-sm', 'required', 'accept'=>'image/jpeg']) !!}
                    </div>
                </div>
            </div>
            <!-- Columna de la derecha-->
            <div class="col-md-8 col-sm-6 col-xs-12 personal-info">
            
                <div class="form-group">
                    {!! Form::label('name', 'Nombre:', ['class'=>'col-lg-3 control-label']) !!}
                    <div class="col-lg-6">
                        {!! Form::text('name', null, ['class'=>'form-control', 'required', 'placeholder'=>'Nombre Completo'])!!}
                    </div>
                  </div>
              
                <div class="form-group">
                        {!! Form::label('email', 'Correo Electrónico:', ['class'=>'col-lg-3 control-label']) !!}
                        <div class="col-lg-6">
                            {!! Form::email('email', null, ['class'=>'form-control', 'required', 'placeholder'=>'direccion@dominio.com'])!!}
                        </div>
                </div>
                
                <div class="form-group">
                        {!! Form::label('password', 'Contraseña:', ['class'=>'col-lg-3 control-label']) !!}
                        <div class="col-lg-6">
                            {!! Form::password('password', ['class'=>'form-control', 'required', 'placeholder'=>'*********'])!!}
                        </div>
                </div>
          
                <div class="form-group">
                        {!! Form::label('password-confirm', 'Confirmar Contraseña:', ['class'=>'col-lg-3 control-label']) !!}
                        <div class="col-lg-6">
                            {!! Form::password('password_confirmation', ['class'=>'form-control', 'required', 'placeholder'=>'*********'])!!}
                        </div>
                </div>
          
                  <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        {!!Form::submit('Registrar', ['class'=>'btn btn-success'])!!}
                        {{link_to('/', $title = 'Volver', $attributes = ['class'=>'btn btn-default'], $secure = null)}}
                    </div>
                </div>
            </div>
          </div>
        </div>
    {!! Form::close() !!}

@endsection

