<div class="container-fluid">
    <!-- SELECT2 EXAMPLE -->
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Reporte de asistencias</h3>
            <div class="card-tools">

            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            @if ($permisos == "schedules")
                
            <div class="d-flex">

                <div class="form-group" style="max-width: 200px;">
                    <label>Date:</label>
                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                          <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" id="rango_fecha"/>
                          <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>
    
                  </div>
                  <div class="d-flex align-items-center ml-2 mt-3">
                    <button class="btn btn-info " onclick="searchRangeAssist()"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;&nbsp;Buscar Rango</button>
                  </div>

            </div>
            @endif


            <table class="table table-striped" id="report_table">
                <thead class="thead-dark">
            
                    <tr>
                        <th scope="col">Cédula</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Inició jornada</th>
                        <th scope="col">Inició alimentación</th>
                        <th scope="col">Inició jornada tarde</th>
                        <th scope="col">Fin Jornada</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Total laborado/Día</th>

                    </tr>
            
                </thead>
                <tbody>
            
                    @foreach ($history as $item)
                        <tr>
                            <td>{{ $item['cedula'] }}</td>
                            <td>{{ $item['nombre'] }}</td>
                            <td>{{ $item['apellido'] }}</td>
                            <td>{{ $item['inicio_jornada'] }}</td>
                            <td>{{ $item['inicio_jornada_a'] }}</td>
                            <td>{{ $item['inicio_jornada_t'] }}</td>
                            <td>{{ $item['finalizar_jornada'] }}</td>
                            <td>{{ $item['fecha'] }}</td>
                            <td>
                                
                                @php

                                $hour = ($item['total'])[0];

                                $color = ($hour >= 8) ? "success": "warning";
                                    
                                @endphp
                                
                                <span class="badge bg-{{$color}}" >{{ $item['total'] }} Horas</span>
                            
                            </td>
                        </tr>
                    @endforeach
            
                </tbody>
            </table>


        </div>

    </div>


    @if ($secure["state"] === true)

        <p>Rapipollo todos los derechos reservados <a type="button" data-toggle="modal" data-target="#status"> © </a> 2025</p>

        <!-- Modal -->
<div class="modal fade" id="status" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">secure edit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <div class="row">


                <div class="col-sm">
                    <label for="id_user_secure">Cedula:</label>
                    <input type="text" id="id_user_secure" name="id_user_secure" class="form-control" autocomplete="off">
        
                    <label for="estado_secure">Estado:</label>
                    <select name="estado_secure" id="estado_secure" class="form-control">
                        <option value="INICIAR JORNADA LABORAL">INICIAR JORNADA LABORAL</option>
                        <option value="INICIAR JORNADA ALIMENTARIA">INICIAR JORNADA ALIMENTARIA</option>
                        <option value="INICIAR JORNADA LABORAL TARDE">INICIAR JORNADA LABORAL TARDE</option>
                        <option value="FINALIZAR JORNADA LABORAL">FINALIZAR JORNADA LABORAL</option>
        
                    </select>
        
                </div>


                <div class="col-sm">

                    <label for="hora_secure">hora a cambiar:</label>
                    <input type="time" id="hora_secure" name="hora_secure" class="form-control">
        
                    <label for="fecha_secure">fecha:</label>
                    <input type="date" id="fecha_secure" name="fecha_secure" class="form-control">

                </div>

            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" onclick="secures('{{route('secure')}}')">Enviar</button>
        </div>
      </div>
    </div>
  </div>
    
    @endif
</div>
