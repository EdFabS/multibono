@extends('../layouts.app')

@section('titleSection', 'bono-def')

@section('content')
<div class="panel ">
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
            <i>
              @if(isset($titulo) and !empty($titulo))
                    {!!$titulo[0]!!}
              @endif
            </i>
          </b>
        </h3>
      </div>
      <div class="formulario">
        <p>
          @if(isset($description) and !empty($description))
                    {!!$description[0]!!}
              @endif
        </p>
      
        {!! Form::open(['post' => 'Descarga_Controller@descarga_bono', 'url' => 'descarga_bono']) !!}
           {!! Form::token(); !!}
           <div>{!! Form::label('vinLabel', 'VIN:'); !!}</div>
           <div>{!! Form::Text('vin', $value = null, ['class' => 'form-control', 'placeholder' => 'Ingresa VIN']); !!}</div>
           <br>
           <a href="terminos_def" target="_blank">Acepto términos y condiciones</a> 
           {!! Form::checkbox('terminos'); !!}
           @if(isset($campana) and !empty($campana))
            <input type="hidden" name="id_campana" value="{{$campana[0]}}">
           @endif
           <div>{!! Form::submit('DESCARGAR'); !!}</div>
           <p>&nbsp;</p>
           
           <p style="text-align: justify;">
             @if(isset($legales) and !empty($legales))
                {!! $legales[0]!!}                
              @endif
           </p>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@endsection
