@extends('layouts.appAdmin')

@section('content')
<div class="container-fluid" id="divUsers">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Lista de Solicitudes Finalizadas con Certificado ya Emitido
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
                                <th scope="col">Tipo de Solcitud</th>
                                <th scope="col">Periodo a Certificar</th>
                                <th scope="col">Contratados</th>
                                <th scope="col">Desvinvulados</th>
                                <th scope="col">Otras Causas</th>
                                <th scope="col">Total Vigentes</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Bitácora</th>
                                <th scope="col">Ver Certificado Emitido</th>
                                <th scope="col">Ver Solicitud / Certificado Reemplazado</th>
                                <th scope="col">Crear Certificado Reemplazo</th>
                                <th scope="col">Certificado Reemplazado</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($solicitudesNuevas as $solicitud)
                            <tr>
                                <th scope="row">{{ $solicitud->id}}</th>
                                <th scope="row">{{ $solicitud->estructura->empresa->rut}}</th>
                                <th scope="row">{{ $solicitud->estructura->empresa->nombre}}</th>
                                <th>
                                    @if($solicitud->usuconformulario->formulario==1)
                                        Certificación
                                    @else
                                        Formulario Único de Certificación de Documentos
                                    @endif
                                </th>  
                                @if($solicitud->usuconformulario->formulario==1)
                                <th scope="row">mes {{ $solicitud->mes}} del {{ $solicitud->ano}}</th> 
                                @else
                                <th scope="row">N/A</th> 
                                @endif
                                <!-- <th scope="row">mes {{ $solicitud->mes}} del {{ $solicitud->ano}}</th>  -->



                                <th scope="row">{{ $solicitud->contratados}}</th>
                                <th scope="row">{{ $solicitud->desvinculados}}</th>
                                <th scope="row">{{ $solicitud->otrascausas}}</th>
                                <th scope="row">{{ $solicitud->totalvigentes}}</th>
                                <th scope="row">{{ $solicitud->estado}}</th>
                                <th>
                                        <center><a href="{{ route('bitacora.index',$solicitud->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-clipboard-list"></i></a></center>
                                </th>
                                <th scope="row">
                                @if($solicitud->certificadoNombre!=null)
                                <a href="../{{$solicitud->certificadoRuta}}" target="_blank">CERTIFICADO</a>
                                @else
                                    <a href="<?php echo 'http://www.serresverificadora.cl/administrador/generador_certificado.php?ncert='.$solicitud->certificado ?>" target="_blank">CERTIFICADO</a>
                                @endif
                                </th>                 
                                <th>
                                    <center><a href="{{ route('solicitudesInspector.show',$solicitud->id)}}" class="btn btn-sm btn-secondary"><i class="fas fa-eye"></i></a></center>
                                </th>

                               <!-- certificado en Reemplazo -->
                               <th scope="row">
                                    <div class="col-xs-12 col-md-4 center-text">
                                       <!-- Button trigger modal -->
                                    @can('administradorMenu.index')
                                        @if($solicitud->certificadoNombre!=null && $solicitud->certificadoRuta!=null)
                                            <center>
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#exampleModalCenter{{$solicitud->id}}">
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
                                            <h5 class="modal-title" id="exampleModalLongTitle"><center>Cargue Planilla de Trabajadores para Realizar Certificado de Reemplazo</center></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Contenido -->
                    
                                                    <form method="post" action="{{route('carga.empleadosReemplazo')}}" enctype="multipart/form-data">
                                                            {{csrf_field()}}
                                                        <div class="row">
                                        
                                                            <div  class="col-xs-12 col-md-4">

                                                                <input type="file" id="excel" name="excel">
                                                                <input type="hidden" id="solicitud_id" name="solicitud_id" value="{{$solicitud->id}}">
                                                                <input type="hidden" id="mes" name="mes" value="{{$solicitud->mes}}">
                                                                <input type="hidden" id="anio" name="anio" value="{{$solicitud->ano}}">
                                                                <input type="hidden" name="tipo" value="DEREEMPLAZO">
                                                                <input type="hidden" id="estructura_id" name="estructura_id" value="{{$solicitud->estructura_id}}">
                                                            </div>
                                                            <div class="col-xs-12 col-md-12">
                                                                <input type="submit" class="btn btn-primary mt-2" value="Cargar Planilla de Trabajadores para Reemplazo" id="btn_enviar" style="padding: 10px 20px;">
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
                                <th>
                                @if ($solicitud->certificadoRutaReemplazo!='')
                                    
                                        <a href="../{{$solicitud->certificadoRutaReemplazo}}" target="_blank">CERTIFICADO REEMPLAZADO</a>
                                @else
                                    N/A   
                                @endif
                              </th>
                                <!-- <td>  </td> -->
                            
                                <!-- fin certificado en reemplazo -->
                            </tr>
                        @endforeach    
                        </tbody>
                    </table>
                    <!-- fin contenido  -->
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
