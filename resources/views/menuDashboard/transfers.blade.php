<div class="container-fluid">

    <div class="form-group d-flex">
        
        
        @if ($permisos == "transfer")
        <div>
                
            <label>Fecha:</label>
            <div class="input-group date" data-target-input="nearest">
                <input type="date" class="form-control" data-target="#reservationdate" id="range_search">
                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>

                <button onclick="serachForRangeTransfers('{{ route('search-range-transfers') }}')" class="btn btn-primary ml-2"
                    style=""><i class="fa-regular fa-calendar-days"></i>&nbsp;&nbsp;Buscar transferencias por
                    fecha</button>
            </div>
        </div>
            @endif
    </div>
    <div class="card card-primary card-tabs" style="width: 100%">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">

                @if ($permisos === "transfer")
                
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                        href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                        aria-selected="true"><i class="fa-solid fa-right-left"></i>&nbsp;&nbsp;Transferencias</a>
                </li>
                @endif
                {{-- <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                        href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                        aria-selected="false"><i class="fa-solid fa-square-minus"></i>&nbsp;&nbsp;Egresos mensuales</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill"
                        href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages"
                        aria-selected="false"><i class="fa-solid fa-upload"></i>&nbsp;&nbsp;Registrar Transferencia</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill"
                        href="#tab_egress" role="tab" aria-controls="custom-tabs-one-messages"
                        aria-selected="false"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;&nbsp;Transferencias Detalladas</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel"
                    aria-labelledby="custom-tabs-one-home-tab">

                    @if ($permisos === "transfer")
                        
                    <div class="table-responsive mt-3">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">FECHA</th>
                                    <th scope="col">VALOR</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($transferencias_mes as $item)
                                    
                                <tr>
                                    <td>{{$item['fecha']}}</td>
                                    <td><i class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;<span
                                        class="badge badge-success">{{ number_format($item['valor'], 0, '', '.') }}</span></td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="row p-5">

                        <div class="col-sm">
                            <h3>Total transferencias mes:</h3>
                        </div>
                        <div class="col-sm d-flex justify-content-end">
                            <h3><i
                                    class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($total_transferencias, 0, '', '.') }}
                            </h3>
                        </div>
                    </div>

                    @endif


                </div>
                {{-- <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
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

                                </tbody>
                            </table>
                        </div>

                        <div class="row p-5">

                            <div class="col-sm">
                                <h3>Total venta del mes:</h3>
                            </div>
                            <div class="col-sm d-flex justify-content-end">
                                <h3><i
                                        class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;
                                </h3>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel"
                    aria-labelledby="custom-tabs-one-messages-tab">


                    <center>
                        <h1>Registrar Transferencia</h1>
                    </center>

                    <div class="row">

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="valor">Valor Transferencia:</label>
                                <input type="number" class="form-control" id="valor_transferencia"
                                    placeholder="Valor del transferencia..." name="nombre" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="valor">Comprobante Transferencia:</label>
                                <input type="file" class="form-control" id="comprobante_transferencia" name="nombre">
                                <div class="d-flex justify-content-center" id="container_image"></div>
                            </div>
                        </div>


                        <div class="col-sm">

                            <div class="form-group">
                                <label for="descripcion_egreso">Descripcion transferencia:</label>
                                <textarea name="descripcion_transferencia" placeholder="Descripcion transferencia..." id="descripcion_transferencia" cols="30"
                                    rows="1" class="form-control" autocomplete="off"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="descripcion_egreso">Entidad Bancaria:</label>
                                <input type="text" class="form-control" id="entidad"
                                    placeholder="entidad bancaria..." name="entidad" autocomplete="off">
                            </div>
                        </div>

                    </div>


                    <button id="button_insert_transfers" onclick="insertTransfer('{{ route('insertTransfer') }}')"
                        class="btn btn-block bg-gradient-primary mt-2"><i class="fa-solid fa-arrow-right-arrow-left"></i>&nbsp;&nbsp;Registrar Transferencia</button>



                </div>

                <div class="tab-pane fade" id="tab_egress" role="tabpanel"
                    aria-labelledby="tab_egress">


                    <div class="table-responsive mt-3">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">FECHA</th>
                                    <th scope="col">HORA</th>
                                    <th scope="col">DESCRIPCION</th>
                                    <th scope="col">CAJERO RESPONSABLE</th>
                                    <th scope="col">VALOR</th>
                                    <th scope="col">ENTIDAD BANCARIA</th>
                                    <th scope="col">COMPROBANTE</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($transfers_today as $item)
                                    
                                <tr>
                                    <td>{{$item['fecha']}}</td>
                                    <td>{{$item['hora']}}</td>
                                    <td>{{$item['descripcion']}}</td>
                                    <td>{{$item['cajero_responsable']}}</td>
                                    <td>{{$item['valor']}}</td>
                                    <td>{{$item['entidad']}}</td>
                                    <td><a target="_blank" type="button" href="{{$item['url_imagen']}}"><i style="font-size: 25px" class="fa-solid fa-file-image"></i></a></td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                <div class="row p-5">

                    <div class="col-sm">
                        <h3>Total transferencias día:</h3>
                    </div>
                    <div class="col-sm d-flex justify-content-end">
                        <h3><i
                                class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;{{ number_format($total_detail, 0, '', '.') }}
                        </h3>
                    </div>
                </div>


                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>

</div>
