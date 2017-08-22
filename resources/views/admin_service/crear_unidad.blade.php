@extends('layouts.multibono')
@section('title_section', 'Unidades de Negocio')
@section('content')
	@if(count($errors) > 0)
        <div>
            <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif
    @if (Session::has('registro_guardado'))
        <div class="alert alert-info">{{ Session::get('registro_guardado') }}</div>
    @endif
	{!! Form::open(['post' => 'UnidadesController@crear_unidad', 'url' => 'crear_unidad']) !!}
    {!! Form::token(); !!}
    <div>{!! Form::label('unidad', 'Nueva unidad de negocio'); !!}</div>
    <div>{!! Form::Text('unidad'); !!}</div><br>         
    <div>{!! Form::submit('Guardar nueva unidad') !!}</div>
    {!! Form::close() !!}<br><br>
    @if(isset($unidades))
    	<table border="1"><tr><th>Unidad de negocio</th></tr>
    	@foreach ($unidades as $unidad)
			<tr><td>{{$unidad->unidad}}</td></tr>
		@endforeach
		</table>
    @endif
@endsection