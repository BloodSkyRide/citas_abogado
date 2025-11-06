            <div class="container-fluid">
                <div class="col-sm-12">
                    <div class="card card-primary card-tabs" style="width: 100%">
                        <div class="card-header p-0 pt-1">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">

                                    @php
                                        $texto = $permission == 'inventory' ? 'Modificar/inventario' : 'inventario';
                                    @endphp
                                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                                        href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                                        aria-selected="true"><i class="fa-solid fa-boxes-stacked"></i>&nbsp;&nbsp;{{ $texto }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                                        href="#custom-tabs-one-profile" role="tab"
                                        aria-controls="custom-tabs-one-profile" aria-selected="false"><i class="fa-solid fa-square-poll-horizontal"></i>&nbsp;&nbsp;Reporte
                                        inventario</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill"
                                        href="#custom-tabs-one-messages" role="tab"
                                        aria-controls="custom-tabs-one-messages" aria-selected="false"><i class="fa-solid fa-chart-simple"></i>&nbsp;&nbsp;Comparativo</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill"
                                        href="#custom-tabs-one-settings" role="tab"
                                        aria-controls="custom-tabs-one-settings" aria-selected="false">Settings</a>
                                </li> --}}
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-home-tab">

                                    @if ($permission == 'inventory')
                                        <hr>
                                        <center>
                                            <h4 class="text-secondary"><i
                                                    class="fa-solid fa-boxes-stacked"></i>&nbsp;&nbsp;Crear productos
                                                materia prima</h4>
                                        </center>
                                        <hr>

                                        <div class="row">

                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label for="nombre_producto_inventario">Nombre producto:</label>
                                                    <input type="text" class="form-control"
                                                        id="nombre_producto_inventario" placeholder="Nombre producto..."
                                                        name="nombre" autocomplete="off">
                                                </div>
                                                <div class="form-group">
                                                    <label for="unidades_inventario">Unidades disponibles:</label>
                                                    <input type="number" class="form-control" id="unidades_inventario"
                                                        placeholder="Ingresa la cantidad de unidades" name="unidades"
                                                        autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="col-sm">
                                                <div class="form-group">
                                                    <label for="tope_min">Tope minimo notificación:</label>
                                                    <input type="number" class="form-control" id="tope_min"
                                                        name="imagen_product" placeholder="Tope minimio..."
                                                        autocomplete="off">
                                                </div>

                                                <div class="form-group">
                                                    <label for="imagen_product">Precio costo:</label>
                                                    <input type="number" class="form-control" id="costo"
                                                        name="imagen_product" placeholder="Precio costo..."
                                                        autocomplete="off">
                                                </div>
                                            </div>


                                        </div>


                                        <center>

                                            <div class="form-group" style="width: 50%;">
                                                <label for="categoria">Categoria:</label>

                                                <select class="form-control" id="categoria" name="categoria">
                                                    <option value="">Seleccione una categoria</option>
                                                    <option value="tienda">Tienda</option>
                                                    <option value="cocina">Cocina</option>
                                                </select>

                                            </div>

                                        </center>

                                        <center>

                                            <button class="btn btn-primary"
                                                onclick="createInventory('{{ route('saveInventory') }}')"><i
                                                    class="fa-solid fa-boxes-stacked"></i>&nbsp;&nbsp;Crear
                                                inventario</button>
                                        </center>
                                    @endif

                                    <div class="table-responsive">

                                        <table class="table" id="table_inventory">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    @if ($permission == 'inventory')
                                                        <th scope="col">Información producto</th>
                                                    @endif
                                                    <th scope="col">Nombre Producto</th>
                                                    <th scope="col">Unidades Disponibles</th>
                                                    <th scope="col">Fecha Creación</th>
                                                    <th scope="col">Tope Minimo</th>
                                                    <th scope="col">Precio Costo</th>
                                                    <th scope="col">Total/Producto</th>
                                                    <th scope="col">Categoría</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @php
                                                    $flagg = 1;
                                                @endphp

                                                @foreach ($productos as $producto)
                                                    @php
                                                        $badge =
                                                            $producto['unidades_disponibles'] <= $producto['tope_min']
                                                                ? 'badge badge-danger'
                                                                : 'badge badge-success';
                                                    @endphp
                                                    <tr>
                                                        <th scope="row">{{ $flagg }}</th>
                                                        @if ($permission == 'inventory')
                                                            <td><a onclick="openModalInfoInventory('{{ $producto['id_item'] }}', '{{ $producto['nombre'] }}','{{ $producto['unidades_disponibles'] }}')"
                                                                    title="Información/edición" type="button"
                                                                    class="btn btn-info"><i
                                                                        class="fa-solid fa-circle-info"></i></a></td>
                                                        @endif
                                                        <td>{{ $producto['nombre'] }}</td>
                                                        <td><span
                                                                class="{{ $badge }}">{{ $producto['unidades_disponibles'] }}</span>
                                                        </td>
                                                        <td>{{ $producto['fecha_creacion'] }}</td>
                                                        <td><span
                                                                class="badge badge-warning">{{ $producto['tope_min'] }}</span>
                                                        </td>
                                                        <td><i
                                                                class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($producto['precio_costo'], 0, '', '.') }}
                                                        </td>
                                                        <td><i
                                                                class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($producto['unidades_disponibles'] * $producto['precio_costo'], 0, '', '.') }}
                                                        </td>

                                                        @php
                                                            $badge2 =
                                                                $producto['categoria'] == 'tienda'
                                                                    ? 'badge badge-primary'
                                                                    : 'badge badge-warning';
                                                        @endphp

                                                        <td><span
                                                                class="{{ $badge2 }}">{{ ucfirst($producto['categoria']) }}</span>
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
                                            <h3>Total inventario:</h3>
                                        </div>
                                        <div class="col-sm d-flex justify-content-end">
                                            <h3><i
                                                    class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($total, 0, '', '.') }}
                                            </h3>
                                        </div>
                                    </div>


                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-profile-tab">


                                    <div class="table-responsive">
                                        <table class="table" id="table_inventory_input">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">Nombre Producto</th>
                                                    <th scope="col">Unidades</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($productos as $item)
                                                    <tr>
                                                        <td><span
                                                                class="badge badge-info">{{ $item['nombre'] }}</span>
                                                        </td>
                                                        <td><input type="number" style="width: 30%" class="form form-control product_inventory" data-info="{{ $item['id_item'] }}" id="product_{{ $item['id_item'] }}" value="{{$item['unidades_disponibles']}}"></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>

                                    <hr>

                                    <center><button class="btn btn-success" id="button_send_inventory" onclick="sendInventoryControl('{{route('controlInventory')}}')">Enviar inventario</button></center>

                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-messages-tab">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">Nombre Producto</th>
                                                    <th scope="col">Hora Reporte</th>
                                                    <th scope="col">Fecha Reporte</th>
                                                    <th scope="col">Cantidad Base</th>
                                                    <th scope="col">Cantidad Reportada</th>
                                                    <th scope="col">Cantidad Restante</th>
                                                    <th scope="col">Precio Unitario</th>
                                                    <th scope="col">Monto Restante</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @php
                                                    $total_discount = 0;
                                                @endphp
                                                @foreach ($comparativo as $item)
                                                    <tr>
                                                        <td><span class="badge badge-info">{{$item['nombre']}}</span></td>
                                                        <td>{{$item['hora_reporte']}}</td>
                                                        <td>{{$item['fecha_reporte']}}</td>
                                                        <td><span class="badge badge-success">{{$item['item_original']}}</span></td>
                                                        <td><span class="badge badge-warning">{{$item['item_control']}}</span></td>
                                                        <td><span class="badge badge-danger">{{$item['restante']}}</span></td>
                                                        <td><i class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($item['precio'], 0, '', '.') }}</td>
                                                        <td><i class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($item['total_faltante'], 0, '', '.') }}</td>
                                                    </tr>

                                                    @php
                                                        $total_discount+= $item['total_faltante'];
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                                                    <div class="row p-5">

                                <div class="col-sm">
                                    <h3>Total Restante de Registro:</h3>
                                </div>
                                <div class="col-sm d-flex justify-content-end">
                                    <h3><i
                                            class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($total_discount, 0, '', '.') }}
                                    </h3>
                                </div>
                            </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel"
                                    aria-labelledby="custom-tabs-one-settings-tab">
                                    Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis
                                    tempus turpis ac, ornare sodales tellus. Mauris eget blandit dolor. Quisque
                                    tincidunt venenatis vulputate. Morbi euismod molestie tristique. Vestibulum
                                    consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec pharetra.
                                    Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut
                                    nisl commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet
                                    accumsan ex sit amet facilisis.
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

            </div>

            <!-- Modal -->
            <div class="modal fade" id="modal_edit_inventory">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title" id="titulo_modal_inventario" data-id=""></h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="adicion_unidades">Unidades disponibles:</label>
                                <h2 class="badge badge-success" id="badge"></h2>
                            </div>

                            <div class="form-group">
                                <label for="adicion_unidades">Cambiar nombre item inventario:</label>
                                <input type="text" class="form-control" id="name_edit_inventory"
                                    placeholder="Cambiar nombre item inventario..." autocomplete="off"
                                    name="nombre">
                            </div>

                            <div class="form-group">
                                <label for="adicion_unidades">Adicionar unidades:</label>
                                <input type="number" class="form-control" id="adicion_unidades"
                                    placeholder="añadir unidades al inventario..." autocomplete="off" name="nombre">
                            </div>

                            <div class="form-group">
                                <label for="adicion_unidades">Establecer unidades:</label>
                                <input type="number" class="form-control" id="establishing_units"
                                    placeholder="Establecer unidades inventario..." autocomplete="off"
                                    name="nombre">
                            </div>

                            <div class="form-group">
                                <label for="adicion_unidades">Modificar costo:</label>
                                <input type="number" class="form-control" id="price_costo"
                                    placeholder="Modificar precio de costo..." autocomplete="off" name="costo">
                            </div>

                            <span class="text-secondary">Si desea eliminar un item de inventario recuerde que puede
                                haber otros
                                productos de venta asociados a dicho item...</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger"
                                onclick="deleteInventory('{{ route('deleteInventory') }}')"
                                data-target="#modal_edit_inventory"><i
                                    class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Eliminar</button>
                            <button type="button" onclick="changeInventory('{{ route('editInventory') }}')"
                                class="btn btn-success"><i
                                    class="fa-solid fa-check"></i>&nbsp;&nbsp;Modificar</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
