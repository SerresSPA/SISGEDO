@extends('layouts.appAdmin')

@section('content')
<div class="container-fluid" id="divUsers">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Lista de Solicitudes Inspectores
                    <span class="float-right">
                        <!-- @can('usuconforms.create')
                            <a href="{{ route('usuconforms.create')}}" class="btn btn-sm btn-primary mr-auto ml-auto">Asignar Contratistas a Usuarios para Administrar Solicitudes</a>
                        @endcan   -->
                    </span>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Contenido -->
                    <table class="table table-hover" id="example">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Id</th>
                                <th scope="col">Mandante</th>
                                <th scope="col">Contratista</th>
                                <th scope="col">Proyecto</th>
                                <th scope="col">N° Contrato</th>
                                <th scope="col">Tipo de Solcitud</th>
                                <th scope="col">Periodo a Certificar</th>
                                <th scope="col">Fecha Asignación</th>
                                <th scope="col">Estado</th>
                                <th scope="col">N° de Envíos</th>
                                <th scope="col">Observación del Rechazo</th>
                                <th scope="col">Bitácora</th>
                                <th scope="col">Autorizar Observar</th>
                                <th scope="col">Certificación</th>
                                <th scope="col">-</th>
                            </tr>
                        </thead>
                        <tbody>
                        <!-- solicitudes rechazadas por Inpector que firma -->
                        @foreach($solicitudRechazadaFirma as $solicitud)
                            <tr style="color:red"> 
                                <th></th>
                                <th scope="row">{{ $solicitud->id}}</th>
                                <th scope="row">{{ $solicitud->estructura->proyecto->empresa->nombre}}</th>
                                <th scope="row">{{ $solicitud->estructura->empresa->rut}}, {{ $solicitud->estructura->empresa->nombre}}</th>
                                <th scope="row">{{ $solicitud->estructura->proyecto->proyecto}}</th>
                                <th scope="row">{{ $solicitud->estructura->contrato}}</th>
                            <th>
                                    @if($solicitud->usuconformulario->formulario==1)
                                        @if ($solicitud->identificacion=="Declaracion")
                                            Solicitud de Certificación sin Movimiento
                                        @else
                                            Certificación Laboral
                                        @endif
                                    @else
                                        Formulario Único de Certificación de Documentos
                                    @endif
                                </th>  
                                <th scope="row">{{ $solicitud->mes}}-{{ $solicitud->ano}}</th> 
                                <th scope="row">{{ $solicitud->fechaAsignacion}}</th>
                                <th scope="row">EN REVISION</th>
                                <th scope="row">Env: {{ $solicitud->nreenviada}}</th>
                                <th scope="row">@if($solicitud->observacionRechazo!='NULL') {{ $solicitud->observacionRechazo}} @endif</th>
                                <th>
                                        <center><a href="{{ route('bitacora.index',$solicitud->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-clipboard-list"></i></a></center>
                                </th>
                                <th scope="row">
                                    <center>
                                        <div class="row">
                                            <!-- <div class="col-xs-12 col-md-4">
                                                @can('SolicitudesInspector.show')<a href="{{ route('SolicitudesInspector.show',$solicitud->id)}}" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>@endcan
                                            </div> -->
                                            <div class="col-xs-12 col-md-4">
                                                @can('SolicitudesFinalizadas.crud')<a href="{{ route('SolicitudesInspector.edit',$solicitud->id)}}" class="btn btn-sm btn-success"><i class="fas fa-user-check"></i></a>@endcan
                                            </div>
                                            <!-- <div class="col-xs-12 col-md-4">
                                                @can('admsol.destroy')
                                                    <center>
                                                    <button class="btn btn-sm btn-danger" onclick="EliminarSolicitudCliente({{$solicitud->id}})"><i class="far fa-trash-alt"></i></button>
                                                    </center>
                                                @endcan 
                                            </div> -->
                                            <!-- <div class="col-xs-12 col-md-4">
                                                @can('admsol.edit')<a href="{{ route('admsol.edit',$solicitud->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-user-check"></i></a>@endcan
                                            </div> -->
                                        </div>
                                    </center>
                                </th>
                                <th scope="row">
                                    <div class="col-xs-12 col-md-4 center-text">
                                       <!-- Button trigger modal -->
                                    @can('administradorMenu.index')
                                        @if($solicitud->certificadoNombre==null)
                                            <center>
                                                <button type="button" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#exampleModalCenter{{$solicitud->id}}">
                                                    |<i class="fas fa-clipboard-list"></i>
                                                </button>
                                            </center>
                                        @else
                                            <form action="{{ route('certificado.rechazado.edicion') }}" method="post">
                                            {{csrf_field()}}
                                                <input type="hidden" value="{{ $solicitud->certificadoNombre }}" name="certificado_id">
                                                <input type="submit" value="Certificado Observado" class="btn btn-danger btn-sm mr-5">
                                            </form> 
                                        @endif
                                    @endcan
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalCenter{{$solicitud->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><center>Cargue Planilla para Certificar Trabajadores del Periodo de la Solicitud</center></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Contenido -->
                                           
                                                    <form method="post" action="{{route('carga.empleados')}}" enctype="multipart/form-data">
                                                            {{csrf_field()}}
                                                        <div class="row">
                                        
                                                            <div  class="col-xs-12 col-md-4">

                                                                <input type="file" id="excel" required name="excel">
                                                                <input type="hidden" id="solicitud_id" name="solicitud_id" value="{{$solicitud->id}}">
                                                                <input type="hidden" id="mes" name="mes" value="{{$solicitud->mes}}">
                                                                <input type="hidden" id="anio" name="anio" value="{{$solicitud->ano}}">
                                                                <input type="hidden" id="estructura_id" name="estructura_id" value="{{$solicitud->estructura_id}}">
                                                            </div>
                                                            <div class="col-xs-12 col-md-12">
                                                                <input type="submit" class="btn btn-primary mt-2" value="Cargar Planilla de Trabajadores" id="btn_enviar" style="padding: 10px 20px;">
                                                            </div>
                                                        </div>
                                                    </form>

                                            
                                            <!-- fin contenido  -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!-- fin modal -->
                                        <!-- @can('SolicitudesFinalizadas.crud')<a href="{{ route('CertificarSolicitud.create',$solicitud->id)}}" class="btn btn-sm btn-danger"><i class="fas fa-clipboard-list"></i></a>@endcan -->
                                    </div>
                                
                                </th>
                                <th></th>
                              
                            </tr>
                        @endforeach
                        <!-- fin rechazo que firma -->
                          <!-- solicitudes reenviadas --> 
                          @foreach($solicitudesReenviadas as $solicitud)
                            <tr style="color:blue"> 
                                <th></th>
                                <th scope="row">{{ $solicitud->id}}</th>
                                <th scope="row">{{ $solicitud->estructura->proyecto->empresa->nombre}}</th>
                                <th scope="row">{{ $solicitud->estructura->empresa->rut}}, {{ $solicitud->estructura->empresa->nombre}}</th>
                                <th scope="row">{{ $solicitud->estructura->proyecto->proyecto}}</th>
                                <th scope="row">{{ $solicitud->estructura->contrato}}</th>
                                <th>
                                    @if($solicitud->usuconformulario->formulario==1)
                                        @if ($solicitud->identificacion=="Declaracion")
                                            Solicitud de Certificación sin Movimiento
                                        @else
                                            Certificación Laboral
                                        @endif
                                    @else
                                        Formulario Único de Certificación de Documentos
                                    @endif
                                </th>  
                                <th scope="row">{{ $solicitud->mes}}-{{ $solicitud->ano}}</th> 
                                <th scope="row">{{ $solicitud->fechaAsignacion}}</th>
                                <th scope="row">REENVIADA</th>
                                <th scope="row">Env: {{ $solicitud->nreenviada}}</th>
                                <th scope="row">{{ $solicitud->observacionRechazo}}</th>
                                <th>
                                        <center><a href="{{ route('bitacora.index',$solicitud->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-clipboard-list"></i></a></center>
                                </th>
                                <th scope="row">
                                    <center>
                                        <div class="row">
                                            <!-- <div class="col-xs-12 col-md-4">
                                                @can('SolicitudesInspector.show')<a href="{{ route('SolicitudesInspector.show',$solicitud->id)}}" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>@endcan
                                            </div> -->
                                            <div class="col-xs-12 col-md-4">
                                                @can('SolicitudesFinalizadas.crud')<a href="{{ route('SolicitudesInspector.edit',$solicitud->id)}}" class="btn btn-sm btn-success"><i class="fas fa-user-check"></i></a>@endcan
                                            </div>
                                            <!-- <div class="col-xs-12 col-md-4">
                                                @can('admsol.destroy')
                                                    <center>
                                                    <button class="btn btn-sm btn-danger" onclick="EliminarSolicitudCliente({{$solicitud->id}})"><i class="far fa-trash-alt"></i></button>
                                                    </center>
                                                @endcan 
                                            </div> -->
                                            <!-- <div class="col-xs-12 col-md-4">
                                                @can('admsol.edit')<a href="{{ route('admsol.edit',$solicitud->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-user-check"></i></a>@endcan
                                            </div> -->
                                        </div>
                                    </center>
                                </th>
                                <th scope="row">
                                    <div class="col-xs-12 col-md-4 center-text">
                                       <!-- Button trigger modal -->
                                   <!-- @can('administradorMenu.index') -->
                                        @if($solicitud->certificadoNombre==null)
                                            <center>
                                                <button type="button" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#exampleModalCenter{{$solicitud->id}}">
                                                    |<i class="fas fa-clipboard-list"></i>
                                                </button>
                                            </center>
                                        @else
                                            <form action="{{ route('certificado.rechazado.edicion') }}" method="post">
                                            {{csrf_field()}}
                                                <input type="hidden" value="{{ $solicitud->certificadoNombre }}" name="certificado_id">
                                                <input type="submit" value="Certificado Observado" class="btn btn-danger btn-sm mr-5">
                                            </form> 
                                        @endif
                                   <!--  @endcan -->
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalCenter{{$solicitud->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><center>Cargue Planilla para Certificar Trabajadores del Periodo de la Solicitud</center></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Contenido -->
                                           
                                                    <form method="post" action="{{route('carga.empleados')}}" enctype="multipart/form-data">
                                                            {{csrf_field()}}
                                                        <div class="row">
                                        
                                                            <div  class="col-xs-12 col-md-4">

                                                                <input type="file" id="excel" required name="excel">
                                                                <input type="hidden" id="solicitud_id" name="solicitud_id" value="{{$solicitud->id}}">
                                                                <input type="hidden" id="mes" name="mes" value="{{$solicitud->mes}}">
                                                                <input type="hidden" id="anio" name="anio" value="{{$solicitud->ano}}">
                                                                <input type="hidden" id="estructura_id" name="estructura_id" value="{{$solicitud->estructura_id}}">
                                                            </div>
                                                            <div class="col-xs-12 col-md-12">
                                                                <input type="submit" class="btn btn-primary mt-2" value="Cargar Planilla de Trabajadores" id="btn_enviar" style="padding: 10px 20px;">
                                                            </div>
                                                        </div>
                                                    </form>

                                            
                                            <!-- fin contenido  -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!-- fin modal -->
                                        <!-- @can('SolicitudesFinalizadas.crud')<a href="{{ route('CertificarSolicitud.create',$solicitud->id)}}" class="btn btn-sm btn-danger"><i class="fas fa-clipboard-list"></i></a>@endcan -->
                                    </div>
                                
                                </th>
                                <th></th>
                              
                            </tr>
                        @endforeach 
                        <!-- fin reenviadas -->
                        <!-- solicitudes nuevas  -->
                        @foreach($solicitudesNuevas as $solicitud)
                            <tr>
                                <th></th>
                                <th scope="row">{{ $solicitud->id}}</th>
                                <th scope="row">{{ $solicitud->estructura->proyecto->empresa->nombre}}</th>
                                <th scope="row">{{ $solicitud->estructura->empresa->rut}}, {{ $solicitud->estructura->empresa->nombre}}</th>
                                <th scope="row">{{ $solicitud->estructura->proyecto->proyecto}}</th>
                                <th scope="row">{{ $solicitud->estructura->contrato}}</th>
                                <th>
                                    @if($solicitud->usuconformulario->formulario==1)
                                        @if ($solicitud->identificacion=="Declaracion")
                                            Solicitud de Certificación sin Movimiento
                                        @else
                                            Certificación Laboral
                                        @endif
                                    @else
                                        Formulario Único de Certificación de Documentos
                                    @endif
                                </th>  
                                <th scope="row">{{ $solicitud->mes}}-{{ $solicitud->ano}}</th> 
                                <th scope="row">{{ $solicitud->fechaAsignacion}}</th>
                                <th scope="row">EN REVISION</th>
                                <th scope="row">Env: {{ $solicitud->nreenviada}}</th>
                                <th scope="row">{{ $solicitud->observacionRechazo}}</th>
                                <th>
                                        <center><a href="{{ route('bitacora.index',$solicitud->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-clipboard-list"></i></a></center>
                                </th>
                                <th scope="row">
                                    <center>
                                        <div class="row">
                                            <!-- <div class="col-xs-12 col-md-4">
                                                @can('SolicitudesInspector.show')<a href="{{ route('SolicitudesInspector.show',$solicitud->id)}}" class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>@endcan
                                            </div> -->
                                            <div class="col-xs-12 col-md-4">
                                                @can('SolicitudesFinalizadas.crud')<a href="{{ route('SolicitudesInspector.edit',$solicitud->id)}}" class="btn btn-sm btn-success"><i class="fas fa-user-check"></i></a>@endcan
                                            </div>
                                            <!-- <div class="col-xs-12 col-md-4">
                                                @can('admsol.destroy')
                                                    <center>
                                                    <button class="btn btn-sm btn-danger" onclick="EliminarSolicitudCliente({{$solicitud->id}})"><i class="far fa-trash-alt"></i></button>
                                                    </center>
                                                @endcan 
                                            </div> -->
                                            <!-- <div class="col-xs-12 col-md-4">
                                                @can('admsol.edit')<a href="{{ route('admsol.edit',$solicitud->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-user-check"></i></a>@endcan
                                            </div> -->
                                        </div>
                                    </center>
                                </th>
                                <th scope="row">
                                    <div class="col-xs-12 col-md-4 center-text">
                                       <!-- Button trigger modal -->
                                    @can('administradorMenu.index')
                                        @if($solicitud->certificadoNombre==null)
                                            <center>
                                                <button type="button" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#exampleModalCenter{{$solicitud->id}}">
                                                    |<i class="fas fa-clipboard-list"></i>
                                                </button>
                                            </center>
                                        @else
                                            <form action="{{ route('certificado.rechazado.edicion') }}" method="post">
                                            {{csrf_field()}}
                                                <input type="hidden" value="{{ $solicitud->certificadoNombre }}" name="certificado_id">
                                                <input type="submit" value="Certificado Observado" class="btn btn-danger btn-sm mr-5">
                                            </form> 
                                        @endif
                                    @endcan
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalCenter{{$solicitud->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><center>Cargue Planilla para Certificar Trabajadores del Periodo de la Solicitud</center></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Contenido -->
                                           
                                                    <form method="post" action="{{route('carga.empleados')}}" enctype="multipart/form-data">
                                                            {{csrf_field()}}
                                                        <div class="row">
                                        
                                                            <div  class="col-xs-12 col-md-4">

                                                                <input type="file" id="excel" required name="excel">
                                                                <input type="hidden" id="solicitud_id" name="solicitud_id" value="{{$solicitud->id}}">
                                                                <input type="hidden" id="mes" name="mes" value="{{$solicitud->mes}}">
                                                                <input type="hidden" id="anio" name="anio" value="{{$solicitud->ano}}">
                                                                <input type="hidden" id="estructura_id" name="estructura_id" value="{{$solicitud->estructura_id}}">
                                                            </div>
                                                            <div class="col-xs-12 col-md-12">
                                                                <input type="submit" class="btn btn-primary mt-2" value="Cargar Planilla de Trabajadores" id="btn_enviar" style="padding: 10px 20px;">
                                                            </div>
                                                        </div>
                                                    </form>

                                            
                                            <!-- fin contenido  -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!-- fin modal -->
                                        <!-- @can('SolicitudesFinalizadas.crud')<a href="{{ route('CertificarSolicitud.create',$solicitud->id)}}" class="btn btn-sm btn-danger"><i class="fas fa-clipboard-list"></i></a>@endcan -->
                                    </div>
                                
                                </th>
                                <th></th>
                              
                            </tr>
                        @endforeach    
                        <!-- fin nuevas  -->
                      
                        

                        </tbody>
                        <tfoot>
                            <th></th>
                            <th></th>
                            <!-- <th></th> -->
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                             <!--<th></th>
                            <th></th>
                            <th></th> -->
                        </tfoot>
                    </table>
                    <!-- fin contenido  -->
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection