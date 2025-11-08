<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('javascript/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('javascript/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('javascript/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
        href="{{ asset('javascript/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('javascript/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('javascript/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('javascript/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet"
        href="{{ asset('javascript/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="{{ asset('javascript/plugins/bs-stepper/css/bs-stepper.min.css') }}">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{ asset('javascript/plugins/dropzone/min/dropzone.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('javascript/plugins/dist/css/adminlte.min.css') }}">
    {{-- estilos --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('javascript/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('javascript/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('javascript/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    {{-- SweetAlert2 --}}

    <link rel="stylesheet" href="{{ asset('javascript/plugins/sweetalert2/sweetalert2.min.css') }}">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('javascript/plugins/toastr/toastr.min.css') }}">

</head>
<div id="custom-toast-container"></div>

<body class="hold-transition sidebar-mini">

    <div class="wrapper">

        <audio id="notificationSound" src="{{ asset('notification/notification.mp3') }}"></audio>
        <audio id="notificationSound2" src="{{ asset('notification/devolution.mp3') }}"></audio>

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                {{-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">prueba</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">prueba</a>
                </li> --}}
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->


                <li class="nav-item">
                    <a class="nav-link" role="button" type="button" title="Cerrar sesión"
                        onclick="logout('{{ route('logout') }}')">
                        <i class="fa-solid fa-right-from-bracket" style="color: rgb(201, 32, 32)"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="aside main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="https://www.facebook.com/share/1Bn3Xcx28H/?mibextid=wwXIfr" class="brand-link" target="blank">
                <img src="{{ asset('assets/small_logo.png') }}" alt="Mypantalla"
                    class="brand-image img-circle elevation-3 shadow">
                <span class="brand-text font-weight-light">Parador Rapi</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('assets/user.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ $array['nombre'] }}</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                {{-- <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div> --}}

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <h1 class="nav-header">MENÚ</h1>





                        @if (in_array('kitchen', $array['permisos']) || in_array('kitchen.searcher', $array['permisos']))
                            <li class="nav-item">
                                <a class="nav-link menu_dashboard"
                                    onclick="getShowOrdersKitchen('{{ route('showKitchen') }}')" type="button">
                                    <i class="fa-solid fa-kitchen-set"></i>&nbsp;&nbsp;
                                    <p>
                                        Pedidos cocina

                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (in_array('change_password', $array['permisos']))
                            <li class="nav-item">
                                <a class="nav-link" type="button"
                                    onclick="getShowChangePassword('{{ route('changePasswordShow') }}')">
                                    <i class="fa-solid fa-key"></i>&nbsp;&nbsp;
                                    <p>
                                        Cambiar contraseña
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (in_array('schedules', $array['permisos']))
                            <li class="nav-item">
                                <a class="nav-link menu_dashboard" type="button"
                                    onclick="getShowAssists('{{ route('getShowAssist') }}')">
                                    <i class="fa-brands fa-creative-commons-nd"></i>&nbsp;&nbsp;
                                    <p>
                                        Asistencias
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (in_array('inventory.edit', $array['permisos']))
                            <li class="nav-item">
                                <a class="nav-link menu_dashboard"
                                    onclick="getShowInventory('{{ route('getShowInventory') }}')" type="button"
                                    id="payroll_nav">
                                    <i class="fa-solid fa-boxes-stacked"></i>&nbsp;&nbsp;
                                    <p>

                                        inventario

                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (in_array('payrol', $array['permisos']))
                            {{-- <li class="nav-item">
                                <a class="nav-link menu_dashboard" type="button"
                                    onclick="getShowHistoryOverTime('{{ route('getShowOverTime') }}')">
                                    <i class="fa-solid fa-person-circle-plus"></i>&nbsp;&nbsp;
                                    <p>
                                        Solicitar horas extras
                                    </p>
                                </a>
                            </li> --}}

                            <li class="nav-item">
                                <a class="nav-link menu_dashboard"
                                    onclick="getHistoryPayRoll('{{ route('getHistoryPayRoll') }}','{{ $array['cedula'] }}')"
                                    type="button" id="payroll_nav">
                                    <i class="fa-solid fa-dollar-sign"></i>&nbsp;&nbsp;
                                    <p>
                                        Nomina
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (in_array('store', $array['permisos']))
                            <li class="nav-item">
                                <a class="nav-link menu_dashboard"
                                    onclick="getShowStore('{{ route('getShowStore') }}')" type="button"
                                    id="payroll_nav">
                                    <i class="fa-solid fa-store"></i>&nbsp;&nbsp;
                                    <p>
                                        vender
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (in_array('history_sell', $array['permisos']) || in_array('history_sell.searcher', $array['permisos']))
                            <li class="nav-item">
                                <a class="nav-link menu_dashboard"
                                    onclick="getShowHistorySell('{{ route('getShowHistorySell') }}')" type="button"
                                    id="payroll_nav">
                                    <i class="fa-solid fa-list"></i>&nbsp;&nbsp;
                                    <p>
                                        Historial ventas
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (in_array('hotel', $array['permisos']) || in_array('hotel.searcher', $array['permisos']))
                            <li class="nav-item">
                                <a class="nav-link menu_dashboard"
                                    onclick="getShowGuest('{{ route('getShowGuest') }}')" type="button"
                                    id="payroll_nav">
                                    <i class="fa-solid fa-hotel"></i>&nbsp;&nbsp;
                                    <p>
                                        Hospedaje
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (in_array('contability', $array['permisos']) || in_array('contability.egress', $array['permisos']))
                            <li class="nav-item">
                                <a class="nav-link menu_dashboard"
                                    onclick="getShowContability('{{ route('contability') }}')" type="button"
                                    id="payroll_nav">
                                    <i class="fa-solid fa-calculator"></i>&nbsp;&nbsp;
                                    <p>
                                        Contabilidad
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (in_array('transfer', $array['permisos']) || in_array('transfer.searcher', $array['permisos']))
                            <li class="nav-item">
                                <a class="nav-link menu_dashboard"
                                    onclick="getShowTransfers('{{ route('getShowTransfers') }}')" type="button"
                                    id="payroll_nav">
                                    <i class="fa-solid fa-arrow-right-arrow-left"></i>&nbsp;&nbsp;
                                    <p>
                                        Transferencias
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (in_array('manage_users', $array['permisos']) || in_array('manage_users.admin', $array['permisos']))
                            <li class="nav-item">
                                <a class="nav-link menu_dashboard"
                                    onclick="getShowAdminUsers('{{ route('getShowUsers') }}')" type="button">
                                    <i class="fa-solid fa-users"></i>&nbsp;&nbsp;
                                    <p>
                                        Administrador Usuarios

                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (in_array('register_users', $array['permisos']) || in_array('register_users.admin', $array['permisos']))
                            <li class="nav-item">
                                <a class="nav-link menu_dashboard"
                                    onclick="register_user('{{ route('registroUser') }}')" type="button"
                                    id="register_nav">
                                    <i class="fa-solid fa-user-plus"></i>&nbsp;&nbsp;
                                    <p>
                                        Registrar Usuarios
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (in_array('register_users', $array['permisos']) || in_array('register_users.admin', $array['permisos']))
                            <li class="nav-item">
                                <a class="nav-link menu_dashboard" type="button"
                                    onclick="getShowAssists('{{ route('getShowReportAssists') }}')">
                                    <i class="fa-solid fa-person-shelter"></i>&nbsp;&nbsp;
                                    <p>
                                        Reporte de asistencias
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (in_array('schedules', $array['permisos']))
                            <li class="nav-item">
                                <a class="nav-link menu_dashboard"
                                    onclick="getShowSchedules('{{ route('getShowSchedule') }}')" type="button"
                                    id="register_nav">
                                    <i class="fa-solid fa-house-circle-check"></i>&nbsp;&nbsp;
                                    <p>
                                        Horarios
                                    </p>
                                </a>
                            </li>
                        @endif
                        {{-- <li class="nav-item">
                                <a class="nav-link menu_dashboard" type="button"
                                    onclick="getShowOverTime('{{ route('getShowOverTimeAdmin') }}')">
                                    <i class="fa-solid fa-bell"></i></i>&nbsp;&nbsp;
                                    <p>
                                        Reporte horas extras
                                    </p>
                                </a>
                            </li> --}}
                        @if (in_array('product_seller', $array['permisos']))
                            <li class="nav-item">
                                <a class="nav-link menu_dashboard"
                                    onclick="createProduct('{{ route('createProduct') }}')" type="button"
                                    id="payroll_nav">
                                    <i class="fa-solid fa-cart-plus"></i>&nbsp;&nbsp;
                                    <p>
                                        Productos de venta
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (in_array('inventory', $array['permisos']))
                            <li class="nav-item">
                                <a class="nav-link menu_dashboard"
                                    onclick="getShowInventory('{{ route('getShowInventory') }}')" type="button"
                                    id="payroll_nav">
                                    <i class="fa-solid fa-boxes-stacked"></i>&nbsp;&nbsp;
                                    <p>

                                        Materia Prima

                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (in_array('employee_food', $array['permisos']) || in_array('employee_food.searcher', $array['permisos']))
                            <li class="nav-item">
                                <a class="nav-link menu_dashboard"
                                    onclick="getShowEmployeeFood('{{ route('getShowEmployeeFood') }}')"
                                    type="button" id="payroll_nav">
                                    <i class="fa-solid fa-utensils"></i>&nbsp;&nbsp;
                                    <p>
                                        Alimentación empleados
                                    </p>
                                </a>
                            </li>
                        @endif

                        {{-- <li class="nav-item">
                            <a class="nav-link menu_dashboard" type="button"
                                onclick="getShowOverTime('{{ route('getShowOverTimeAdmin') }}')">
                                <i class="fa-solid fa-bell"></i></i>&nbsp;&nbsp;
                                <p>
                                    Reporte horas extras
                                </p>
                            </a>
                        </li> --}}
                </nav>
            </div>

        </aside>


        <!-- Modal de confirmación-->
        <div class="modal fade" id="exampleModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg bg-danger">
                        <h5 class="modal-title" id="exampleModalLabel"><i
                                class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;¡Seguro de realizar esta
                            acción!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="bridge" data-state="" data-id="">


                        <h4 id="security"></h4>

                        <p>Una vez realizada esta acción no podrá deshacerla!</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="fa-solid fa-ban"></i>&nbsp;&nbsp;Cancelar</button>
                        <button type="button" class="btn btn-primary" id="button_send_modal"
                            onclick="sendModalAccept('{{ route('captureHour') }}')"><i
                                class="fa-solid fa-circle-check"></i>&nbsp;&nbsp;Confirmar</button>
                    </div>
                </div>
            </div>
        </div>





        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 805px;">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0" id="role_h1">{{ $array['rol'] }}</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                {{-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li> --}}
                            </ol>
                        </div>
                    </div>
                    <div id="container_menu"></div> <!-- DONDE SE CARGA CADA PESTAÑA -->

                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('javascript/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('javascript/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('javascript/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ asset('javascript/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('javascript/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('javascript/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('javascript/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ asset('javascript/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('javascript/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- BS-Stepper -->
    <script src="{{ asset('javascript/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
    <!-- dropzonejs -->
    <script src="{{ asset('javascript/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('javascript/plugins/dist/js/adminlte.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('javascript/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('javascript/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('javascript/plugins/toastr/toastr.min.js') }}"></script>

    {{-- DATATABLES --}}
    <script src="{{ asset('javascript/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('javascript/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('javascript/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('javascript/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('javascript/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('javascript/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('javascript/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('javascript/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('javascript/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('javascript/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('javascript/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('javascript/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- Pusher -->
    <script src="{{ asset('javascript/echo.iife.js') }}"></script>

    <!-- Laravel Echo -->
    <script src="{{ asset('javascript/pusher.min.js') }}"></script>

    <!-- Page specific script -->
    <script src="{{ asset('javascript/dashboard.js') }}"></script>
    <script src="{{ asset('javascript/menuDashboard/guest.js') }}"></script>
    <script src="{{ asset('javascript/menuDashboard/egress.js') }}"></script>
    <script src="{{ asset('javascript/menuDashboard/transfers.js') }}"></script>

</body>

</html>
