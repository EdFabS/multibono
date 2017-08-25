@extends('../layouts.app')

@section('titleSection', 'Buscar folio')

@section('content')
<div class="panel ">
  <div class="panel-heading">
      <img src="{{asset('images/Landing_Dealer_2_02.png')}}" class="img-responsive">
      @if(isset($brand) && count($brand) > 0 && $brand == 'cavalier')
        <img src="{{asset('images/Bono_Cavalier_VIN_02.png')}}" class="img-responsive">
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
    @if (Session::has('folioRedimido'))
        <div class="alert alert-info">{{ Session::get('folioRedimido') }}</div>
    @endif
    <div class="contenido col-md-12">
      <div class="titulo">
        @if(isset($brand) && count($brand) > 0 && $brand == 'gmfequinox')
          <h3><b><i>BONO DE LEALTAD CAVALIER</i></b></h3>
        @endif
      </div>
      <div class="formulario">
        <p>
          Ingrese el n&uacute;mero de folio del certificado para hacer válido el bono de lealtad.
        </p>
      
   {!! Form::open(['post' => 'Folio_Controller@buscar_folio', 'url' => 'buscar_folio']) !!}
       {!! Form::token(); !!}
       <div>{!! Form::label('vinLabel', 'Folio:'); !!}</div>
       <div>{!! Form::Text('folio',$value = null, ['class' => 'form-control', 'placeholder' => 'Ingresa Folio']); !!}</div>
       @if(isset($brand) && count($brand) > 0)
       @endif
       <div class="btn-folio">{!! Form::submit('VALIDAR') !!}</div>
       <div>Para cualquier duda o aclaración, favor de comunicarce al 01 800 733 0288 de lunes a viernes de 9 am a 6 pm.</div>
   {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@endsection