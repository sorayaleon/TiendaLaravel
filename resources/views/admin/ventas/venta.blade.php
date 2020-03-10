@extends('template.main')
@section('title', 'Resumen de venta '. $venta->codigo)
@section('content')

<div class="row cart-body">
    {!! Form::open(['route'=>'ventas.index', 'method'=>'GET', 'class'=>'form-horizontal']) !!}
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-push-6 col-sm-push-6">
       
        <div class="panel panel-default">
            <div class="panel-heading">
                Pedido
            </div>
            
            <div class="panel-body">
                @foreach ($lineas as $linea)
                    <div class="form-group">
                            <div class="col-sm-3 col-xs-3">
                                <img class="img-responsive" src='{{asset($linea->imagen)}}' alt='imagen' width='70'>
                            </div>

                            <div class="col-sm-6 col-xs-6">
                                <div class="col-xs-12">{{$linea->producto}}</div>
                                <div class="col-xs-12"><small>Precio: <span>{{$linea->precio}} €</span></small></div>
                                <div class="col-xs-12"><small>Cantidad: <span>{{$linea->cantidad}}</span></small></div>
                            </div>
                            <div class="col-sm-3 col-xs-3 text-right">
                                <h6>{{$linea->total}} €</h6>
                            </div>
                        </div>
                    <div class="form-group"><hr></div>
                @endforeach
                
                <div class="form-group">
                    <div class="col-xs-12">
                            Subtotal:
                        <div class="pull-right"><span>{{$venta->subtotal}} €</span></div>
                    </div>
                    <div class="col-xs-12">
                        <small>I.V.A.: </small>
                        <div class="pull-right"><span>{{$venta->iva}} €</span></div>
                    </div>
                    <div class="col-xs-12">
                            <strong>TOTAL: </strong>
                            <div class="pull-right"><span><strong>{{$venta->total}} €</strong></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-md-pull-6 col-sm-pull-6">
        <div class="panel panel-default">
            <div class="panel-heading">Envío</div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('nombre', 'Nombre:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!!Form::label('nombre', $envio->nombre, ['class'=>'form-control'])!!}
                    </div>
                </div>
               
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('direccion', 'Dirección:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!!Form::label('direccion', $envio->direccion, ['class'=>'form-control'])!!}
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('ciudad', 'Ciudad:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!!Form::label('ciudad', $envio->ciudad, ['class'=>'form-control'])!!}
                    </div>
                </div>
               
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('provincia', 'Provincia:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!!Form::label('provincia', $envio->provincia, ['class'=>'form-control'])!!}
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('codigoPostal', 'Código postal:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!!Form::label('codigoPostal', $envio->codigoPostal, ['class'=>'form-control'])!!}
                    </div>
                </div>
               
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('telefono', 'Teléfono:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!!Form::label('telefono', $envio->telefono, ['class'=>'form-control'])!!}
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('email', 'Correo electrónico:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!!Form::label('email', $envio->email, ['class'=>'form-control'])!!}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="panel panel-info">
            <div class="panel-heading"><span><i class="glyphicon glyphicon-lock"></i></span> Pago electrónico</div>
            <div class="panel-body">
                    <div class="form-group">
                            <div class="col-md-12 text-center">
                                <img src="{{asset('/recursos/tarjetas.png')}}">
                        </div>
                    </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('tTipo', 'Tipo de Tarjera:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!!Form::label('tTipo', $pago->tipo, ['class'=>'form-control'])!!}
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('tTitular', 'Titular:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!!Form::label('tTitular', $pago->titular, ['class'=>'form-control'])!!}
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('tNumero', 'Numero:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!!Form::label('tNumero', '****'.$pago->numero, ['class'=>'form-control'])!!}
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('tCVV', 'CVV:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-md-12">
                        {!!Form::label('tCVV', '***', ['class'=>'form-control'])!!}
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('tMes', 'Caducidad:', ['class'=>'control-label']) !!}
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        {!!Form::label('tMes', $pago->mes, ['class'=>'form-control'])!!}
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        {!!Form::label('tAño', $pago->año, ['class'=>'form-control'])!!}
                     </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 text-center text-center">
                        
                        {!!Form::submit('Volver', ['class'=>'btn btn-default'])!!}
                        
                        {{link_to(route('ventas.pdf', $venta->id), $title = 'Factura', $attributes = ['class'=>'btn btn-primary'], $secure = null)}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {!! Form::close() !!}
</div>
<div class="row cart-footer">

@endsection

