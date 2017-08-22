@extends('layouts.multibono')
@section('title_section', 'Modelos')
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
	{!! Form::open(['post' => 'ModeloController@crear_modelo', 'url' => 'crear_modelo']) !!}
    {!! Form::token(); !!}
    <div>{!! Form::label('modelo_label', 'Nuevo modelo'); !!}</div>
    <div>{!! Form::Text('modelo'); !!}</div><br>         
    <div>{!! Form::submit('Guardar nuevo modelo') !!}</div>
    {!! Form::close() !!}<br><br>
    @if(isset($modelos))
    	<table border="1"><tr><th>Modelos</th></tr>
    	@foreach ($modelos as $modelo)
			<tr><td>{{$modelo->modelo}}</td></tr>
		@endforeach
		</table>
    @endif
@endsection