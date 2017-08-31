@extends('layouts.multibono')
@section('title_section', 'Campañas')
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
	{!! Form::open(['post' => 'CampanasController@crear_campana', 'url' => 'crear_campana', 'files'=>true]) !!}
    {!! Form::token(); !!}
    <div>{!! Form::label('label_campana', 'Nueva campaña'); !!}</div>
    <div>{!! Form::Text('campana'); !!}</div><br>
    <select name="id_unidad">
    	<option value="">Selecciona un valor</option>
		@foreach ($unidades as $unidad)
			<option value="{{$unidad->id}}">{{$unidad->unidad}}</option>
		@endforeach
	</select> <a href="{{ url('/unidades') }}">Unidades</a><br><br>
    <div><a href="{{ url('/modelos') }}"> Modelos</a></div>
    @foreach ($modelos as $modelo)
        {{$modelo->modelo}}
        <input type="checkbox" name="{{$modelo->id}}" value="{{$modelo->modelo}}">
    @endforeach
    <div><br>{!! Form::label('label_imagen_logo', 'Imagen logo'); !!}</div>
    <div>{!! Form::file('url_img_logo'); !!}</div>
    <div><br>{!! Form::label('label_imagen_head', 'Imagen head'); !!}</div>
    <div>{!! Form::file('url_img_head'); !!}</div>
    <div><br>{!! Form::label('titulo_label', 'Titulo'); !!}</div>
    <div>{!! Form::Text('titulo'); !!}</div>
    <div><br>{!! Form::label('label_descripcion', 'Descripcion'); !!}</div>
    <div>{!! Form::textarea('descripcion', null, ['size' => '90x4']) !!}</div>
    <div><br>{!! Form::label('label_legales', 'Legales'); !!}</div>
    <div>{!! Form::textarea('legales', null, ['size' => '90x7']) !!}</div>
    <div><br>{!! Form::submit('Guardar nueva campana') !!}</div>
    {!! Form::close() !!}<br><br>
    @if(isset($unidades))
    	<table border="1"><tr><th>Campaña</th><th>Unidad</th><th>Modelos</th></tr>
    	@foreach ($campanas as $campana)
			<tr><td>{{$campana->campana}}</td><td>{{$campana->unidad}}</td><td>{{$campana->modelos}}</td></tr>
		@endforeach
		</table>
    @endif
@endsection