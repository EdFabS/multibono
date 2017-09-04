@extends('../layouts.multibono')
@section('title_section', 'Carga de varios VINS')
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
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif
    @if (Session::has('archivoProcesado'))
        <div class="alert alert-info">{{ Session::get('archivoProcesado') }}</div>
    @endif
     @if (Session::has('registros_guardados'))
        <div class="alert alert-success">{{ Session::get('registros_guardados') }}</div>
    @endif
   {!! Form::open(['post' => 'Vins_Controller@addVins', 'url' => 'addVins', 'files'=>true]) !!}
       {!! Form::token(); !!}
       {!! Form::label('dbVins', 'DB de VINS'); !!}
       {!! Form::file('file'); !!}
        <select name="id_campana">
          @if(isset($campanas))
            @foreach ($campanas as $campana)
              <option value="{{$campana['id']}}">{{$campana['campana']}}</option>
            @endforeach
          @endif
        </select>
       {!! Form::submit('Guardar') !!}
   {!! Form::close() !!}
   @if (isset($guardados) and count($guardados) > 0)
        <div>
            <table>
                <tr>
                    <th>Vins gurdados</th>
                </tr>
                @foreach ($guardados as $vin_guardado)
                    <tr>
                        <td>{{$vin_guardado}}</td>                                    
                    </tr>
                @endforeach
            </table>
        </div>
   @endif
   @if (isset($repetidos) and count($repetidos) > 0)
        <div>
            <table>
                <tr>
                    <th>Vins repetidos (no guardados)</th>
                </tr>
                @foreach ($repetidos as $vin)
                    <tr>
                        <td>{{$vin}}</td>                                    
                    </tr>
                @endforeach
            </table>
        </div>
   @endif
@endsection