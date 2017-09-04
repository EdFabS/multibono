@extends('../layouts.multibono')
@section('title_section', 'Carga de VIN')

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
  @if (Session::has('registro_repetido'))
      <div class="alert alert-danger">{{ Session::get('registro_repetido') }}</div>
  @endif
  @if (Session::has('registro_guardado'))
        <div class="alert alert-success">{{ Session::get('registro_guardado') }}</div>
    @endif
  {!! Form::open(['post' => 'VinController@addVin', 'url' => 'addVin']) !!}
     {!! Form::token(); !!}
     {!! Form::label('vin', 'VIN'); !!}
     {!! Form::text('vin'); !!}
    <select name="id_campana">
    @if(isset($campanas))
      @foreach ($campanas as $campana)
        <option value="{{$campana['id']}}">{{$campana['campana']}}</option>
      @endforeach
    @endif
    </select>
     {!! Form::submit('Guardar') !!}
  {!! Form::close() !!}
@endsection
