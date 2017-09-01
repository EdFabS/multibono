@extends('../layouts.app')

@section('titleSection', 'Redimir Folio')

@section('content')
@if($campana['id_campana'] == '1')
<div class="panel chevrolet">
@else<div class="panel">
@endif
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
          {!!$campana['titulo']!!}
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
          <div>
            {!! Form::label('nombreFacturaLabel', 'Nombre a quien se va a facturar:'); !!}
          </div>
          <div>
            {!! Form::Text('fullname', $value =  null, ['class' => 'form-control', 'placeholder' => 'Nombre completo']); !!}
          </div>
          <div class="col-md-12">
            <div class="col-md-6">
              {!! Form::label('parenteescoLabel', 'Parentesco con el titular:'); !!}
              {!! Form::select('parentesco', array('' => 'Selecciona una opción', 'padres' => 'Padres', 'hermanos' => 'Hermanos', 'espos@' => 'Esposo (a)', 'abuelos' => 'Abuelos', 'ti@' => 'Tio (a)', 'sobrin@' => 'Sobrino (a)', 'ninguna' => 'Ninguna', 'otra' => 'Otra'), $selected = null, ['class' => 'form-control']); !!}
            </div>
            <div class="col-md-6">
              {!! Form::label('distribuidorLabel', 'Distribuidor:'); !!}
              <select name="distribuidor" class="form-control">
                @if(isset($dealers) && count($dealers) > 0)
                    <option value="">Selecciona una opción</option>
                  @foreach ($dealers as $dealer)
                    <option value="{{$dealer->id}}">{!!$dealer->dealer!!}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
          @if(isset($campana))
            <input type="hidden" name="id_campana" value="{!!$campana['id_campana']!!}">
          @endif
          @if(isset($folio) && count($folio) > 0)          
            <input type="hidden" name="id_folio" value="{{$folio->id}}">
          @endif
          <div>
            {!! Form::label('vendedorLabel', 'Nombre del vendedor:'); !!}
            {!! Form::Text('salesman', $value =  null, ['class' => 'form-control', 'placeholder' => 'Nombre completo']); !!}
          </div>
          <div class="col-md-6">
            @if(isset($modelos_vins) && count($modelos_vins) > 0)
              @foreach ($modelos_vins as $mod_vin)
                <label> VIN {!!$mod_vin->modelo!!}</label>
                <input type="text" class="form-control" name="new_vin[{{$mod_vin->id}}][vin]" value="">
              @endforeach
            @endif
          </div>
          <div class="col-md-12">
            {!! Form::submit('REDIMIR CERTIFICADO') !!}
          </div>
        {!! Form::close() !!}
      </div>
      <div class="col-md-12">
        Para cualquier duda o aclaración, favor de comunicarse al 01 800 733 0288 de lunes a viernes de 9 am a 6 pm.
      </div>
    </div>
  </div>
</div>
@endsection