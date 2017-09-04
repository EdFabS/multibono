@extends('../layouts.multibono')
@section('title_section', 'Reporte descargas')

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
  <!-- {!!Auth::user()->role!!} -->
  <div>
      @if(isset($campanas) and !empty($campanas))
        @foreach($campanas as $campana)
          <a class="btn btn-default navbar-btn" href="reporte_descargas/{!!$campana->id!!}">{!!$campana->campana!!}</a>
        @endforeach
      @endif
  </div>
@endsection
