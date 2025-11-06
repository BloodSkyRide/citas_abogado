<div class="container-fluid">

    @if ($permisos === 'hotel')
        <div class="form-group d-flex">
            <div>

                <label>Fecha:</label>
                <div class="input-group date" data-target-input="nearest">
                    <input type="date" class="form-control" data-target="#reservationdate" id="fecha_rango">
                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>

                    <button onclick="getForRangeGuests('{{ route('serachForRangeGuest') }}')"
                        class="btn btn-primary ml-2" style=""><i
                            class="fa-regular fa-calendar-days"></i>&nbsp;&nbsp;Buscar alquiler por
                        fecha</button>
                </div>
            </div>
        </div>
    @endif

    <div class="col-sm-12">
        <div class="card card-primary card-tabs" style="width: 100%">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                            href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                            aria-selected="true"><i class="fa-solid fa-bell-concierge"></i>&nbsp;&nbsp;Alquilar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                            href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                            aria-selected="false"><i class="fa-solid fa-bed"></i>&nbsp;&nbsp;Huespedes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-reservation" data-toggle="pill"
                            href="#reservation" role="tab" aria-controls="custom-tabs-one-profile"
                            aria-selected="false"><i class="fa-solid fa-passport"></i>&nbsp;&nbsp;Reservaciones</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel"
                        aria-labelledby="custom-tabs-one-home-tab">

                        <div class="form-group">


                            <div class="row">
                                {{-- COLUMNA 1 --}}

                                <div class="col">
                                    <div class="form-group">
                                        <label for="nombre_producto">Nombre Huesped:</label>
                                        <input type="text" class="form-control" id="nombre_huesped"
                                            placeholder="nombre huesped..." autocomplete="off" name="nombre">
                                    </div>
                                    <div class="form-group">
                                        <label for="precio_producto">Apellido huesped:</label>
                                        <input type="text" class="form-control" id="apellido_huesped"
                                            placeholder="apellido huesped..." autocomplete="off"
                                            name="apellido huesped...">
                                    </div>

                                    <div class="form-group">
                                        <label for="imagen_product">Fecha de nacimiento:</label>
                                        <input type="date" class="form-control" id="date" name="date"
                                            autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label for="select_item">Tipo Identificación:</label>
                                        <select class="form-control select2 select2-danger"
                                            data-dropdown-css-class="select2-danger" style="width: 100%;"
                                            id="type_document">
                                            <option selected="selected" value="selected">Seleccionar item
                                            </option>
                                            <option value="C.C">C.C</option>
                                            <option value="C.E">Cedula Extranjeria</option>
                                            <option value="T.I">Tarjeta Identidad</option>
                                            <option value="R.C">Tarjeta Identidad</option>
                                            <option value="P.A">Pasaporte</option>
                                        </select>

                                    </div>

                                    <div class="form-group">
                                        <label for="imagen_product">Cédula o documento:</label>
                                        <input type="number" class="form-control" id="documento" name="documento"
                                            placeholder="Documento de identidad..." autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label for="imagen_product">Correo electrónico:</label>
                                        <input type="email" class="form-control" id="correo" name="documento"
                                            placeholder="Correo electronico..." autocomplete="off">
                                    </div>




                                </div>

                                {{-- COLUMNA 2 --}}
                                <div class="col">

                                    <div class="row">

                                        <div class="col-md-9">

                                            <div class="form-group">
                                                <label for="nombre_producto"># Acompañantes:</label>
                                                <input type="number" class="form-control" id="number_companions"
                                                    placeholder="Numero de acompañantes..." autocomplete="off"
                                                    name="nombre">
                                            </div>

                                            <div class="form-group">
                                                <label for="imagen">Origien:</label>
                                                <input type="email" class="form-control" id="origen"
                                                    name="origien" autocomplete="off"
                                                    placeholder="origen del huesped...">
                                            </div>
                                            <div class="form-group">
                                                <label for="imagen">Destino:</label>
                                                <input type="email" class="form-control" id="destino"
                                                    name="destino" autocomplete="off"
                                                    placeholder="destino del huesped...">
                                            </div>


                                            <div class="form-group">
                                                <label for="select_item">Estado civil:</label>
                                                <select class="form-control select2 select2-danger"
                                                    data-dropdown-css-class="select2-danger" style="width: 100%;"
                                                    id="select_item_state">
                                                    <option selected="selected" value="selected">Seleccionar item
                                                    </option>
                                                    <option value="soltero">Solter@</option>
                                                    <option value="Casado">Casad@</option>
                                                    <option value="Viudo">Viud@</option>
                                                    <option value="Divorciado">Divorsiad@</option>
                                                    <option value="Union libre">Union libre</option>
                                                    <option value="Union libre">No Aplica</optison>
                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label for="contacto">Número de contacto:</label>
                                                <input type="text" class="form-control" id="contacto"
                                                    name="contacto" autocomplete="off"
                                                    placeholder="numero de contacto">
                                            </div>

                                            <div class="form-group">
                                                <label for="select_item">Habitación Asignada:</label>
                                                <select class="form-control select2 select2-danger"
                                                    data-dropdown-css-class="select2-danger" style="width: 100%;"
                                                    id="room">
                                                    <option selected="selected" value="selected">Seleccionar
                                                        habitación</option>
                                                    <option value="201">201 PAREJA TINA</option>
                                                    <option value="202">202 PAREJA SENCILLA</option>
                                                    <option value="203">203 PAREJA SENCILLA</option>
                                                    <option value="204">204 PAREJA SENCILLA</option>
                                                    <option value="205">205 PAREJA SENCILLA</option>
                                                    <option value="206">206 TRIPLE SENCILLA</option>
                                                    <option value="207">207 TRIPLE SENCILLA</option>
                                                    <option value="208">208 PAREJA TINA</option>
                                                    <option value="209">209 FAMILIAR SENCILLA</option>
                                                    <option value="camping">CAMPING LIBRE</option>
                                                </select>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <center> <button class="btn btn-primary" onclick="addGuest()"><i
                                        class="fa-solid fa-circle-user"></i>&nbsp;&nbsp;Añadir Huesped</button>
                            </center>
                            <div class="col-md">

                                <div class="table-responsive mt-3">

                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Apellido</th>
                                                <th scope="col">Nacimiento</th>
                                                <th scope="col">Tipo Documento</th>
                                                <th scope="col"># Documento</th>
                                                <th scope="col"># Acompañantes</th>
                                                <th scope="col">E-mail</th>
                                                <th scope="col">Origen</th>
                                                <th scope="col">Destino</th>
                                                <th scope="col">Estado civil</th>
                                                <th scope="col">Celular</th>
                                                <th scope="col">Habitación</th>
                                                <th scope="col">Deshacer</th>
                                            </tr>
                                        </thead>
                                        <tbody id="container_tr"></tbody>
                                    </table>
                                    <hr>
                                    <div class="p-5 d-flex">
                                        <div class="d-flex align-items-center"><label for="costo">Precio
                                                alquiler:&nbsp;&nbsp;</label></div><br><i
                                            class="fa-solid fa-dollar-sign text-success mr-2"
                                            style="font-size: 30px"></i> <input id="costo"
                                            class="form-control w-25" type="number"
                                            placeholder="Alquiler de la habitación">
                                        <div class="ml-3">
                                            <select name="estado" id="estado" class="form-control">
                                                <option selected value="selected">Seleccionar Estadía</option>
                                                <option value="noche">Noche</option>
                                                <option value="rato">Rato</option>
                                            </select>
                                        </div>
                                        <div class="ml-3"><button
                                                onclick="registerGuest('{{ route('sendregister') }}')"
                                                class="btn btn-success"><i
                                                    class="fa-solid fa-hotel"></i>&nbsp;&nbsp;Alquilar
                                                Habitación</button></div>
                                    </div>

                                </div>

                                <div class="row p-5">

                                    <div class="col-sm">
                                        <h3>Total Hospedaje:</h3>
                                    </div>
                                    <div class="col-sm d-flex justify-content-end">
                                        <h3><i
                                                class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($total, 0, '', '.') }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                        aria-labelledby="custom-tabs-one-profile-reservation">

                        <div class="table-responsive">

                            <table class="table" id="table_guests">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Apellido</th>
                                        <th scope="col">Nacimiento</th>
                                        <th scope="col">Cédula</th>
                                        <th scope="col">E-mail</th>
                                        <th scope="col">Origen</th>
                                        <th scope="col">Destino</th>
                                        <th scope="col">Estado civil</th>
                                        <th scope="col">Celular</th>
                                        <th scope="col">Hora ingreso</th>
                                        <th scope="col">Habitación</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Estadia</th>
                                        <th scope="col">Venta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($guests as $item)
                                        <tr>
                                            <td>{{ $item['nombre_huesped'] }}</td>
                                            <td>{{ $item['apellido_huesped'] }}</td>
                                            <td>{{ $item['nacimiento'] }}</td>
                                            <td>{{ $item['cedula_huesped'] }}</td>
                                            <td>{{ $item['email'] }}</td>
                                            <td>{{ $item['origen'] }}</td>
                                            <td>{{ $item['destino'] }}</td>
                                            <td>{{ $item['estado_civil'] }}</td>
                                            <td>{{ $item['celular'] }}</td>
                                            <td>{{ $item['hora'] }}</td>
                                            <td>{{ $item['habitacion'] }}</td>
                                            <td>{{ $item['fecha'] }}</td>
                                            <td>{{ $item['estadia'] }}</td>
                                            <td><i
                                                    class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($item['total_venta'], 0, '', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>

                        <div class="row p-5">

                            <div class="col-sm">
                                <h3>Total Hospedaje:</h3>
                            </div>
                            <div class="col-sm d-flex justify-content-end">
                                <h3><i
                                        class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($total, 0, '', '.') }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="reservation" role="tabpanel"
                        aria-labelledby="custom-tabs-one-profile-reservation">

                        <div class="form-group">


                            <div class="row">
                                {{-- COLUMNA 1 --}}

                                <div class="col">
                                    <div class="form-group">
                                        <label for="nombre_producto">Titular reservacion:</label>
                                        <input type="text" class="form-control" id="titular_reserva"
                                            placeholder="nombre huesped..." autocomplete="off"
                                            name="titular_reserva">
                                    </div>
                                    <div class="form-group">
                                        <label for="precio_producto">Telefono/whatsapp:</label>
                                        <input type="text" class="form-control" id="telefono"
                                            placeholder="chat del que fue atendido." autocomplete="off"
                                            name="telefono">
                                    </div>

                                    <div class="form-group">
                                        <label for="imagen_product">Fecha de reservacion:</label>
                                        <input type="date" class="form-control" id="date_reservation"
                                            name="date" autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label for="documento_cedula">Cédula o documento:</label>
                                        <input type="number" class="form-control" id="documento_cedula"
                                            name="documento" placeholder="Documento de identidad..."
                                            autocomplete="off">
                                    </div>


                                    <div class="form-group">
                                        <label for="">Monto que abona el cliente:</label>
                                        <div class="d-flex">
                                            <i class="fa-solid fa-dollar-sign text-success mr-2"
                                                style="font-size: 30px"></i>
                                            <input type="number" class="form-control" id="monto_reserva"
                                                placeholder="Abono de la reservación..." autocomplete="off"
                                                name="habitacion_reserva">
                                        </div>

                                    </div>
                                </div>

                                {{-- COLUMNA 2 --}}
                                <div class="col">

                                    <div class="row">

                                        <div class="col-md-9">

                                            <div class="form-group">
                                                <label for="select_medio_pago">Medio de pago:</label>
                                                <select class="form-control select2 select2-danger"
                                                    data-dropdown-css-class="select2-danger" style="width: 100%;"
                                                    id="select_medio_pago">
                                                    <option selected="selected" value="selected">Seleccionar medio de
                                                        pago</option>
                                                    <option value="efectivo">Efectivo</option>
                                                    <option value="transferencia">Transferencia</option>
                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label for="contacto_numero">Número de contacto:</label>
                                                <input type="text" class="form-control" id="contacto_numero"
                                                    name="contacto" autocomplete="off"
                                                    placeholder="numero de contacto">
                                            </div>

                                            <div class="form-group">
                                                <label for="number_huespedes">Número de huespedes:</label>
                                                <input type="number" class="form-control" id="number_huespedes"
                                                    name="contacto" autocomplete="off"
                                                    placeholder="Numero de personas">
                                            </div>
                                            <div class="form-group">
                                                <label for="description_reservation">Descripción Reserva:</label>
                                                <textarea class="form-control" id="description_reservation" rows=1" placeholder="Descripción de la reserva..."></textarea>

                                            </div>

                                            <div class="form-group">
                                                <label for="valor_total">Valor Total Reserva:</label>

                                                <div class="d-flex">
                                                    <i class="fa-solid fa-dollar-sign text-success mr-2"
                                                        style="font-size: 30px"></i>
                                                    <input type="number" class="form-control" id="valor_total"
                                                        name="contacto"
                                                        autocomplete="off"placeholder="valor total reserva...">

                                                </div>

                                            </div>

                                        </div>




                                    </div>

                                </div>

                            </div>

                            <center class="mb-2">

                                <div class="form-group">
                                    <label for="valor_total">Adjuntar comprobante:</label>
                                    <input type="file" class="form-control w-50" id="comprobante" name="contacto" placeholder="Subir comprobante">


                                </div>


                            </center>


                            <center>
                                <button class="btn btn-primary"
                                    onclick="makeReservation('{{ route('reservation') }}')"><i
                                        class="fa-solid fa-paper-plane"></i>&nbsp;&nbsp;Realizar Reservación</button>
                            </center>
                            <div class="d-flex mt-2">
                                <input type="text" class="form-control" id="search_reservation" name="contacto"
                                    style="width: 50%" autocomplete="off"
                                    placeholder="verificar codigo de reserva...">
                                <button class="btn btn-primary ml-2"
                                    onclick="searchReservation('{{ route('searchReservation') }}')"><i
                                        class="fa-solid fa-magnifying-glass"></i>&nbsp;&nbsp;Buscar
                                    codigo</button>
                            </div>


                            <div class="col-md">

                                <div class="table-responsive mt-3">

                                    <table class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Titular</th>
                                                <th scope="col">Cedula</th>
                                                <th scope="col">Abono Reservado</th>
                                                <th scope="col">Adeuda</th>
                                                <th scope="col">Medio de pago</th>
                                                <th scope="col"># Huespedes</th>
                                                <th scope="col">Descripción</th>
                                                <th scope="col">Total Reserva</th>
                                                <th scope="col">Fecha Reserva</th>
                                                <th scope="col">Fecha Ingreso</th>
                                                <th scope="col">Contacto</th>
                                                <th scope="col">Estado Reserva</th>
                                                <th scope="col">Código de Reserva</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($reservations as $item)
                                                <tr>
                                                    <td>{{ $item['titular'] }}</td>
                                                    <td>{{ $item['cedula'] }}</td>
                                                    <td><span
                                                            class="badge badge-warning">{{ $item['monto_reservado'] }}</span>
                                                    </td>
                                                    <td><span
                                                            class="badge badge-warning">{{ $item['monto_adeudado'] }}</span>
                                                    </td>
                                                    <td>{{ $item['medio_pago'] }}</td>
                                                    <td>{{ $item['numero_huespedes'] }}</td>
                                                    <td>{{ $item['descripcion_reserva'] }}</td>
                                                    <td>{{ $item['valor_paquete'] }}</td>
                                                    <td>{{ $item['fecha_reservacion'] }}</td>
                                                    <td>{{ $item['fecha'] }}</td>
                                                    <td>{{ $item['contacto'] }}</td>
                                                    @php
                                                        $estado =
                                                            $item['estado'] == 'RESERVADO'
                                                                ? 'badge badge-success'
                                                                : 'badge badge-danger';
                                                    @endphp
                                                    <td><span
                                                            class="{{ $estado }}">{{ $item['estado'] }}</span>
                                                    </td>
                                                    <td>
                                                        <a type="button"
                                                            onclick="redmeeCode('{{ route('redeemCode') }}','{{ $item['id_reservacion'] }}')"><span
                                                                class="badge badge-primary">{{ $item['id_reserva_unit'] }}</span></a>
                                                    </td>

                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

</div>


<!-- Modal -->
<div class="modal fade" id="reservationInformation" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="exampleModalLabel">Datos Reservación</h5>
                <button type="button" class="close" data-dismiss="modal" onclick="closeModalInformation()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    onclick="closeModalInformation()">Cerrar</button>
            </div>
        </div>
    </div>
</div>
