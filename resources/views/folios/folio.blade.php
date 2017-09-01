@extends('../layouts.app')

@section('titleSection', 'Buscar folio')

@section('content')
@if($campana[0] == '1')
<div class="panel chevrolet">
@else<div class="panel">
@endif
  <div class="panel-heading">
    @if(isset($imagen_logo) and !empty($imagen_logo))
           <img src="{{$imagen_logo[0]}}" class="img-responsive">
    @endif
    @if(isset($imagen_head) and !empty($imagen_head))
           <img src="{{$imagen_head[0]}}" class="img-responsive">
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
    @if (Session::has('folio_invalido'))
        <div class="alert alert-danger">{{ Session::get('folio_invalido') }}</div>
    @endif
    @if (Session::has('folio_valido'))
        <div class="alert alert-success">{{ Session::get('folio_valido') }}</div>
    @endif
    @if (Session::has('folioRedimido'))
        <div class="alert alert-info">{{ Session::get('folioRedimido') }}</div>
    @endif
    <div class="contenido col-md-12">
      <div class="titulo">
        @if(isset($titulo) && count($titulo) > 0)
          <h3><b><i>{{!!$titulo!!}}</i></b></h3>
        @endif
      </div>
      <div class="formulario">
        <p>
          Ingrese el n&uacute;mero de folio del certificado para hacer válido el bono de lealtad.
        </p>
      
   {!! Form::open(['post' => 'Folio_Controller@buscar_folio', 'url' => 'buscar_folio']) !!}
       {!! Form::token(); !!}
       @if(isset($campana) and !empty($campana))
            <input type="hidden" name="id_campana" value="{{$campana[0]}}">
           @endif
       <div>{!! Form::label('vinLabel', 'Folio:'); !!}</div>
       <div>{!! Form::Text('folio',$value = null, ['class' => 'form-control', 'placeholder' => 'Ingresa Folio']); !!}</div>
       @if(isset($brand) && count($brand) > 0)
       @endif
       <div class="btn-folio">{!! Form::submit('VALIDAR') !!}</div>
       <div>Para cualquier duda o aclaración, favor de comunicarse al 01 800 733 0288 de lunes a viernes de 9 am a 6 pm.</div>
   {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@endsection