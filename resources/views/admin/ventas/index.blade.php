@extends('template.main')
@section('title', 'Admin | Listado de Ventas')
@section('content')

    {!! Form::open(['route'=>'ventas.index', 'method'=>'GET', 'class'=>'form-inline']) !!}
    <div class="form-group">
            {!! Form::date('fechaInicio', \Carbon\Carbon::yesterday(), ['class'=>'form-control']) !!}
            {!! Form::date('fechaFin', \Carbon\Carbon::tomorrow(), ['class'=>'form-control']) !!}
            {!! Form::submit('Buscar Venta', ['class'=>'btn btn-primary'])!!}
    </div>
        <a href="{{route('ventas.pdfAll')}}" class="btn pull-right"><span class="glyphicon glyphicon-download"></span>  Descargar</a>
    {!! Form::close() !!}

    <div class="page-header clearfix"></div>

    @if (count($ventas) > 0)
        <table class='table table-bordered table-striped'>
            <thead>
                <th>ID</th>
                <th>Código</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <th class="text-center">Importe</th>
                <th class="text-center">Acción</th>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    <tr>
                        <td>{{$venta->id}}</td>
                        <td>{{$venta->codigo}}</td>
                        <td>{{DateTime::createFromFormat('Y-m-d H:i:s', $venta->fecha)->format('d/m/Y')}}</td>
                        <td>{{$venta->name}}</td>
                        <td class="text-center">{{$venta->total}} €</td>
                        <td class="text-center">
                            {!! Form::open(['method' => 'DELETE', 'route' => ['ventas.destroy', $venta->id]]) !!}
                                <a class='btn btn-info' href='{{route('ventas.show', $venta->id)}}' title='Ver Venta' data-toggle='tooltip'><span class='glyphicon glyphicon-search'></span></a>
                                <a class='btn btn-warning' href='{{route('ventas.pdf', $venta->id)}}' title='Descargar Factura' data-toggle='tooltip'><span class='glyphicon glyphicon-file'></span></a>
                                <button class="btn btn-danger" type="submit" title='Borar Venta' data-toggle='tooltip'
                                    onclick="return confirm('¿Seguro que desea borrar esta venta?')">
                                    <span class='glyphicon glyphicon-trash'></span>
                                </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @else
        <p class='lead'><em>No se ha encontrado datos de ventas.</em></p>
    @endif

    <div class='text-center'>
            {!! $ventas->render()!!}
    </div>

@endsection

