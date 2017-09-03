@extends('../layouts.app')

@section('titleSection', $title[0])

@section('content')
@if($campana->id == '1')
<div class="panel chevrolet">
@else<div class="panel">
@endif
  <div class="panel-heading">
    @if(isset($campana->url_img_logo) and !empty($campana->url_img_logo))
           <img src="{{$campana->url_img_logo}}" class="img-responsive">
    @endif
    @if(isset($campana->url_img_head) and !empty($campana->url_img_head))
           <img src="{{$campana->url_img_head}}" class="img-responsive">
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
    @if (Session::has('vin_invalido'))
        <div class="alert alert-danger">{{ Session::get('vin_invalido') }}</div>
    @endif
    @if (Session::has('bonoValidado'))
        <div class="alert alert-info">{{ Session::get('bonoValidado') }}</div>
    @endif
    <div class="contenido col-md-12">
      <div class="titulo">
        <h3>
          <b>
              @if(isset($campana->titulo) and !empty($campana->titulo))
                    {!!$campana->titulo!!}
              @endif
          </b>
        </h3>
      </div>
      <div class="formulario">
        <p>
          @if(isset($campana->descripcion) and !empty($campana->descripcion))
                    {!!$campana->descripcion!!}
              @endif
        </p>
      
        {!! Form::open(['post' => 'Descarga_Controller@descarga_bono', 'url' => 'descarga_bono']) !!}
           {!! Form::token(); !!}
           <div>{!! Form::label('vinLabel', 'VIN:'); !!}</div>
           <div>{!! Form::Text('vin', $value = null, ['class' => 'form-control', 'placeholder' => 'Ingresa VIN']); !!}</div>
           <br>
           <a href="terminos_{!!$title[0]!!}" target="_blank">Acepto términos y condiciones</a> 
           {!! Form::checkbox('terminos'); !!}
           @if(isset($campana) and !empty($campana))
            <input type="hidden" name="id_campana" value="{{$campana->id}}">
           @endif
           <div>{!! Form::submit('DESCARGAR'); !!}</div>
           <p>&nbsp;</p>
           
           <p style="text-align: justify;">
             @if(isset($campana->legales) and !empty($campana->legales))
                {!!$campana->legales!!}
              @endif
           </p>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@endsection
