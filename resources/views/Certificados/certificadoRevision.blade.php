@extends('layouts.appAdmin')

@section('content')
<div class="container-fluid" id="divUsers">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Revisión y Firma del Certificado
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

    @foreach($certificado as $cert) 
        <form method="post" action="">
        @CSRF
			<div class="col-xs-12 col-md-12" id="principal">
               <div class="row">

                    <div class="col-xs-12 col-md-12">
                        <div class="card mt-2">
                            <div class="card-header">
                            Certificado: <h2><strong>C-{{ $cert->id}}</strong></h2>
                            <input type="hidden" name="certificado_id" value="{{ $cert->id }}">
                            <input type="hidden" name="certificadoReemplazo" value="{{ $certificadoReemplazo }}">
                            </div>
                           

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-md-2 ml-2">
                                        Mes :
                                           <input type="text" readonly name="mes" value="@if($cert->mes==1) ENERO @elseif($cert->mes==2) FEBRERO @elseif($cert->mes==3) MARZO @elseif($cert->mes==4) ABRIL @elseif($cert->mes==5) MAYO @elseif($cert->mes==6) JUNIO @elseif($cert->mes==7) JULIO @elseif($cert->mes==8) AGOSTO @elseif($cert->mes==9) SEPTIEMBRE @elseif($cert->mes==10) OCTUBRE @elseif($cert->mes==11) NOVIEMBRE @elseif($cert->mes==12) DICIEMBRE  @endif" class="form-control">
                                    </div>
                                    <div class="col-xs-12 col-md-2">
                                        Año
                                        <input type="text" readonly name="anio" value="{{ $cert->anio}}"  class="form-control">
                                    </div>

                                    <div class="col-xs-12 col-md-7 ml-2 mb-2">
                                        Proyecto
                                        <input type="text" readonly value="{{ $cert->estructura->proyecto->proyecto }}" class="form-control">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="col-xs-12 col-md-12 mt-2">
                        <div class="card mt-2">
                            <div class="card-header">
                                Identificación del Número de Solicitud: <label><input type="text" name="solicitud_id"  class="form-control"  readonly="readonly" value="{{ $cert->solicitud_id}}"></label>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-md-2 ml-2 mt-2">
                                        Rut
                                        <input type="text" readonly  class="form-control" value="{{ $cert->estructura->empresa->rut }}">
                                       
                                    </div>
                                    <div class="col-xs-12 col-md-6  mt-2">
                                        Nombre ó Razón Social
                                        <input type="text" readonly value="{{ $cert->estructura->empresa->nombre }}" class="form-control">
                                    </div>
                                    <div class="col-xs-12 col-md-3  mt-2">
                                        Teléfono
                                        <input type="text" readonly value="{{ $cert->estructura->empresa->telefonos }}" class="form-control">
                                    </div>
                                    <div class="col-xs-12 col-md-4 ml-2 mt-2">
                                        Dirección
                                        <input type="text" readonly value="{{ $cert->estructura->empresa->direccion }}" class="form-control">
                                    </div>
                                    <div class="col-xs-12 col-md-4  mt-2">
                                        Nombre Contacto
                                        <input type="text" readonly value="{{ $cert->estructura->empresa->nomContacto }}" class="form-control">
                                    </div>
                                    <div class="col-xs-12 col-md-3 mb-2  mt-2">
                                        Email
                                        <input type="text" readonly value="{{ $cert->estructura->empresa->emailContacto }}" class="form-control">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12 mt-2">
                        <div class="card">
                            <div class="card-header">
                            Identificación del Proyecto


                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-md-2 ml-2 mt-2">
                                    N°Contrato
                                        <input type="text" readonly value="{{ $cert->estructura->contrato }}" class="form-control">
                                    </div>
                                    <div class="col-xs-12 col-md-6  mt-2">
                                    Proyecto
                                        <input type="text" readonly value="{{ $cert->estructura->proyecto->proyecto }}" class="form-control">
                                    </div>
                                    <div class="col-xs-12 col-md-3 mb-2 mt-2">
                                    División
                                        <input type="text" readonly class="form-control" value="">
                                    </div>
                                    <div class="col-xs-12 col-md-11 mb-2 ml-2">
                                    Descripción del Servicio
                                        <input type="text" readonly class="form-control"  value="{{ $cert->estructura->empresa->especialidad }}">
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12 mt-2">
                        <div class="card">
                            <div class="card-header">
                            Identficación de la Empresa Mandante
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-md-2 ml-2 mt-2">
                                    Rut
                                        <input type="text" readonly  class="form-control" value="{{ $cert->estructura->proyecto->empresa->rut }}">
                                       
                                    </div>
                                    <div class="col-xs-12 col-md-9  mt-2">
                                    Nombre ó Razón Social
                                        <input type="text" readonly  value="{{ $cert->estructura->proyecto->empresa->nombre }}" class="form-control">
                                    </div>
                                    <div class="col-xs-12 col-md-8 mb-2 ml-2 mt-2">
                                        Dirección
                                        <input type="text" readonly  value="{{ $cert->estructura->proyecto->empresa->direccion }}" class="form-control">
                                    </div>
                                    <div class="col-xs-12 col-md-3 mb-2 mt-2">
                                    Teléfono
                                        <input type="text" readonly value="{{ $cert->estructura->proyecto->empresa->telefonos }}"  class="form-control">
                                    </div>
                                    <div class="col-xs-12 col-md-5 mb-2 ml-2 mt-2">
                                        Contacto
                                        <input type="text" readonly value="{{ $cert->estructura->proyecto->empresa->nomContacto }}" class="form-control">
                                    </div>
                                    <div class="col-xs-12 col-md-6 mb-2 mt-2">
                                    Email
                                        <input type="text" readonly value="{{ $cert->estructura->proyecto->empresa->emailContacto }}" class="form-control">
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-12 mt-2">
                        <div class="card">
                            <div class="card-header">
                            Identficación del Contratista
                            </div>
                            
                           @if($cert->estructura->contratistasubcontrato_id==null)
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-2 ml-2 mt-2">
                                            Rut
                                                <input type="text" readonly class="form-control" >
                                            </div>
                                            <div class="col-xs-12 col-md-9 mb-2 mt-2">
                                            Nombre ó Razón Social
                                                <input type="text" readonly class="form-control">
                                            </div>

                                        </div>
                                    </div>
                            @else  
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-2 ml-2 mt-2">
                                            Rut
                                                <input type="text" readonly value="{{ $cert->estructura->contratistasubcontrato->rut }}" class="form-control" >
                                            </div>
                                            <div class="col-xs-12 col-md-9 mb-2 mt-2">
                                            Nombre ó Razón Social
                                                <input type="text" readonly value="{{ $cert->estructura->contratistasubcontrato->nombre }}" class="form-control">
                                            </div>

                                        </div>
                                    </div>
                            @endif

                        </div>
                    </div>


                    <div class="col-xs-12 col-md-12 mt-2">
                      
                            <div class="card">
                                <div class="card-header">
                                Nómina de Trabajadores Mes actual
                                </div>
                                <div class="card-body">
                                <table class="table" id="tabla_trabajadores_delmes">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">N</th>
                                            <th scope="col">Rut</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Cargo</th>
                                            <th scope="col">Estado</th>
                                            <th scope="col">Total Imponible</th>
                                            <th scope="col">Total Haber</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                            $num=1;
                                            $totalH=0;
                                            $totalI=0;
                                        @endphp
                                        @foreach($cert->empleadoscertificado as $empleadosActuales)
                                            @if ($empleadosActuales->hojaNomina==1)
                                                <tr>
                                                    <th scope="col"><input type="text" value="<?php echo $num++ ?>" class="form-control" readonly>  </th>
                                                    <th scope="col"><input type="text" value="{{ $empleadosActuales->rut }}" class="form-control" readonly ></th>
                                                
                                                    <th scope="col"><input type="text" value="{{ $empleadosActuales->nombre }}" class="form-control" readonly ></th>
                                                
                                                    <th scope="col"><input type="text" value="{{ $empleadosActuales->cargo }}" class="form-control" readonly ></th>
                                                    <th scope="col"><input type="text" value="{{ $empleadosActuales->estado }}" class="form-control" readonly ></th>
                                                
                                                    <th scope="col"><input type="text" value="{{ $empleadosActuales->totalImponibles }}" class="form-control" readonly ></th>
                                                    <?php $totalI = $totalI + $empleadosActuales->totalImponibles ?>
                                                    <th scope="col"><input type="text" value="{{ $empleadosActuales->totalHaberes }}" class="form-control" readonly ></th>
                                                    <?php $totalH = $totalH + $empleadosActuales->totalHaberes ?>                                               
                                                </tr>
                                            @endif
                                        @endforeach 
                                      

                                    </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>
               <div class="row">
                    <div class="col-xs-12 col-md-4 mt-2">
                        Totales Imponibles :<input type="number" style="text-align:right"  value="<?php echo $totalI ?>" class="form-control" readonly="readonly">
                    </div>
                    <div class="col-xs-12 col-md-4 mt-2">
                        Totales Haber : <input type="number" style="text-align:right" value="<?php echo $totalH ?>" class="form-control" readonly="readonly">
                    </div>

                    <div class="col-xs-12 col-md-4 mt-2">
                        Total a Certificar:<input type="number" style="text-align:right" value="<?php echo $num-1 ?>" class="form-control" readonly="readonly">
                    </div>
                </div>

            <div class="row">
                <div class="col-xs-12 col-md-12 mt-3">
                    <!--<input type="button" class="btn btn-primary" value="Traer Sin Información/Desvinculados" id="trae_acu">-->
                        <div class="card">
                            <div class="card-header">
                            Nómina de Trabajadores sin Información Mes Actual

                            </div>
                            <div class="card-body">
                            <table class="table" id="tabla_trabajadores_sininfo">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">N</th>
                                        <th scope="col">Rut</th>
                                        <th scope="col">Nombre</th>
                                        
                                        <th scope="col">Estado</th>
                                        <th scope="col">Causal</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                @php 
                                    $num=1;
                                    $totalH=0;
                                    $totalI=0;
                                @endphp
                                @foreach($cert->empleadoscertificado as $empleadosActuales)
                                        @if ($empleadosActuales->hojaNomina==2)
                                            <tr>
                                                <th scope="col"><input type="text" value="<?php echo $num++ ?>" class="form-control" readonly>  </th>
                                                <th scope="col"><input type="text" value="{{ $empleadosActuales->rut }}" class="form-control" readonly></th>
                                               
                                                <th scope="col"><input type="text" value="{{ $empleadosActuales->nombre }}" class="form-control" readonly></th>
                                               
                                               
                                                <th scope="col"><input type="text" value="Desvinculado" class="form-control" readonly></th>
                                               
                                                <th scope="col"><input type="text" value="{{ $empleadosActuales->estado }}" class="form-control" readonly></th>
                                            </tr>
                                        @endif
                                @endforeach         
                                        
                                           
                                    </tbody>

                                </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-4 mt-2">
                        Total a Certificar:<input type="number" style="text-align:right" value="<?php echo $num-1 ?>" class="form-control" readonly="readonly">
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-12 mt-2">
                        <div class="card text-center">
                            <div class="card-header">
                                Cálculo de Movimientos del Mes
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <td class="text-left">1.- Observaciones Remuneracionales</td>
                                        <td><label>Monto Remuneracional</label></td>
                                    </tr>
                                    <tr>

                                        <td><input type="text"  class="form-control" value="{{ $cert->obs1 }}" size="100"><br/>
                                        <!-- <input type="text" readonly class="form-control" value="" name="obs_rem2" id="obs_rem2" size="100"> -->
                                    </td>
                                        <td><input type="text"  class="form-control" readonly value="{{ $cert->montoRemuneracional }}"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">2.- Observaciones Previsionales</td>
                                        <td>Monto Previsional</td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" class="form-control"  value="{{ $cert->obs2 }}" size="100"><br/></td>
                                        <td><input type="text" class="form-control" readonly  value="{{ $cert->montoPrevisional }}"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">3.- No presentación de Documentos</td>
                                    </tr>
                                        
                                    <tr>
                                        <td><input type="text" class="form-control" value="{{ $cert->obs3 }}" size="100"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">4.-Observaciones Administrativas</td>
                                    </tr>
                                    <tr>
                                        <!-- <td><input type="text" class="form-control" id="obs_adm" value="" name="obs_adm" size="100"></td> -->
                                    </tr>
                                    <tr>
                                        <td><input type="text" class="form-control" value="{{ $cert->obs4 }}" size="100"></td>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td>Documentación Revisada</td>
                                                </tr>
                                                  
                                                        <tr>
                                                            <td><center>Contratos</br></center><input type="checkbox"  disabled class="form-control" @if($cert->vistoContrato=='on') checked @endif></td>
                                                            <td><center>Finiquitos</br></center><input type="checkbox" disabled  class="form-control" @if($cert->vistoFiniquito=='on') checked @endif></td>
                                                            <td><center>Planilla de Sueldos</br></center><input type="checkbox" disabled  class="form-control" @if($cert->vistoSueldo=='on') checked @endif></td>
                                                            <td><center>Cotizaciones Previsionales</br></center><input type="checkbox" disabled  class="form-control" @if($cert->vistoPrevision=='on') checked @endif></td>
                                                        </tr>
                                                
                                            </table>
                                    </tr>
                                </table>

                            </div>

                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6 mt-2">
                        <div class="card text-center">
                            <div class="card-header">
                            Movimientos del Personal Mensual

                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Mes Revisado </th>
                                        <th><input type="text" readonly value="@if($cert->mes==1) ENERO @elseif($cert->mes==2) FEBRERO @elseif($cert->mes==3) MARZO @elseif($cert->mes==4) ABRIL @elseif($cert->mes==5) MAYO @elseif($cert->mes==6) JUNIO @elseif($cert->mes==7) JULIO @elseif($cert->mes==8) AGOSTO @elseif($cert->mes==9) SEPTIEMBRE @elseif($cert->mes==10) OCTUBRE @elseif($cert->mes==11) NOVIEMBRE @elseif($cert->mes==12) DICIEMBRE  @endif-{{$cert->anio}}" class="form-control" class="largo"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th>Dotación Mes Anterior</th>
                                        <th><input type="text" readonly value="{{$cert->empleadosMesAnterior }}" class="form-control" class="largo"></th>
                                    </tr>
                                    <tr>
                                        <th>Contrataciones - Ingresos x Traslados</th>
                                        <th><input type="number" readonly value="{{$cert->empleadoNuevos }}" class="form-control" class="corto"></th>
                                    </tr>
                                    <tr>
                                        <th>Total Revisados</th>
                                        <th><input type="number" readonly value="{{ $cert->totalRevizados }}" class="form-control" class="corto"></th>
                                    </tr>
                                    <tr>
                                        <th>Retiros - Finiquitos - Traslados</th>
                                        <th><input type="text" readonly value="{{$cert->retirosFiniquitos }}" class="form-control" class="corto"></th>
                                    </tr>
                                    <tr>
                                        <th>Dotación Final del Mes</th>
                                        <th><input type="text" readonly value="{{$cert->dotacionFinal }}" class="form-control" class="corto"></th>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                                <div class="card-footer text-muted">
                                    
                                </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-6 mt-2">
                        <div class="card border-primary mb-3">
                                <div class="card-header">Acciones con el Certificado. <strong>Ultimo Periodo Certificado: @if(isset($periodo)) {{$periodo}} @endif</strong>  <a href="../{{$rutaArchivo}}" target="_blank">VER</a></div>
                                    <div class="card-body text-primary text-center">
                                                    <div class=" row shadow">
                                                        </br>
                                                        <input type="submit" id="verCertificadoR" target="_blank" class="btn btn-primary mr-5 ml-2" onclick = "this.form.action = '{{ route('ver.certificado')}}'" value="Ver Certificado" />
                                                        @if($cert->abreviacion!='DEREEMPLAZO-')
                                                            <input type="submit" target="_blank" class="btn btn-danger" onclick = "this.form.action = '{{ route('rechazo.certificado')}}'" value="Rechazar Certificado" />
                                                            </br>
                                                            @if ($cert->observacionRechazo!='')
                                                                <textarea class="form-control mt-2 mb-3 ml-2 mr-2" required name="observacionRechazo">{{$cert->observacionRechazo}}</textarea>
                                                            @else
                                                                <textarea id="textareaRechazo" class="form-control mt-2 mb-3 ml-2 mr-2" required name="observacionRechazo" placeholder="Escriba aquí observación del Rechazo"></textarea>
                                                            @endif
                                                        @else
                                                        <input type="submit" target="_blank" class="btn btn-danger mb-2" onclick = "this.form.action = '{{ route('rechazo.certificadoReemplazo')}}'" value="Rechazar Certificado de Reemplazo" />
                                                           
                                                        @endif
                                                    </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-xs-12 col-md-4">
                                                                <label for="">Nómina Extendida</label>
                                                                <select class="form-control" disabled name="nominaExtendida">
                                                                    <option value="{{ $cert->nominaExtendida }}">{{ $cert->nominaExtendida }}</option>
                                                                  
                                                                </select>
                                                            </div>
                                                            <div class="col-xs-12 col-md-4">
                                                                <label for="">Segunda Nómina</label>
                                                                <select class="form-control" disabled name="segundaNomina">
                                                                    <option value="{{ $cert->segundaNomina }}">{{ $cert->segundaNomina }}</option>
                                                                    
                                                                </select>
                                                            </div>
                                                            <div class="col-xs-12 col-md-4">
                                                                <label for="">Contrato Visible</label>
                                                                <select class="form-control" disabled name="contratoVisible">
                                                                    <option value="{{ $cert->contratoVisible }}">{{ $cert->contratoVisible }}</option>
                                                                   
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <div class="row mt-3 shadow">
                                                        
                                                        <div class="row mt-2">
                                                            <!--<input type="submit" class="btn btn-success mt-2 mb-2" value="Firmar Certificado"> -->
                                                            <div class="col-xs-12 col-md-4">
                                                                Fecha Emisión<input type="date" name="fEmision" value="<?php echo date("Y-m-d");?>" class="form-control" >
                                                            </div>
                                                            <div class="col-xs-12 col-md-4">
                                                                Fecha Inicio Insp.<input type="date" name="fInicioInspeccion" value="<?php echo date("Y-m-d");?>" class="form-control" >
                                                            </div>
                                                            <div class="col-xs-12 col-md-4">
                                                                Fecha Termino Insp.<input type="date" name="fTerminoInspeccion" value="<?php echo date("Y-m-d");?>" class="form-control" >
                                                            </div>
                                                        </div>
                                                       
                                                    </br>
                                                        <div class="col-xs-12 col-md-12 mt-3">
                                                            @if($certificadoReemplazo==NULL)
                                                            <!-- <input type="button" id="firmarCertificado" class="btn btn-success mr-5  mb-3" onclick = "" value="Firmar Certificado para Disponibilizar" /> -->
                                                            <input type="submit" id="firmarCertificado" class="btn btn-success mr-5  mb-3" onclick = "this.form.action = '{{ route('firma.certificado')}}'" value="Firmar Certificado para Disponibilizar" />
                                                            @else
                                                                <input type="submit" id="firmarCertificado" class="btn btn-success mr-5  mb-3" onclick = "this.form.action = '{{ route('firma.certificado.reemplazo')}}'" value="Firmar Certificado para Disponibilizar" />
                                                            @endif
                                                        </div>
                                                        <div class="col-xs-12 col-md-12 mt-1 mb-3">
                                                           <input type="number" class="form-control" name="factura" placeholder="N° Factura">
                                                        </div>
                                                        </br>
                                                    </div>
                                                    <p class="mt-3"> 
                                                        <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                            Revisar Evidencia
                                                        </a>
                                                    </p>
                                                        <div class="collapse" id="collapseExample">
                                                            <div class="card card-body">
                                                                <table class="table table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                        <!-- <th scope="col">#</th> -->
                                                                        <th scope="col">Fecha Carga</th>
                                                                        <th scope="col">Nombre</th>
                                                                        <!-- <th scope="col">Handle</th> -->
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody> 
                                                                    @foreach($evidencia as $documento)
                                                                        <tr>
                                                                            <!-- <th scope="row">1</th> -->
                                                                            <!-- <td>Mark</td> -->
                                                                            <td>{{ $documento->created_at }} </td>
                                                                            <td><a href="../{{ $documento->ubicacion }}{{ $documento->documento }}" target="_blank">{{ $documento->documento }}</a></td>
                                                                        </tr>
                                                                    @endforeach  
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                    </div>
                                </div>
                        </div>
                    <div>
        </form>        
    @endforeach            
    <!-- fin contenido  -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection