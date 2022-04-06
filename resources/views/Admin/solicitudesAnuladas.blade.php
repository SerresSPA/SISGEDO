@extends('layouts.appAdmin')

@section('content')
<div class="container-fluid" id="divUsers">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Lista de Solicitudes Finalizadas con Certificado ya Emitido
                    <span class="float-right">
                        <!-- @can('admsol.index')
                            <a href="{{ route('SolicitudesLiberadasxFecha.filtro') }}" class="btn btn-sm btn-primary mr-auto ml-auto">Buscar Solicitudes por Fecha</a>
                        @endcan -->
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
                            <th scope="col">Desvinculados</th>
                            <!-- <th scope="col">Otras Causas</th> -->
                            <th scope="col">Total Vigentes</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Bitácora</th>
                            <th scope="col">Ver Certificado Emitido</th>
                            <th scope="col">Ver Solicitud</th>
                            <th> 
                                Reintegrar
                            </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($solicitudes as $solicitud)
                            <tr>
                                <th scope="row">{{ $solicitud->id}}</th>
                                <th scope="row">{{ $solicitud->estructura->empresa->rut}}</th>
                                <th scope="row">{{ $solicitud->estructura->empresa->nombre}}</th>
                                <th>
                                @if($solicitud->usuconformulario->formulario==1)
                                    Certificación
                                @else
                                    No Disponible
                                @endif
                                </th>  
                                <th scope="row">mes {{ $solicitud->mes}} del {{ $solicitud->ano}}</th> 
                                <th scope="row">{{ $solicitud->contratados}}</th>
                                <th scope="row">{{ $solicitud->desvinculados}}</th>
                                <!-- <th scope="row">{{ $solicitud->otrascausas}}</th> -->
                                <th scope="row">{{ $solicitud->totalvigentes}}</th>
                                <th scope="row">{{ $solicitud->estado}}</th>
                                <th>
                                        <center><a href="{{ route('bitacora.index',$solicitud->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-clipboard-list"></i></a></center>
                                    </th>
                                <th scope="row">
                                    <a href="<?php echo 'http://www.serresverificadora.cl/administrador/generador_certificado.php?ncert='.$solicitud->certificado ?>" target="_blank">Certificado</a>
                                </th>  
                            <th>
                            
                                <center><a href="{{ route('solicitudesAdmin.show',$solicitud->id)}}" class="btn btn-sm btn-secondary"><i class="fas fa-eye"></i></a></center>
                              </th>
                              <th>
                              <center><button class="btn btn-sm btn-success" onclick="reintegrarSolicitud({{$solicitud->id}})"><i class="fa fa-reply"></i></button></center>
                              </th>

                               
                        
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