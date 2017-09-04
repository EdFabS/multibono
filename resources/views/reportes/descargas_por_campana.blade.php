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
  @if(isset($descargados))
    <table class="table">
        <tr>
            <th>
               # 
            </th>
            <th>
                VIN
            </th>
            <th>
                Folio
            </th>
            <th>
                mail
            </th>
            <th>
                Descargas
            </th>
            <th>
                Ultima Descarga
            </th>
        </tr>
        @foreach($descargados as $descargado)
            <tr>
                <td>
                   {{$descargado->id}}
                </td>
                <td>
                    {{$descargado->vin}}
                </td>
                <td>
                    {{$descargado->folio}}
                </td>
                <td>
                    {{$descargado->mail}}
                </td>
                <td>
                    {{$descargado->descargas}}
                </td>
                <td>
                    {{$descargado->fecha}}
                </td>
            </tr>
        @endforeach
    </table>
    <div><a href="reporteDescargasExcel">Generar excel</a></div>
    @endif              

  </div>
@endsection
