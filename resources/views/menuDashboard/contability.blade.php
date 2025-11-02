<div class="container-fluid">

    <div class="form-group d-flex">
        <div>

            
            @if ($permisos === "contability")
            
            <label>Fecha:</label>
            <div class="input-group date" data-target-input="nearest">
                <input type="date" class="form-control" data-target="#reservationdate" id="fecha_rango">
                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
                <button onclick="getForRangeGuests('{{ route('egressDate') }}')" class="btn btn-primary ml-2"
                    style=""><i class="fa-regular fa-calendar-days"></i>&nbsp;&nbsp;Buscar egresos por
                    fecha</button>
                    
                @endif

            </div>
        </div>
    </div>
    <div class="card card-primary card-tabs" style="width: 100%">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">

                @if ($permisos === "contability")
                    
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                        href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                        aria-selected="true"><i class="fa-solid fa-dollar-sign"></i>&nbsp;&nbsp;Ingresos mensuales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                        href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                        aria-selected="false"><i class="fa-solid fa-square-minus"></i>&nbsp;&nbsp;Egresos mensuales</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill"
                        href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages"
                        aria-selected="false"><i class="fa-solid fa-upload"></i>&nbsp;&nbsp;Registrar Egresos</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill"
                        href="#tab_egress" role="tab" aria-controls="custom-tabs-one-messages"
                        aria-selected="false"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;&nbsp;Egresos Detallados</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel"
                    aria-labelledby="custom-tabs-one-home-tab">

                    <div class="row p-5">

                        <div class="col-sm">
                            <h3>Dinero disponible:</h3>
                        </div>
                        <div class="col-sm d-flex justify-content-center">
                            <h3><i
                                    class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($total - $total_egreso, 0, '', '.') }}
                            </h3>
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">FECHA</th>
                                    <th scope="col">TOTAL VENTA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item['fecha'] }}</td>
                                        <td><i class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;<span
                                                class="badge badge-success">{{ number_format($item['total_venta_dia'], 0, '', '.') }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row p-5">

                        <div class="col-sm">
                            <h3>Total venta del mes:</h3>
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

                        <div class="table-responsive mt-3">
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">FECHA</th>
                                        <th scope="col">TOTAL EGRESOS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($egresos as $item)
                                        <tr>
                                            <td>{{ $item['fecha'] }}</td>
                                            <td><i class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;<span
                                                    class="badge badge-success">{{ number_format($item['valor'], 0, '', '.') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row p-5">

                            <div class="col-sm">
                                <h3>Total egresos del mes:</h3>
                            </div>
                            <div class="col-sm d-flex justify-content-end">
                                <h3><i
                                        class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($total_egreso, 0, '', '.') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel"
                    aria-labelledby="custom-tabs-one-messages-tab">


                    <center>
                        <h1>Registrar Egreso</h1>
                    </center>

                    <div class="row">

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="valor">Valor Egreso:</label>
                                <input type="number" class="form-control" id="valor"
                                    placeholder="Valor del egreso..." name="nombre" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="valor">Adjuntar imagen egreso:</label>
                                <input type="file" class="form-control" id="comprobante" name="nombre">
                            </div>
                            <div class="d-flex justify-content-center" id="container_image"></div>
                        </div>


                        <div class="col-sm">

                            <div class="form-group">
                                <label for="descripcion_egreso">Descripcion del egreso:</label>
                                <textarea name="descripcion_egreso" placeholder="Descripcion del egreso..." id="descripcion_egreso" cols="30"
                                    rows="1" class="form-control" autocomplete="off"></textarea>
                            </div>

                            <div class="form-group">

                                <label for="">Egreso caja:</label>
                                <select class="form-control select2 select2-danger" name="caja" id="caja">
                                    <option selected value="0">No</option>
                                    <option value="1">Si</option>
                                </select>
                                
                            </div>

                        </div>

                    </div>



                    <button id="button_insert_egress" onclick="sendEgress('{{ route('uploadEgress') }}')"
                        class="btn btn-block bg-gradient-primary mt-2"><i
                            class="fa-solid fa-paper-plane"></i>&nbsp;&nbsp;Registrar Egreso</button>



                </div>

                <div class="tab-pane fade" id="tab_egress" role="tabpanel"
                    aria-labelledby="tab_egress">


                <div class="table-responsive mt-3">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">FECHA</th>
                                <th scope="col">VALOR</th>
                                <th scope="col">NOMBRE</th>
                                <th scope="col">CEDULA</th>
                                <th scope="col">DESCRIPCION</th>
                                <th scope="col">CAJA</th>
                                <th scope="col">COMPROBANTE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($egress_detail as $item)
                                <tr>
                                    <td>{{ $item['fecha'] }}</td>
                                    <td><i class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;<span
                                            class="badge badge-success">{{ number_format($item['valor'], 0, '', '.') }}</span>
                                    </td>
                                    <td>{{$item['nombre']}}</td>
                                    <td>{{$item['cedula']}}</td>
                                    <td>{{$item['descripcion']}}</td>
                                    <td>
                                        @php
                                            $caja = ($item['caja'] == 1) ? "SI" : "NO";
                                            $badge = ($caja === "SI") ? "success" : "danger";
                                        @endphp
                                        <span class="badge badge-{{$badge}}">{{$caja}}</span>
                                    </td>
                                    <td><a href="{{$item['url_imagen']}}" type="button" target="_blank"><i style="font-size: 25px" class="fa-solid fa-file-image"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row p-5">

                    <div class="col-sm">
                        <h3>Total egresos día:</h3>
                    </div>
                    <div class="col-sm d-flex justify-content-end">
                        <h3><i
                                class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($egress_total, 0, '', '.') }}
                        </h3>
                    </div>
                </div>


                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>

</div>
