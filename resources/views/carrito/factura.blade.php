<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{asset('favicon.ico')}}">

    <title>Factura: {{$venta->codigo}}</title>

    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/micss.css') }}">

    <script src="{{ asset('plugins/jquery/js/jquery-3.3.1.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ asset('plugins/cookies/js/cookies.js') }}"></script>

    <style>
            .invoice-title h2, .invoice-title h3 {
            display: inline-block;
            }
            .table > tbody > tr > .no-line {
                border-top: none;
            }
            .table > thead > tr > .no-line {
                border-bottom: none;
            }
            .table > tbody > tr > .thick-line {
                border-top: 2px solid;
            }
     </style>
    
    <style type="text/css" media="print">
        @media print {
            .nover{
                visibility:hidden
        }
    }
    </style>


</head>

<body>

<section class="content content_content" style="width: 80%; margin: auto;">
    <section class="invoice">
        <div class="row no-print nover">
            @include('flash::message')
        </div>
        
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                        <img class="img-responsive" src='{{asset('favicon.ico')}}' alt='imagen' width='40'>
                    <i class="fa fa-globe"></i>LaraCRUD SHOP
                    <small class="pull-right">Factura nº: {{$venta->codigo}}</small>
                </h2>
            </div>
        </div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Facturado a:</strong><br>
                        {{$pago->titular}}<br>
                        Tipo: {{$pago->tipo}}<br>
                        Nº: finalizado en **** {{$pago->numero}}<br>
                        Pagado: {{DateTime::createFromFormat('Y-m-d H:i:s', $venta->fecha)->format('d/m/Y')}}<br>
                        <strong>Fecha de pedido:</strong><br>
                                {{DateTime::createFromFormat('Y-m-d H:i:s', $venta->fecha)->format('d/m/Y')}}
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			    <strong>Enviado a:</strong><br>
                        {{$envio->nombre}}<br>
                        {{$envio->direccion}}<br>
                        {{$envio->ciudad}}<br>
                        {{$envio->provincia}}, C.P.: {{$envio->codigoPostal}}<br>
                        Telf: {{$envio->telefono}}<br>
                        Email: {{$envio->email}}
    				</address>
    			</div>
            </div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Resumen de pedido</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Producto</strong></td>
        							<td class="text-center"><strong>Precio</strong></td>
        							<td class="text-center"><strong>Cantidad</strong></td>
        							<td class="text-right"><strong>Total</strong></td>
                                </tr>
    						</thead>
    						<tbody>
                                @foreach ($lineas as $linea)
                                    <tr>
                                        <td>{{$linea->producto}}</td>
                                        <td class="text-center">{{$linea->precio}} €</td>
                                        <td class="text-center">{{$linea->cantidad}}</td>
                                        <td class="text-right">{{$linea->total}} €</td>
                                    </tr>
                                @endforeach

    							<tr>
    								<td class="thick-line"></td>
                                    <td class="thick-line"></td>
    								<td class="thick-line text-right"><strong>Subtotal:</strong></td>
    								<td class="thick-line text-right">{{$venta->subtotal}} €</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>I.V.A.:</strong></td>
    								<td class="no-line text-right">{{$venta->iva}} €</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>TOTAL:</strong></td>
    								<td class="no-line text-right">{{$venta->total}} €</td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

        <div class="row no-print nover">
            <div class="col-xs-12">
                {{link_to(route('catalogo.index'), $title = 'Finalizar y cerrar', $attributes = ['class'=>'btn btn-default'], $secure = null)}}
                {{link_to('#', $title = 'Imprimir Factura', $attributes = ['class'=>'btn btn-success pull-right', 'style'=>'margin-right: 5px', 'onclick'=>'window.print()'], $secure = null)}}
                {{link_to(route('carrito.descargar', $venta->codigo), $title = 'Descargar en PDF', $attributes = ['class'=>'btn btn-primary pull-right', 'style'=>'margin-right: 5px'], $secure = null)}}

            </div>
        </div>
    </section>
</section>
<br><br>
</body>
