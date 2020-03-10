@extends('template.main')
@section('title', 'Admin | Listado de Productos')
@section('content')

    {!! Form::open(['route'=>'productos.index', 'method'=>'GET', 'class'=>'form-inline']) !!}
    <div class="form-group">
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Marca o Modelo'])!!}
            {!! Form::submit('Buscar Producto', ['class'=>'btn btn-primary'])!!}
    </div>
        <a href="{{route('productos.pdfAll')}}" class="btn pull-right"><span class="glyphicon glyphicon-download"></span>  Descargar</a>
        {{link_to(route('productos.create'), $title = 'Añadir Producto', $attributes = ['class'=>'btn btn-success pull-right'], $secure = null)}}
    {!! Form::close() !!}

    <div class="page-header clearfix"></div>

    @if (count($productos) > 0)
        <table class='table table-bordered table-striped'>
            <thead>
                <th>ID</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Precio</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Stock</th>
                <th class="text-center">Imagen</th>
                <th class="text-center">Acción</th>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{$producto->id}}</td>
                        <td>{{$producto->marca}}</td>
                        <td>{{$producto->modelo}}</td>
                        <td>{{$producto->precio}}€</td>
                        <td class="text-center">
                            @if ($producto->tipo == 'juego')
                                <span class="label label-warning">Juego</span>
                            @else
                                <span class="label label-info">Consola</span>
                            @endif

                        </td>
                        <td class="text-center">
                            @if ($producto->stock == 0)
                                <span class="label label-danger">0</span>
                            @else
                                @if ($producto->stock <5 && $producto->stock>=1)
                                    <span class="label label-warning">{{$producto->stock}}</span>
                                @else
                                    <span class="label label-success">{{$producto->stock}}</span>
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                                @if ($producto->imagen == '')
                                    <img src='{{asset('recursos/sinportada.png')}}' class='avatar' alt='imagen' width='35' height='auto'>
                                @else
                                    <img src='{{asset($producto->imagen)}}' class='avatar' alt='imagen' width='35' height='auto'>
                                @endif

                        </td>
                        <td class="text-center">
                            {!! Form::open(['method' => 'DELETE', 'route' => ['productos.destroy', $producto->id]]) !!}
                                <a class='btn btn-info' href='{{route('productos.show', $producto->id)}}' title='Ver Producto' data-toggle='tooltip'><span class='glyphicon glyphicon-search'></span></a>
                                <a class='btn btn-warning' href='{{route('productos.edit', $producto->id)}}' title='Actualizar Producto' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>
                                <button class="btn btn-danger" type="submit" title='Borar Producto' data-toggle='tooltip'
                                    onclick="return confirm('¿Seguro que desea borrar a este producto?')">
                                    <span class='glyphicon glyphicon-trash'></span>
                                </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @else
        <p class='lead'><em>No se ha encontrado datos de productos.</em></p>
    @endif

    <div class='text-center'>
            {!! $productos->render()!!}
    </div>

@endsection

