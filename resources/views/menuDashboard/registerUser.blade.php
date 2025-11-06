
<div class="card_register card card-primary">
    <div class="card-header" style="background-color: #573da2">
        <h3 class="card-title"><i class="fa-solid fa-user-plus"></i>&nbsp;&nbsp; Registrar usuario</h3>
    </div>
    <form id="formdata">
        <div class="card-body">

            <div class="row">
                {{-- COLUMNA 1 --}}

                <div class="col">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" placeholder="nombre" name="nombre">
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" class="form-control" id="apellido" placeholder="apellido"
                            name="apellido">
                    </div>

                    <div class="form-group">
                        <label for="direccion">Direccion:</label>
                        <input type="text" class="form-control" id="direccion" placeholder="Dirección"
                            name="direccion">
                    </div>

                    <div class="form-group">
                        <label for="cel_emergencia">Celular Emergencia:</label>
                        <input type="text" class="form-control" id="cel_emergencia" placeholder="Celular emergencia"
                            name="contacto_emergencia">
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" id="password" placeholder="Contraseña"
                            name="password">
                    </div>

                    <div class="form-group">
                        <label for="rol">Tipo de Usuario:</label>
                        <select class="form-control" name="rol" id="rol">
                            
                            <option value="usuario">Usuario</option>

                            @if ($permisos === "register_users")
                            <option value="super admin">Super Admin</option>
                            <option value="administrador">Administrador</option>
                            @endif
                            
                        </select>
                    </div>
                </div>

                {{-- COLUMNA 2 --}}
                <div class="col">

                    {{-- <div class="form-group">
                        <label for="labor">Tipo de labor:</label>


                        <select class="form-control" id="labor" name="labor">
                            @foreach ($labores as $labor)
                                <option value="{{ $labor['id_labor'] }}">{{ $labor['nombre_labor'] }}</option>
                            @endforeach
                        </select>

                    </div> --}}


                    <div class="form-group">
                        <label for="nacimiento">Fecha de nacimiento:</label>
                        <input type="date" class="form-control" id="nacimiento" name="nacimiento"
                            placeholder="Fecha de nacimiento.">
                    </div>


                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="email" class="form-control" id="email" placeholder="E-mail" name="email">
                    </div>

                    <div class="form-group">
                        <label for="cedula">Cédula:</label>
                        <input type="text" class="form-control" id="cedula" placeholder="Cédula" name="cedula">
                    </div>


                    <div class="form-group">
                        <label for="celular">Celular:</label>
                        <input type="text" class="form-control" id="celular" placeholder="Celular" name="celular">
                    </div>

                    <div class="form-group">
                        <label for="contacto_emergencia">Nombre Contacto de Emergencia:</label>
                        <input type="text" class="form-control" id="contacto_emergencia" name="nombre_contacto"
                            placeholder="Nombre Emergencia">
                    </div>
                </div>
            </div>
        </div>

        <!-- /.card-body -->

        <div class="card-footer" style="background-color: inherit">
            <center><button type="button" class="btn_send btn btn-primary shadow" onclick="sendUser('{{ route('saveUser') }}')"><i
                        class="fa-regular fa-paper-plane"></i>&nbsp;&nbsp;Enviar</button></center>

        </div>
    </form>
</div>

<span class="text-secondary">Desarrollado por SANTIAGO GALLEGO  <a href="https://wa.me/573108805964" target="_blank"><i style="color: #075e54" class="fa-brands fa-whatsapp"></i>&nbsp;&nbsp;3108805964</a></span>
