<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href=" {{ asset('bootstrap4/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href=" {{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('icons/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link rel="stylesheet" href="{{asset('javascript/plugins/toastr/toastr.min.css')}}">

            {{-- SweetAlert2 --}}

    <link rel="stylesheet" href="{{ asset('javascript/plugins/sweetalert2/sweetalert2.min.css') }}">

    <title>Intranet Julian´s Asociados</title>
</head>

<body class="body">

    <div class="container d-flex justify-content-center"> <img src="{{ asset('assets/logo.png') }}"
            alt="logo mypantalla" width="250" height="250" class="img-mypantalla"></div>

    <div class="container d-flex justify-content-center ">

        <div class="img-mypantalla"></div>

        <div class="card shadow ">

            <div class="card-body login-card-body">

                <center><b>
                        <h3 class="title_intranet">Intranet Julian´s Asociados</h3>
                </center>

                <center>
                    <img src="{{ asset('assets/user.png') }}" alt="usuario" class="img shadow mb-3">
                </center>
                <center>
                    <p class="login-box-msg">Inicio de sesión </p>
                </center>

                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="cédula" id="cedula" autocomplete="off">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fa-solid fa-user-tie"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="contraseña" id="pass"
                        autocomplete="off">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                recordarme
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <button onclick="sendData()"  class="btn btn-danger btn-block"><i
                                class="fa-solid fa-user"></i>&nbsp;&nbsp; Iniciar sesión</button>
                    </div>
                    <!-- /.col -->
                </div>


                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a href="forgot-password.html">Olvidates tu contraseña?</a>
                </p>
            </div>
            <!-- /.login-card-body -->

        </div>
    </div>






    <script src="{{ asset('javascript/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('javascript/home.js') }}"></script>
    <script src="{{ asset('bootstrap4/js/bootstrap.min.js') }}"></script>
        <!-- Toastr -->
        <script src="{{ asset('javascript/plugins/toastr/toastr.min.js')}}"></script>
            <!-- SweetAlert2 -->
    <script src="{{ asset('javascript/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
</body>

</html>

