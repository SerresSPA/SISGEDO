<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

      
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="{{ asset('Bootstrap4TaginputPluginjQuery/tagsinput.css')}}" rel="stylesheet"> 
    <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('dropzone/dist/min/dropzone.min.css')}}">
              
                    <style>
                        table {

                        overflow-x:auto;
                        }
                        table th {
                        word-wrap: break-word;
                        max-width: 95px;
                        }
                        #grid th {
                        white-space:inherit;
                        }
                    </style>    
                    <style>
                        .dataTables_filter input { width: 400px }
                    </style>

                     <!-- CSS -->
      
                    
</head>
<body>
<!--  modal de reporte -->
<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalScrollableTitle">Reporte de Carga de Archivos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- tabla de contenido -->
                            <table class="table table-striped" id="tablaReporte">
                                <thead class="thead-dark">
                                    <tr>
                                    <!-- <th scope="col">Id</th> -->
                                    <!-- <th scope="col">Registro ID</th> -->
                                    <th scope="col">Detalle</th>
                                    <th scope="col">Archivo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                                </table>

                               
                            <!-- fin -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                        </div>
                        </div>
                    </div>
                </div>
<!-- fin -->

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Sisgedo
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    @can('administradorMenu.index')
                    <div class="dropdown">
                        <button class="mr-2 btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Administraci??n
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @can('users.index')
                                <a class="dropdown-item" href="{{ route('users.index') }}">Usuarios</a>
                            @endcan  
                            @can('roles.index')  
                                <a class="dropdown-item" href="{{ route('roles.index') }}">Roles de Usuarios</a>
                            @endcan  
                            @can('rolesprofiles.index')    
                                <a class="dropdown-item" href="{{ route('rolesprofiles.index') }}">Roles y Perfiles</a>
                            @endcan  
                            @can('empresas.index')    
                                <a class="dropdown-item" href="{{ route('empresas.index') }}">Empresas</a>
                            @endcan
                            @can('Proyectos.index')    
                                <a class="dropdown-item" href="{{ route('proyectos.index') }}">Proyectos de Mandantes</a>
                            @endcan
                            <!-- @can('formularios.index')    
                                <a class="dropdown-item" href="{{ route('formularios.index') }}">Formularios</a>
                            @endcan -->
                            @can('estructuras.index')    
                                <a class="dropdown-item" href="{{ route('estructuras.index') }}">Asignaci??n Contratistas a Proyectos </a>
                            @endcan
                            @can('usucontform.index')    
                                <a class="dropdown-item" href="{{ route('usuconforms.index') }}">Asignar usuarios y formulario a contratista</a>
                            @endcan
                            @can('admsol.index')    
                                <a class="dropdown-item" href="{{ route('admsol.index') }}">Administrar Solicitudes</a>
                            @endcan
                            @can('admsol.index')    
                                <a class="dropdown-item" href="{{ route('admsolAprobadas.index') }}">Administrar Solicitudes Aprobadas x Inspectores</a>
                            @endcan
                            @can('admsol.index')    
                                <a class="dropdown-item" href="{{ route('asolicitudesAnuladas.index') }}">Solicitudes Anuladas</a>
                            @endcan
                            @can('admsol.index')    
                                <a class="dropdown-item" href="{{ route('reasignasolicitud.index') }}">Reasignar Solicitudes</a>
                            @endcan
                            @can('admsol.index')    
                                <a class="dropdown-item" href="{{ route('busquedasolicitudesadmin.index') }}">Buscar Solicitudes</a>
                            @endcan
                            @can('admsol.index')    
                                <a class="dropdown-item" href="{{ route('eliminarsolicitudesadmin.index') }}">Anular o Eliminar Solicitudes Erroneas Extendidas por clientes</a>
                            @endcan
                            @can('admsol.index')    
                                <a class="dropdown-item" href="{{ route('SolicitudesLiberadasxFecha.filtro') }}">Solicitudes Aprobadas y Liberadas a Clientes</a>
                            @endcan
                            <!--@can('admsol.index')    
                                <a class="dropdown-item" href="{{ route('estructuras.propiedades') }}">Caracter??sticas en el Contrato</a>
                            @endcan -->
                            @can('admsol.index')    
                                <a class="dropdown-item" href="{{ route('cambiarEstado.solicitud') }}">Cambiar Estado de Solicitud</a>
                            @endcan
                            @can('admsol.index')    
                                <a class="dropdown-item" href="{{ route('asigancionsolicitudes.inspector') }}">Asignaci??n de Solicitudes a Inspectores.</a>
                            @endcan
                            <!-- @can('admsol.index')    
                                <a class="dropdown-item" href="{{ route('cargaMasivaUsuario.carga') }}">Carga Masiva de Usuarios</a>
                            @endcan -->
                            <!-- @can('admsol.index')    
                                <a class="dropdown-item" href="{{ route('cargaMasivaFactura.carga') }}">Carga Masiva de N?? de Facturas</a>
                            @endcan -->
                            <!-- @can('admsol.index')    
                                <a class="dropdown-item" href="{{ route('cargaMasivaEmpresas.carga') }}">Carga Masiva de Empresas</a>
                            @endcan -->
                           
                        </div>
                    </div>
                    @endcan 
                    @can('SolicitudesFinalizadas.crud')
                    <div class="dropdown">
                        <button class="mr-2 btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Inspector
                        </button>
                    @endcan  
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @can('SolicitudesFinalizadas.crud')
                                <a class="dropdown-item" href="{{ route('SolicitudesInspector.index') }}">Solicitudes Nuevas</a>
                            @endcan 
                            @can('SolicitudesFinalizadas.crud')
                                <a class="dropdown-item" href="{{ route('SolicitudesInspectorObsFirm.index') }}">Solicitudes Observadas y Enviadas a Firma</a>
                            @endcan 
                         
                                <a class="dropdown-item" href="{{ route('SolicitudFinalizada.index') }}">Solicitudes Finalizadas</a>
                
                            
                            
                        </div>
                    </div>
                    @can('admsol.index')    
                    <div class="dropdown mr-2 ">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Reporte
                        </button>
                    
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                           
                                <a class="dropdown-item" href="{{ route('ccolpxfechas.form') }}">Seguimientos de Solicitudes de CCOLP</a>
                                    
                        </div>
                    </div>
                    @endcan 
                    <!-- @can('SolicitudesFinalizadas.crud')     -->
                    <div class="dropdown ">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Gestor Documental
                        </button>
                    
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                           <a class="dropdown-item" href="{{ route('documentos.index') }}">Administraci??n Documentos</a>
                                <a class="dropdown-item" href="{{ route('group.index') }}">Control de Grupos para Etiquetas</a>
                                <a class="dropdown-item" href="{{ route('tags.index') }}">Control de Etiquetas</a>
                                <a class="dropdown-item" href="{{ route('cargaeinformes.index') }}">Informes de Cargas y Eliminaci??n</a>
                               
                        </div>
                    </div>
                    <!-- @endcan -->
                    
                    
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <!-- @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif -->
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
   

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js" prefer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/funciones.js') }}"></script>
    <script src="{{ asset('js/busquedaX.js') }}"></script>
    <script src="{{ asset('js/FuncionesSweetAlert.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.9.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer ></script>
    <script type="text/javascript" src="{{ asset('DataTables/Buttons-1.5.6/js/dataTables.buttons.js') }}" defer></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" defer ></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" defer ></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" defer ></script>
    <script type="text/javascript" src="{{ asset('DataTables/Buttons-1.5.6/js/buttons.html5.js') }}" defer></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="{{asset('Bootstrap4TaginputPluginjQuery/tagsinput.js')}}"></script>
    <script src="{{asset('dropzone/dist/min/dropzone.min.js')}}" type="text/javascript"></script>
    
    @include('sweet::alert')
</body>
</html>
