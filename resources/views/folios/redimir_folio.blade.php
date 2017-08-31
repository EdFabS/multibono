@extends('../layouts.app')

@section('titleSection', 'Redimir Folio')

@section('content')
<div class="panel ">
  <div class="panel-heading">
    @if(isset($campana) and !empty($campana))
      <img src="{{$campana['logo']}}" class="img-responsive">
      <img src="{{$campana['head']}}" class="img-responsive">
    @endif
  </div>

  <div class="panel-body">
  @if(count($errors) > 0)
      <div>
          <ul>
          @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
          </ul>
      </div>
  @endif
   @if (Session::has('folio_valido'))
      <div class="alert alert-info">{{ Session::get('folio_valido') }}</div>
  @endif
  <div class="contenido col-md-12">
      <div class="titulo">
        @if(isset($campana) && count($campana) > 0)
          <h3><b><i>{!!$campana['titulo']!!}</i></b></h3>
        @endif
        
      </div>
      <div class="formulario">
        @if (isset($folio) and count($folio) > 0)
          <p>El Folio: <b>{{$folio->folio}}</b> es válido, por lo que el bono de lealtad puede ser otorgado.</p>
        @endif
        <div><a href="/folio/{!!$campana['campana']!!}"> <button>NUEVA CONSULTA</button></a></div>
        <p>Si desea redimir el certificado en este momento, favor de capturar los siguientes datos:</p>
        {!! Form::open(['post' => 'Folio_Controller@redimir', 'url' => 'redimir']) !!}
          {!! Form::token(); !!}
          
            <div>{!! Form::label('nombreFacturaLabel', 'Nombre a quien se va a facturar:'); !!}</div>
            {!! Form::Text('fullname'); !!}
          
          <div>
            <div>{!! Form::label('parenteescoLabel', 'Parentesco con el titular:'); !!}</div>
            {!! Form::select('parentesco', array('' => 'Selecciona una opción', 'padres' => 'Padres', 'hermanos' => 'Hermanos', 'espos@' => 'Esposo (a)', 'abuelos' => 'Abuelos', 'ti@' => 'Tio (a)', 'sobrin@' => 'Sobrino (a)', 'ninguna' => 'Ninguna', 'otra' => 'Otra')); !!}
          </div>
          <div>
            <div class="half">
              <div>{!! Form::label('distribuidorLabel', 'Distribuidor:'); !!}</div>
              <div>
                <select name="distribuidor">
                @if(isset($dealers) && count($dealers) > 0)
                    <option value="">Selecciona una opción</option>
                  @foreach ($dealers as $dealer)
                    <option value="{{$dealer->id}}">{!!$dealer->dealer!!}</option>
                  @endforeach
                @endif
                </select>
              </div>
              @if(isset($campana))
                <input type="hidden" name="id_campana" value="{!!$campana['id_campana']!!}">
              @endif
            </div>
            <div class="half">
              <div>{!! Form::label('vendedorLabel', 'Nombre del vendedor:'); !!}</div>
              <div>{!! Form::Text('salesman'); !!}</div>
            </div>
             @if(isset($folio) && count($folio) > 0)          
            <input type="hidden" name="id_folio" value="{{$folio->id}}">
            @endif
          </div><br>
          <div >
          @if(isset($modelos_vins) && count($modelos_vins) > 0)
            @foreach ($modelos_vins as $mod_vin)
              <label> VIN {!!$mod_vin->modelo!!}</label>
              <input type="text" name="new_vin[{{$mod_vin->id}}][vin]" value="">
            @endforeach
          @endif
          </div><br>
          <div>
            {!! Form::submit('REDIMIR CERTIFICADO') !!}
        {!! Form::close() !!}
        <div>Para cualquier duda o aclaración, favor de comunicarse al 01 800 733 0288 de lunes a viernes de 9 am a 6 pm.</div>
      </div>
    </div>
  </div>
</div>
@endsection