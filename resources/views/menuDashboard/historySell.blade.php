<div class="d-flex justify-contente-center">

    @if ($permisos === 'history_sell' || $permisos === 'history_sell.full')
        <div class="form-group d-flex">
            <div>

                <label>Fecha:</label>
                <div class="input-group date" data-target-input="nearest">
                    <input type="date" class="form-control" data-target="#reservationdate" id="reservationdate">
                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>

                    <button onclick="searchRange('{{ route('searchForRangeHistory') }}')" class="btn btn-primary ml-2"
                        style=""><i class="fa-regular fa-calendar-days"></i>&nbsp;&nbsp;Buscar ventas por
                        fecha</button>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="col-sm-12">
    <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                <li class="pt-2 px-3">
                    <h3 class="card-title">Historiales de venta</h3>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill"
                        href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home"
                        aria-selected="true"><i class="fa-solid fa-list"></i>&nbsp;&nbsp;Historial ventas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill"
                        href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile"
                        aria-selected="false"><i class="fa-solid fa-list-ol"></i>&nbsp;&nbsp;Historial ventas
                        unificadas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill"
                        href="#custom-tabs-two-users" role="tab" aria-controls="custom-tabs-two-users"
                        aria-selected="false"><i class="fa-solid fa-user"></i>&nbsp;&nbsp;Ventas por usuarios</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-two-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel"
                    aria-labelledby="custom-tabs-two-home-tab">

                    <center>
                        <h4 class="text-secondary">Historial de ventas </h4>
                    </center>
                    <hr>
                    <div class="table-responsive">

                        <table class="table" id="history_sell_table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    @if ($permisos === 'history_sell.full')
                                        <th>Editar</th>
                                    @endif
                                    <th scope="col">Representación</th>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Descripción Producto</th>
                                    <th scope="col">Unidades</th>
                                    <th scope="col">Cajero Responsable</th>
                                    <th scope="col">Cédula</th>
                                    <th scope="col">Hora</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Total venta</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $flagg = 1;
                                @endphp

                                @foreach ($historial as $item)
                                    <tr>
                                        <th scope="row">{{ $flagg }}</th>
                                        @if ($permisos === 'history_sell.full')
                                            <td><button
                                                    onclick="changeModalHistorySell('{{ $item['nombre_producto_venta'] }}', '{{ $item['id_venta'] }}')"
                                                    class="btn btn-success"><i
                                                        class="fa-solid fa-pen-to-square"></i></button></td>
                                        @endif
                                        <td><img src="{{ $item['url_imagen'] }}"
                                                alt="Representación de {{ $item['nombre_producto_venta'] }}"
                                                width="40" height="40"></td>
                                        <td>{{ $item['nombre_producto_venta'] }}</td>
                                        <td>{{ $item['descripcion_producto_venta'] }}</td>
                                        <td>{{ $item['unidades_venta'] }}</td>
                                        <td>{{ $item['nombre_cajero'] }}</td>
                                        <td>{{ $item['id_user_cajero'] }}</td>
                                        <td>{{ $item['hora'] }}</td>
                                        <td>{{ $item['fecha'] }}</td>
                                        <td><i
                                                class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($item['total_venta'], 0, '', '.') }}
                                        </td>
                                    </tr>

                                    @php
                                        $flagg++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="row p-5">

                        <div class="col-sm">
                            <h3>Total venta:</h3>
                        </div>
                        <div class="col-sm d-flex justify-content-end">
                            <h3><i
                                    class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($total, 0, '', '.') }}
                            </h3>
                        </div>
                    </div>
                    <hr>

                    <center>
                        <h3 class="text text-secondary">Cuadre de caja</h3>
                    </center>


                    @if ($permisos === 'history_sell' || $permisos === 'history_sell.full')

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Cédula</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Apellido</th>
                                        <th scope="col">Venta Total</th>
                                        <th scope="col">Transferencias</th>
                                        <th scope="col">Egresos</th>
                                        <th scope="col">Efectivo</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($total_users as $item)
                                        <tr>
                                            <td>
                                                <h4>&nbsp;&nbsp;{{ $item['cedula'] }}
                                                </h4>
                                            </td>
                                            <td>
                                                <h4>&nbsp;&nbsp;{{ $item['nombre'] }}
                                                </h4>
                                            </td>
                                            <td>
                                                <h4>&nbsp;&nbsp;{{ $item['apellido'] }}
                                                </h4>
                                            </td>

                                            <td>
                                                <h4><i
                                                        class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($item['total_venta'], 0, '', '.') }}
                                                </h4>
                                            </td>

                                            <td>
                                                <h4><i
                                                        class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($item['total_transferencia'], 0, '', '.') }}
                                                </h4>
                                            </td>

                                            <td>
                                                <h4><i
                                                        class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($item['total_egresos'], 0, '', '.') }}
                                                </h4>
                                            </td>

                                            <td>
                                                <h4><i
                                                        class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($item['total_venta'] - ($item['total_egresos'] + $item['total_transferencia']), 0, '', '.') }}
                                                </h4>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Total venta global</th>
                                        <th scope="col">ventas de {{ $name }}</th>
                                        <th scope="col">Transferencias hechas por {{ $name }}</th>
                                        <th scope="col">Egresos de caja de {{ $name }}</th>
                                        <th scope="col">Efectivo que debe tener {{ $name }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h3><i
                                                    class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($total, 0, '', '.') }}
                                            </h3>
                                        </td>
                                        <td>
                                            <h3><i
                                                    class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($my_sell, 0, '', '.') }}
                                            </h3>
                                        </td>
                                        <td>
                                            <h3><i
                                                    class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($self_transfers, 0, '', '.') }}
                                            </h3>
                                        </td>
                                        <td>
                                            <h3><i
                                                    class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($my_egress, 0, '', '.') }}
                                            </h3>
                                        </td>

                                        <td>
                                            <h3><i
                                                    class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($my_sell - ($self_transfers + $my_egress), 0, '', '.') }}
                                            </h3>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    @endif

                </div>
                <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel"
                    aria-labelledby="custom-tabs-two-profile-tab">

                    <center>
                        <h4 class="text-secondary">Historial de ventas/unificadas </h4>
                    </center>
                    <hr>
                    <div class="table-responsive">

                        <table class="table" id="history_sell_table_unit">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Representación</th>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Descripción Producto</th>
                                    <th scope="col">Unidades vendidas</th>
                                    <th scope="col">Cajero Responsable</th>
                                    <th scope="col">Cédula</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Total venta/producto</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $flagg = 1;
                                @endphp

                                @foreach ($unificado as $item)
                                    <tr>
                                        <th scope="row">{{ $flagg }}</th>
                                        <td><img src="{{ $item['url_imagen'] }}"
                                                alt="Representación de {{ $item['nombre_producto_venta'] }}"
                                                width="50" height="50"></td>
                                        <td>{{ $item['nombre_producto_venta'] }}</td>
                                        <td>{{ $item['descripcion_producto_venta'] }}</td>
                                        <td>{{ $item['total_cantidad'] }}</td>
                                        <td>{{ $item['nombre_cajero'] }}</td>
                                        <td>{{ $item['id_user_cajero'] }}</td>
                                        <td>{{ $item['fecha'] }}</td>
                                        <td>
                                            <i class="fa-solid fa-dollar-sign text-success">
                                            </i>&nbsp;&nbsp;{{ number_format($item['total_vendido'], 0, '', '.') }}
                                        </td>
                                    </tr>

                                    @php
                                        $flagg++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="row p-5">

                        <div class="col-sm">
                            <h3>Total vendido:</h3>
                        </div>
                        <div class="col-sm d-flex justify-content-end">
                            <h3><i
                                    class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($total, 0, '', '.') }}
                            </h3>
                        </div>
                    </div>

                </div>

                <div class="tab-pane fade" id="custom-tabs-two-users" role="tabpanel"
                    aria-labelledby="custom-tabs-two-profile-tab">

                    <center>
                        <h4 class="text-secondary">Ventas por usuario/día</h4>
                    </center>
                    <hr>

                    <div class="table-responsive">
                        <table class="table" id="history_sell_table_unit">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Cédula cajero</th>
                                    <th scope="col">Cajero Responsable</th>
                                    <th scope="col">Total unidades vendidas</th>
                                    <th scope="col">Total Vendido/Cajero</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $flagg = 1;
                                @endphp

                                @foreach ($users as $item)
                                    <tr>
                                        <th scope="row">{{ $flagg }}</th>
                                        <th scope="row">{{ $item['id_user_cajero'] }}</th>
                                        <td>{{ $item['nombre_cajero'] }}</td>
                                        <td>{{ $item['total_unidades'] }}</td>
                                        <td><i
                                                class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($item['total_venta'], 0, '', '.') }}
                                        </td>
                                    </tr>

                                    @php
                                        $flagg++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="row p-5">

                        <div class="col-sm">
                            <h3>Total vendido:</h3>
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
    </div>


    @if ($permisos === 'history_sell.full')
        <!-- Modal -->
        <div class="modal fade" id="modify_sell" data-idventa="" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title " id="tittle_modal_history"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="edit_price">Modificar costo de venta:</label>
                            <input type="number" class="form-control" id="edit_cost_sell"
                                placeholder="Modificar Costo venta $..." autocomplete="off" name="edit_cost_sell">
                        </div>

                        <div>

                            <label>Fecha:</label>
                            <div class="input-group date" data-target-input="nearest">
                                <input type="date" class="form-control" data-target="#reservationdate"
                                    id="date_change_sell">
                                <div class="input-group-append" data-target="#reservationdate"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i
                                class="fa-solid fa-backward"></i>&nbsp;&nbsp;Revertir venta</button>
                        <button type="button" class="btn btn-info" data-dismiss="modal"><i
                                class="fa-solid fa-pen-to-square"></i>&nbsp;&nbsp;Modificar venta</button>
                        <button type="button" class="btn btn-danger"><i
                                class="fa-solid fa-trash"></i>&nbsp;&nbsp;Eliminar Venta</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- /.card -->
</div>
</div>
