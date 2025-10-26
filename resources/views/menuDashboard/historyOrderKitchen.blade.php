<div class="container-fluid">


    @if ($rol !== "usuario")
        <div class="form-group d-flex">
            <div>

                <label>Fecha:</label>
                <div class="input-group date" data-target-input="nearest">
                    <input type="date" class="form-control" data-target="#reservationdate" id="range_kitchen">
                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>

                    <button onclick="searchRangeKitchen('{{ route('rangeKitchen') }}')" class="btn btn-primary ml-2"
                        style=""><i class="fa-regular fa-calendar-days"></i>&nbsp;&nbsp;Buscar ordenes por
                        fecha</button>
                </div>
            </div>
        </div>
    @endif

    <div class="card card-default">
        <div class="card-header" style="background-color: #0F318F">
            <h3 class="card-title" style="color: white; font-weight: bold;"><i
                    class="fa-solid fa-kitchen-set"></i>&nbsp;&nbsp;Historial de cocina</h3>
            <div class="card-tools"></div>
        </div>

        <div class="card-body">
            <hr>

            <center>
                <h4 class="text-secondary">Órdenes de cocina</h4>
            </center>
            <hr>



            <div class="card card-primary card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                                href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                                aria-selected="true"><i class="fa-solid fa-list-ol"></i>&nbsp;&nbsp;Total Ordenes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                                href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                                aria-selected="false"><i class="fa-solid fa-list"></i>&nbsp;&nbsp;Ordenes Unitarias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill"
                                href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages"
                                aria-selected="false"><i
                                    class="fa-solid fa-chart-simple">&nbsp;&nbsp;</i>Comparativo</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill"
                                href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings"
                                aria-selected="false">Settings</a>
                        </li> --}}
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                            aria-labelledby="custom-tabs-one-home-tab">

                            <div class="table-responsive">

                                <table class="table" id="table_order_kitchen">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Nombre Producto</th>
                                            <th scope="col"># items</th>
                                            <th scope="col">Descripción</th>
                                            <th scope="col">Nombre Cajero</th>
                                            <th scope="col">Cédula Cajero</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Hora</th>
                                            <th scope="col">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $item)
                                            <tr>
                                                <td>{{ $item['nombre_producto'] }}</td>
                                                <td>{{ $item['cantidad'] }}</td>
                                                <td>{{ $item['descripcion'] }}</td>
                                                <td>{{ $item['nombre_cajero'] }}</td>
                                                <td>{{ $item['id_cajero'] }}</td>
                                                <td>{{ $item['fecha'] }}</td>
                                                <td>{{ $item['hora'] }}</td>

                                                @php
                                                    $class = '';

                                                    if ($item['estado'] === 'preparacion') {
                                                        $class = 'warning';
                                                    } elseif ($item['estado'] === 'preparado') {
                                                        $class = 'info';
                                                    } elseif ($item['estado'] === 'rechazado') {
                                                        $class = 'danger';
                                                    } else {
                                                        $class = 'success';
                                                    }

                                                    $button_start = '';
                                                    $button_end = '';
                                                    if ($id == '1093228865' || $id == '1091272724') {
                                                        $button_start =
                                                            '<a type="button" title="cambiar estado" onclick="openModalKitchen(' .
                                                            $item['id_pedido'] .
                                                            ')">';
                                                        $button_end = '</a>';
                                                    }
                                                @endphp
                                                <th>{!! $button_start !!}<span
                                                        class="badge badge-{{ $class }}">{{ $item['estado'] }}</span>{!! $button_end !!}
                                                </th>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                            </div>

                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                            aria-labelledby="custom-tabs-one-profile-tab">
                            <div class="table-responsive">

                                <table class="table" id="table_order_kitchen_unit">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Nombre Producto</th>
                                            <th scope="col"># items Ordenados a Cocina</th>
                                            <th scope="col">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders_sum as $item)
                                            <tr>
                                                <td>{{ $item['nombre_producto'] }}</td>
                                                <td>{{ $item['total'] }}</td>

                                                @php
                                                    $class = '';

                                                    if ($item['estado'] === 'preparacion') {
                                                        $class = 'warning';
                                                    } elseif ($item['estado'] === 'preparado') {
                                                        $class = 'info';
                                                    } elseif ($item['estado'] === 'rechazado') {
                                                        $class = 'danger';
                                                    } else {
                                                        $class = 'success';
                                                    }

                                                    $button_start = '';
                                                    $button_end = '';
                                                    if ($id == '1093228865' || $id == '1091272724') {
                                                        $button_start =
                                                            '<a type="button" title="cambiar estado" onclick="openModalKitchen(' .
                                                            $item['id_pedido'] .
                                                            ')">';
                                                        $button_end = '</a>';
                                                    }
                                                @endphp
                                                <th>{!! $button_start !!}<span
                                                        class="badge badge-{{ $class }}">{{ $item['estado'] }}</span>{!! $button_end !!}
                                                </th>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel"
                            aria-labelledby="custom-tabs-one-messages-tab">

                            @php
                                $total_descuadres = 0;
                            @endphp

                            <div class="table-responsive">
                                                            <table class="table" id="table_order_kitchen_unit">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Nombre Producto</th>
                                        <th scope="col"># items Ordenados a Cocina</th>
                                        <th scope="col"># items registrados en ventas</th>
                                        <th scope="col"># items faltantes en venta</th>
                                        <th scope="col">Monto restante</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comparativo as $item)

                                    @php
                                        $total_descuadres += $item['total_restante'];
                                    @endphp
                                        <tr>
                                            <td><span class="badge badge-info">{{ $item['nombre_producto'] }}</span>
                                            </td>
                                            <td><span
                                                    class="badge badge-warning">{{ $item['items_ordenados'] }}</span>
                                            </td>
                                            <td><span
                                                    class="badge badge-success">{{ $item['items_historial'] }}</span>
                                            </td>
                                            <td><span class="badge badge-danger">{{ $item['diferencia'] }}</span></td>
                                            <td><i class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($item['total_restante'], 0, '', '.') }}</td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            </div>


                            <div class="row p-5">

                                <div class="col-sm">
                                    <h3>Total Restante de Registro:</h3>
                                </div>
                                <div class="col-sm d-flex justify-content-end">
                                    <h3><i
                                            class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($total_descuadres, 0, '', '.') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel"
                            aria-labelledby="custom-tabs-one-settings-tab">
                            Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus
                            turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis
                            vulputate. Morbi euismod molestie tristique. Vestibulum consectetur dolor a vestibulum
                            pharetra. Donec interdum placerat urna nec pharetra. Etiam eget dapibus orci, eget aliquet
                            urna. Nunc at consequat diam. Nunc et felis ut nisl commodo dignissim. In hac habitasse
                            platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>

        </div>



    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_state_kitchen" tabindex="-9999">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Cambiar estado de Pedido</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="content_modal_state_kitchen" data-id="">

                    <label for="state_kitchen">Cambiar estado:</label>

                    <select class="form-control" id="state_kitchen" name="state_kitchen">
                        <option value="selected">Seleccione un estado</option>
                        <option value="preparacion">Preparación</option>
                        <option value="preparado">Preparado</option>
                        <option value="despachado">Despachado</option>
                        <option value="rechazado">Rechazado</option>
                    </select>

                </div>
                <div class="modal-footer">
                    <button type="button" onclick="sendStateKitchen('{{ route('changeState') }}', 'Aceptar')"
                        class="btn btn-success"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Enviar</button>
                </div>
            </div>
        </div>
    </div>
</div>
