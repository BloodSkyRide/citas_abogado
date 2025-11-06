<div class="container-fluid">

    <div class="card card-default">
        <div class="card-header" style="background-color: #0F318F">
            <h3 class="card-title" style="color: white; font-weight: bold;"><i
                    class="fa-solid fa-list"></i>&nbsp;&nbsp;Crear productos</h3>
            <div class="card-tools"></div>
        </div>

        <div class="card-body">

            <hr>
            <center>
                <h3>Comida de empleados</h3>
            </center>

            <div class="form-group">
                <label for="select_item">Seleccionar productos de venta:</label>
                <select class="form-control select2 select2-danger" data-dropdown-css-class="select2-danger"
                    style="width: 100%;" id="select_item_sell">
                    <option selected="selected" value="selected">Seleccionar item</option>

                    @foreach ($products as $producto)
                        <option value="{{ $producto['id_producto'] }}">{{ $producto['nombre_producto'] }}</option>
                    @endforeach

                </select>

            </div>
            <div class="form-group">
                <label for="unidades_inventario">Nombre empleado:</label>
                <input type="text" class="form-control" id="name_employee" placeholder="Nombre del empleado"
                    name="unidades" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="unidades_inventario">Unidades:</label>
                <input type="number" class="form-control" id="units_employee" placeholder="unidades a asignar"
                    name="unidades" autocomplete="off">
            </div>

            <center><button onclick="discountFoodEmployee('{{route('insertFood')}}')" class="btn btn-info"><i class="fa-solid fa-utensils"></i>&nbsp;&nbsp;Asignar comida</button>
            </center>

            <hr>

            <center>
                <h3>Alimentación entregada</h3>
            </center>

            @if ($permisos === 'employee_food')
            <div class="form-group d-flex mt-2 mb-2">
                <div>
    
                    <label>Fecha:</label>
                    <div class="input-group date" data-target-input="nearest">
                        <input type="date" class="form-control" data-target="#reservationdate" id="reservationdate">
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
    
                        <button onclick="searchforRangeFood('{{ route('search-range-food') }}')" class="btn btn-primary ml-2"
                            style=""><i class="fa-regular fa-calendar-days"></i>&nbsp;&nbsp;Buscar fechas</button>
                    </div>
                </div>
            </div>
        @endif

            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Nombre empleado</th>
                            <th scope="col">Cajero responsable</th>
                            <th scope="col">Cedula</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Unidades</th>
                            <th scope="col">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
    
                        @foreach ($registers as $item)
                            <tr>
                                <td>{{$item['nombre_empleado']}}</td>
                                <td>{{$item['nombre_cajero']}}</td>
                                <td>{{$item['cedula']}}</td>
                                <td>{{$item['item_producto']}}</td>
                                <td>{{$item['unidades']}}</td>
                                <td>{{$item['fecha']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>

    </div>
</div>
