@extends('layouts.appAdmin')

@section('content')
<div class="container-fluid" id="divUsers">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Lista de Solicitudes Obseravdas y Enviadas a Firma
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
                                <th scope="col">Id</th>
                                <th scope="col">Rut Contratista</th>
                                <th scope="col">Contratista</th>
                                <th scope="col">Proyecto</th>
                                <th scope="col">N° Contrato</th>
                                <th scope="col">Fecha Recepción</th>
                                <th scope="col">Tipo de Solcitud</th>
                                <th scope="col">Periodo a Certificar</th>
                                <th scope="col">Estado</th>
                                
                                <th scope="col">Bitácora</th>
                                <th scope="col">Autorizar Observar</th>
                                <th scope="col">Ver Solicitud</th>
                                <th scope="col">Certificación</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($solicitudesNuevas as $solicitud)
                            <tr>
                                <th scope="row">{{ $solicitud->id}}</th>
                                <th scope="row">{{ $solicitud->estructura->empresa->rut}}</th>
                                <th scope="row">{{ $solicitud->estructura->empresa->nombre}}</th>
                                <th scope="row">{{ $solicitud->estructura->proyecto->proyecto}}</th>
                                <th scope="row">{{ $solicitud->estructura->contrato}}</th>
                                <th scope="row">{{ $solicitud->fechaEnvio}}</th>
                                <th>
                                @if($solicitud->usuconformulario->formulario==1)
                                    Certificación
                                @else
                                    No Disponible
                                @endif
                                </th>  
                                <th scope="row">{{ $solicitud->mes}}-{{ $solicitud->ano}}</th> 
                                <th scope="row">
                                @if ($solicitud->estado=="Guardada")
                                        INICIADA
                                    
                                    @elseif ($solicitud->estado=="Enviada")
                                        RECIBIDO
                                    @elseif($solicitud->estado=="Asignada")
                                        EN REVISION
                                        @elseif($solicitud->estado=="Rechazada")
                                        CON OBSERVACIONES
                                    @elseif($solicitud->estado=="Liberada")
                                        APROBADA
                                        @elseif($solicitud->estado=="Aprobada")
                                        ENVIADA A FIRMA
                                
                                @endif
                                </th>
                              
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
                                            <!-- @if ($solicitud->estado=="Rechazada")
                                                @can('SolicitudesFinalizadas.crud')<a href="{{ route('SolicitudesInspector.edit',$solicitud->id)}}" class="btn btn-sm btn-success"><i class="fas fa-user-check" ></i></a>@endcan
                                                                                            
                                            @endif -->
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
                            <th>
                            
                            <center><a href="{{ route('solicitudesAdmin.show',$solicitud->id)}}" class="btn btn-sm btn-secondary"><i class="fas fa-eye"></i></a></center>
                            



                            <!-- @foreach($solicitud->solicituddocumento as $documento)
                               
                           
                            <a href="{{ '/Archivos/'.$solicitud->ano.'/'.$documento->documento }}" class="btn btn-outline-secondary btn-sm mt-1" placeholder="{{ $documento->tipodocumento}}" target="_blank">{{ $documento->tipodocumento}}</a></br><!-- <i class="far fa-file-alt"></i>-->
                               
                                
                       <!--     @endforeach -->
                        </th>
                        <!-- inicio botones de certificacion -->
                        <th scope="row">
                                    <div class="col-xs-12 col-md-4 center-text">
                                       <!-- Button trigger modal -->
                                    @can('administradorMenu.index')
                                        <!-- @if($solicitud->certificadoNombre==null)
                                            <center>
                                                <button type="button" class="btn btn-sm btn-dark" data-toggle="modal" data-target="#exampleModalCenter{{$solicitud->id}}">
                                                    |<i class="fas fa-clipboard-list"></i>
                                                </button>
                                            </center>
                                        @endif -->
                                        @if($solicitud->certificadoNombre!=null AND $solicitud->estado=="Rechazada")
                                            <form action="{{ route('certificado.rechazado.edicion') }}" method="post">
                                            {{csrf_field()}}
                                                <input type="hidden" value="{{ $solicitud->certificadoNombre }}" name="certificado_id">
                                                <input type="submit" value="Cert. Observado," class="btn btn-danger btn-sm mr-5">
                                            </form> 
                                        @endif
                                    @endcan
                                    
                                        <!-- @can('SolicitudesFinalizadas.crud')<a href="{{ route('CertificarSolicitud.create',$solicitud->id)}}" class="btn btn-sm btn-danger"><i class="fas fa-clipboard-list"></i></a>@endcan -->
                                    </div>
                                
                                </th>
                                    <!-- fin botones de certificacion                                   -->
                                </td>
                           
                            </tr>
                        @endforeach    
                        </tbody>
                        <tfoot>
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
                        </tfoot>
                    </table>
                    <!-- fin contenido  -->
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection