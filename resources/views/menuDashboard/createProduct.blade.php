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
                <h4 class="text-secondary"><i class="fa-solid fa-dollar-sign"></i>&nbsp;&nbsp;Crear productos de venta
                </h4>
            </center>
            <hr>


            <div class="row">
                {{-- COLUMNA 1 --}}

                <div class="col">
                    <div class="form-group">
                        <label for="nombre_producto">Nombre producto:</label>
                        <input type="text" class="form-control" id="nombre_producto" placeholder="nombre producto..."
                            autocomplete="off" name="nombre">
                    </div>
                    <div class="form-group">
                        <label for="precio_producto">Precio producto:</label>
                        <input type="number" step="0.001" class="form-control" id="precio_producto"
                            autocomplete="off" placeholder="Ingresa la cantidad de unidades" name="precio_producto">
                    </div>

                    <div class="form-group">
                        <label for="imagen_product">Seleccionar imagen producto:</label>
                        <input type="file" class="form-control" id="imagen_product" name="imagen_product"
                            autocomplete="off">
                    </div>

                    <div id="previewContainer">
                        <center><img id="imagePreview" src="" alt="Previsualización de imagen"
                                style="display: none; max-width: 300px; margin-top: 10px;"></center>
                    </div>

                    <div class="form-group">

                        <label for="categoria">Categoria:</label>

                        <select class="form-control" id="category" name="category">
                            <option value="">Seleccione una categoria</option>
                            <option value="tienda">Tienda</option>
                            <option value="cocina">Cocina</option>
                        </select>

                    </div>


                    <div class="form-group">

                        <label for="categoria">Tipo producto de venta:</label>

                        <select class="form-control" id="type_product" name="category">
                            <option value="selected">Seleccione un tipo</option>
                            <option value="no aplica">N/A</option>
                            <option value="compuesto">Compuesto</option>
                            <option value="unitario">Unitario</option>
                        </select>

                    </div>

                </div>


                {{-- COLUMNA 2 --}}
                <div class="col">

                    <div class="row">

                        <div class="col-md-9">

                            <div class="form-group">
                                <label for="imagen">Descripcion del producto:</label>
                                <textarea name="descripcion" id="descripcion_textarea" cols="30" rows="2" class="form-control"
                                    autocomplete="off" placeholder="Descripción del producto..."></textarea>
                            </div>

                            <div class="form-group">
                                <label for="select_item">Seleccionar items inventario:</label>
                                <select class="form-control select2 select2-danger" tabindex="9999"
                                    data-dropdown-css-class="select2-danger" style="width: 100%;" id="select_item">
                                    <option selected="selected" value="selected">Seleccionar item</option>

                                    @foreach ($productos as $producto)
                                        <option value="{{ $producto['id_item'] }}">{{ $producto['nombre'] }}</option>
                                    @endforeach

                                </select>

                            </div>

                            <button class="btn btn-primary" onclick="addItemInventory()" class="fa-solid fa-plus"><i
                                    class="fa-solid fa-plus"></i>&nbsp;&nbsp;Añadir item</button>
                        </div>

                    </div>
                    <div class="col-md">

                        <div class="table-responsive mt-3">

                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">item</th>
                                        <th scope="col">Descuento</th>
                                    </tr>
                                </thead>
                                <tbody id="container_tr">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <center>
                <button class="btn btn-primary mt-3" onclick="saveProduct('{{ route('saveProduct') }}')"><i
                        class="fa-solid fa-square-plus"></i>&nbsp;&nbsp;Crear producto de Venta</button>
            </center>

            <hr>
            <center>
                <h3>Total productos información</h3>
            </center>

            <div class="table-responsive">

                <table class="table" id="table_products_total">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Información</th>
                            <th scope="col">Item Respresentación</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Fecha creación</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Categoría</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $flag = 1;
                        @endphp
                        @foreach ($compuestos as $item)
                            <tr>
                                <th scope="row">{{ $flag }}</th>
                                <th scope="row"><a type="button"
                                        onclick="openModalInfo('{{ $item['id_producto'] }}','{{ $item['nombre_producto'] }}','{{ route('informationProduct') }}')"
                                        class="btn btn-info"><i class="fa-solid fa-circle-info"></i></a></th>
                                <td><img src="{{ $item['url_imagen'] }}" alt="item {{ $item['nombre_producto'] }}"
                                        width="40" height="40"></td>
                                <td>{{ $item['nombre_producto'] }}</td>
                                <td>{{ $item['descripcion'] }}</td>
                                <td>{{ $item['fecha_creacion'] }}</td>
                                <td><i class="fa-solid fa-dollar-sign text-success"></i>&nbsp;&nbsp;<span
                                        class="badge badge-success">{{ number_format($item['precio'], 0, '', '.') }}</span>
                                </td>
                                <td>

                                    @php
                                        $badge =
                                            $item['categoria'] == 'tienda'
                                                ? 'badge badge-primary'
                                                : 'badge badge-warning';
                                    @endphp

                                    <span class="{{ $badge }}">{{ ucfirst($item['categoria']) }}</span>

                                </td>
                            </tr>

                            @php
                                $flag++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>


    <!-- Modal -->
    <div class="modal fade" id="modal_info" data-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg bg-success">
                    <h5 class="modal-title" id="titulo_modal"></h5>
                    <button type="button" class="close" onclick="closeModalSecure()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span class="text-secondary" id="span_id" data-id=""></span>
                    <br>
                    <br>
                    <div class="table-responsive">

                        <table class="table" id="table_guests">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Nombre item materia prima</th>
                                    <th scope="col">Cantidad de unidades de descuento</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_id">
                            </tbody>
                        </table>

                        <br>
                        <label for="" id="type_product_tittle"></label>

                    </div>

                    <hr>
                    <center>
                        <h3 class="text-secondary">Modificar producto de venta</h3>
                    </center>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="edit_price">Modificar nombre producto:</label>
                                <input type="text" class="form-control" id="edit_name"
                                    placeholder="Modificar nombre item..." autocomplete="off" name="costo">
                            </div>

                            <div class="form-group">
                                <label for="edit_description">Descripción del producto:</label>
                                <textarea name="descripcion" id="edit_description" cols="30" rows="2" class="form-control"
                                    autocomplete="off" placeholder="Descripción del producto..."></textarea>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="edit_price">Modificar costo:</label>
                                <input type="number" class="form-control" id="edit_price"
                                    placeholder="Modificar precio de costo..." autocomplete="off" name="costo">
                            </div>

                            <div class="form-group">
                                <label for="edit_imagen_product">Modificar imagen de producto:</label>
                                <input type="file" class="form-control" id="edit_imagen_product"
                                    name="imagen_product" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div id="previewContainer">
                        <center><img id="imagePreview2" src="" alt="Previsualización de imagen"
                                style="display: none; max-width: 150px; margin-top: 10px; max-height: 150px"></center>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModalSecure()">Cerrar</button>
                    <button type="button" onclick="deleteProductSeller('{{ route('deleteCompound') }}')"
                        class="btn btn-danger" data-dismiss="modal"><i
                            class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Eliminar</button>
                    <button type="button" onclick="modifyItemCompound('{{ route('editProductCompund') }}')"
                        class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i>&nbsp;&nbsp;Modificar</button>
                </div>
            </div>
        </div>
    </div>
</div>
