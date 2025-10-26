<div class="container-fluid">

    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Administrador de usuarios</h3>
        </div>

        <div class="card-body">


            <div class="table-responsive">
                <table class="table table-striped" id="table_userss">
                    <thead class="thead-dark">
    
                        <tr>
                            <th scope="col">Cédula</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Labor Asignada</th>
                            <th scope="col">Direccion</th>
                            <th scope="col">E-mail</th>
                            <th scope="col"># Emergencia</th>
                            <th scope="col">Nombre Emergencia</th>
                            <th scope="col"># Telefono</th>
                            <th scope="col">Fecha Registro</th>
    
                        </tr>
    
                    </thead>
                    <tbody>
    
                        @foreach ($users as $item)
                            <tr>
                                <td>
    
                                    <a type="button"
                                        onclick="openModalUser('{{ $item['cedula'] }}','{{ route('getUserForId') }}')"><i
                                            class="fa-solid fa-user-pen"></i>&nbsp;&nbsp;<span
                                            class="badge bg-success">{{ $item['cedula'] }}</span></a>
                                </td>
    
                                <td>{{ $item['nombre'] }}</td>
                                <td>{{ $item['apellido'] }}</td>
                                <td>
                                    @php
                                        $text = ($item["rol"] !== "usuario") ? "info" : "warning";
                                        $icon = ($item["rol"] !== "usuario") ? '<i class="fa-solid fa-user-tie"></i>': '<i class="fa-solid fa-user"></i>'
                                    @endphp
                                    
                                    <span
                                    class="badge bg-{{$text}}">{!! $icon !!}&nbsp;&nbsp;{{ $item['rol'] }}</span>
                                
                                </td>
                                <td>{{ $item['direccion'] }}</td>
                                <td>{{ $item['email'] }}</td>
                                <td>{{ $item['contacto_emergencia'] }}</td>
                                <td>{{ $item['nombre_contacto'] }}</td>
                                <td>{{ $item['telefono'] }}</td>
                                <td>{{ $item['fecha_registro'] }}</td>
                            </tr>
                        @endforeach
    
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_edit">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg bg-primary">

                <div class="d-flex"><h5><i class="fa-solid fa-pen-to-square"></i>&nbsp;&nbsp;</h5><h5 class="modal-title" id="title_modal"></h5></div>
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="new_form">

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="nombre_form">Nombre:</label>
                                <input type="email" class="form-control" id="nombre_form" placeholder="Nombre..." name="nombre_form">
                            </div>

                            <div class="form-group">
                                <label for="apellido_form">Apellido:</label>
                                <input type="text" class="form-control" id="apellido_form" placeholder="Apellido..." name="apellido_form">
                            </div>

                            <div class="form-group">
                                <label for="selector_rol">Seleccionar rol:</label>
                                <select class="form-control" style="width: 100%;" id="selector_rol" name="selector_rol">

                                    <option value="administrador">Administrador</option>
                                    <option value="usuario">Usuario</option>
                                    @if ($rol === "super admin")
                                    <option value="super admin">Super Admin</option>
                                    @endif

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="nombre_emergencia_form">Nombre del contacto de emergencia:</label>
                                <input type="text" class="form-control" id="nombre_emergencia_form" placeholder="Nombre contacto" name="nombre_emergencia_form">
                            </div>




                            <div class="form-group">
                                <label for="my_numero">Número de contacto:</label>
                                <input type="text" class="form-control" id="my_numero" placeholder="Número de contacto..." name="my_numero">
                            </div>
                        </div>


                        <div class="col">


                            <div class="form-group">
                                <label for="direccion_form">Dirección:</label>
                                <input type="text" class="form-control" id="direccion_form" placeholder="Dirección..." name="direccion_form">
                            </div>


                            <div class="form-group">
                                <label for="email_form">E-mail:</label>
                                <input type="email" class="form-control" id="email_form" placeholder="pepitoperez@example.com" name="email_form">
                            </div>


                            <div class="form-group">
                                <label for="select_labor_edit">Seleccionar labor:</label>
                                <select class="form-control select2 select2-danger"
                                    data-dropdown-css-class="select2-danger" style="width: 100%;" name="select_labor_edit"
                                    id="select_labor_edit">
                                    <option selected="selected">Seleccionar labor</option>

                                    @foreach ($labores as $labor)
                                        <option value="{{ $labor['id_labor'] }}">{{ $labor['nombre_labor'] }}</option>
                                    @endforeach

                                </select>
                            </div>


                            <div class="form-group">
                                <label for="form_num_emergencia">Número del contacto de emergencia:</label>
                                <input type="text" class="form-control" id="form_num_emergencia" placeholder="Número de contacto..." name="form_num_emergencia">
                            </div>


                            <div class="form-group">
                                <label for="new_pass">Generar nueva contraseña:</label>
                                <div class="d-flex">
                                    <input type="password" class="form-control" id="new_pass"
                                        placeholder="contraseña nueva..." name="new_pass" autocomplete="off"> 
                                        <a type="button" class="m-2" onclick="showPass(this.id, 'new_pass')" id="showpass2">
                
                                        <i class="fa-solid fa-eye color_eye"></i>
                
                                    </a>
                                </div>
                
                            </div>
                        </div>

                    </div>

                    <div class="card-body">


                    </div>


                </form>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa-solid fa-circle-xmark"></i>&nbsp;&nbsp;Cerrar</button>

                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="deleteUser('{{route('deleteUser')}}')" ><i class="fa-solid fa-user-minus"></i>&nbsp;&nbsp;Eliminar Usuario</button>


                <button type="button" class="btn btn-info" data-id="" id="button_save"
                    onclick="modifyUser('{{ route('modifyUser') }}')"><i
                        class="fa-solid fa-check"></i>&nbsp;&nbsp;Guardar cambios</button>
            </div>
        </div>
    </div>
</div>
