@extends('../layouts.app')

@section('titleSection', 'bono-def')

@section('content')
<div class="panel ">
  <div class="panel-heading">
    @if(isset($imagenes) and !empty($imagenes))
      @for ($i = 1; $i <= count($imagenes); $i++)
           <img src="/images/{{$imagenes[$i]}}" class="img-responsive">
      @endfor
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
    @if (Session::has('bonoValidado'))
        <div class="alert alert-info">{{ Session::get('bonoValidado') }}</div>
    @endif
    <div class="contenido col-md-12">
      <div class="titulo">
        <h3>
          <b>
            <i>
              @if(isset($titulo) and !empty($titulo))
                @for ($i = 1; $i <= count($titulo); $i++)
                    The current value is {{ $titulo[$i]}}
                @endfor
              @endif
            </i>
          </b>
        </h3>
      </div>
      <div class="formulario">
        <p>
          @if(isset($description) and !empty($description))
                @for ($i = 1; $i <= count($description); $i++)
                    The current value is {{ $description[$i]}}
                @endfor
              @endif
        </p>
      
        {!! Form::open(['post' => 'Descarga_Controller@descarga_bono', 'url' => 'descarga_bono']) !!}
           {!! Form::token(); !!}
           <div>{!! Form::label('vinLabel', 'VIN:'); !!}</div>
           <div>{!! Form::Text('vin', $value = null, ['class' => 'form-control', 'placeholder' => 'Ingresa VIN']); !!}</div>
           <br>
           <a href="terminos_def" target="_blank">Acepto términos y condiciones</a> 
           {!! Form::checkbox('terminos'); !!}
           <input type="hidden" name="brand" value="{{$campana[0]}}">
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
