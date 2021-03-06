@extends('layouts.appAdmin')

@section('content')
<div class="container-fluid" id="divUsers">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Emisión del Certificado.
                    <span class="float-right">
                        <strong>Ultimo Periodo Certificado: @if(isset($periodo)) {{$periodo}} @endif</strong>
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
<form action="{{ route('enviar.firma') }}" method="POST">
                    <!-- Contenido -->
        @foreach($certificado as $cert)    
  
			<div class="col-xs-12 col-md-12" id="principal">
               <div class="row">

                    <div class="col-xs-12 col-md-12">
                        <div class="card mt-2">
                            <div class="card-header">
                            Certificado
                            </div>
                           

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-md-2 ml-2">
                                        Mes :
                                           <input type="text" readonly name="mes" value="@if($cert->mes==1) ENERO @elseif($cert->mes==2) FEBRERO @elseif($cert->mes==3) MARZO @elseif($cert->mes==4) ABRIL @elseif($cert->mes==5) MAYO @elseif($cert->mes==6) JUNIO @elseif($cert->mes==7) JULIO @elseif($cert->mes==8) AGOSTO @elseif($cert->mes==9) SEPTIEMBRE @elseif($cert->mes==10) OCTUBRE @elseif($cert->mes==11) NOVIEMBRE @elseif($cert->mes==12) DICIEMBRE  @endif" class="form-control">
                                    </div>
                                    <div class="col-xs-12 col-md-2">
                                        Año
                                        <input type="text" readonly value="{{$cert->ano}}"  class="form-control">
                                    </div>

                                    <div class="col-xs-12 col-md-7 ml-2 mb-2">
                                        Proyecto
                                        <input type="text" readonly value="{{$cert->estructura->proyecto->proyecto}}" class="form-control">
                                        <input type="hidden" name="estructura_id" readonly value="{{$cert->estructura_id}}" class="form-control">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
        
        @CSRF
                    <div class="col-xs-12 col-md-12 mt-2">
                        <div class="card mt-2">
                            <div class="card-header">
                                1.- Identificación del Contratista y Número de Solicitud: <label><input type="text" name="solicitud_id" id="solicitud_id" class="form-control"  readonly="readonly" value="{{$cert->id}}"></label>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-md-2 ml-2 mt-2">
                                        Rut
                                        <input type="text" readonly id="rutraz" class="form-control" value="{{$cert->estructura->empresa->rut}}" name="">
                                       
                                    </div>
                                    <div class="col-xs-12 col-md-6  mt-2">
                                        Nombre ó Razón Social
                                        <input type="text" readonly id="nomraz" value="{{$cert->estructura->empresa->nombre}}" class="form-control" name="">
                                    </div>
                                    <div class="col-xs-12 col-md-3  mt-2">
                                        Teléfono
                                        <input type="text" readonly id="telraz" value="{{$cert->estructura->empresa->telefonos}}" class="form-control" name="">
                                    </div>
                                    <div class="col-xs-12 col-md-4 ml-2 mt-2">
                                        Dirección
                                        <input type="text" readonly id="dirraz" value="{{$cert->estructura->empresa->dirección}}" class="form-control" name="">
                                    </div>
                                    <div class="col-xs-12 col-md-4  mt-2">
                                        Nombre Contacto
                                        <input type="text" readonly id="nombrecontacto" value="{{$cert->estructura->empresa->nomContacto}}" class="form-control" name="">
                                    </div>
                                    <div class="col-xs-12 col-md-3 mb-2  mt-2">
                                        Email
                                        <input type="text" readonly id="emaccli" value="{{$cert->estructura->empresa->emailContacto}}" class="form-control" name="">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12 mt-2">
                        <div class="card">
                            <div class="card-header">
                            2.- Identificación del Proyecto


                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-md-2 ml-2 mt-2">
                                    N°Contrato
                                        <input type="text" readonly id="ncon" value="{{$cert->estructura->contrato}}" class="form-control" name="">
                                    </div>
                                    <div class="col-xs-12 col-md-6  mt-2">
                                    Proyecto
                                        <input type="text" readonly id="cencos" value="{{$cert->estructura->proyecto->proyecto}}" class="form-control" name="">
                                    </div>
                                    <div class="col-xs-12 col-md-3 mb-2 mt-2">
                                    División
                                        <input type="text" id="division" readonly class="form-control" name="" value="">
                                    </div>
                                    <div class="col-xs-12 col-md-11 mb-2 ml-2">
                                    Descripción del Servicio
                                        <input type="text" id="descrip" readonly class="form-control" name="" value="">
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-12 mt-2">
                        <div class="card">
                            <div class="card-header">
                            3.- Identficación de la Empresa Mandante
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-md-2 ml-2 mt-2">
                                    Rut
                                        <input type="text" readonly id="rut_mandante" class="form-control" value="{{$cert->estructura->proyecto->empresa->rut}}" name="">
                                       
                                    </div>
                                    <div class="col-xs-12 col-md-9  mt-2">
                                    Nombre ó Razón Social
                                        <input type="text" readonly id="nom_mandante"  value="{{$cert->estructura->proyecto->empresa->nombre}}" class="form-control" name="">
                                    </div>
                                    <div class="col-xs-12 col-md-8 mb-2 ml-2 mt-2">
                                        Dirección
                                        <input type="text" readonly id="dir_mandante"   value="{{$cert->estructura->proyecto->empresa->direccion}}" class="form-control" name="">
                                    </div>
                                    <div class="col-xs-12 col-md-3 mb-2 mt-2">
                                    Teléfono
                                        <input type="text" readonly id="tel_mand" value="{{$cert->estructura->proyecto->empresa->telefonos}}"  class="form-control" name="">
                                    </div>
                                    <div class="col-xs-12 col-md-5 mb-2 ml-2 mt-2">
                                        Contacto
                                        <input type="text" readonly id="cont_mand" value="{{$cert->estructura->proyecto->empresa->nomContacto}}" class="form-control" name="">
                                    </div>
                                    <div class="col-xs-12 col-md-6 mb-2 mt-2">
                                    Email
                                        <input type="text" readonly id="email_cont"value="{{$cert->estructura->proyecto->empresa->emailContacto}}" class="form-control" name="">
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-12 mt-2">
                        <div class="card">
                            <div class="card-header">
                            4.- Identficación del Contratista
                            </div>
                            @if (isset($cert->estructura->contratistasubcontrato->rut))
                                @if ($cert->estructura->contratistasubcontrato->rut!=NULL)
                           
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-2 ml-2 mt-2">
                                            Rut
                                                <input type="text" id="rut_opcional" readonly value="{{ $cert->estructura->contratistasubcontrato->rut }}" name="rut_opcional" class="form-control" name="">
                                            </div>
                                            <div class="col-xs-12 col-md-9 mb-2 mt-2">
                                            Nombre ó Razón Social
                                                <input type="text" id="nom_opcional"  readonly value=" {{ $cert->estructura->contratistasubcontrato->nombre }}" class="form-control" name="">
                                            </div>

                                        </div>
                                    </div>
                                @endif
                            @else
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-2 ml-2 mt-2">
                                            Rut
                                                <input type="text" id="rut_opcional" readonly value="" name="rut_opcional" class="form-control" name="">
                                            </div>
                                            <div class="col-xs-12 col-md-9 mb-2 mt-2">
                                            Nombre ó Razón Social
                                                <input type="text" id="nom_opcional"  readonly value="" class="form-control" name="">
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
                                            <!-- <th scope="col">diasTrabajador</th>
                                            <th scope="col">numeroLocal</th> -->
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
                                        @foreach($empleadosActuales as $empleado)
                                            <tr>
                                                <th scope="col"><input type="text" value="<?php echo $num++ ?>" class="form-control" readonly>  </th>
                                                <th scope="col"><input type="text" value="{{ $empleado[0] }}" class="form-control" readonly name="rut[]"></th>
                                               
                                                <th scope="col"><input type="text" value="{{ $empleado[1] }}" class="form-control" readonly name="nombre[]"></th>
                                               
                                                <th scope="col"><input type="text" value="{{ $empleado[2] }}" class="form-control" readonly  name="cargo[]"></th>
                                                <th scope="col"><input type="text" value="{{ $empleado[4] }}" class="form-control" readonly  name="estado[]"></th>
                                               
                                                <th scope="col"><input type="text" value="{{ $empleado[5] }}" class="form-control" readonly name="trabajador_imponible[]"></th>
                                                <?php $totalI = $totalI + $empleado[5] ?>
                                                <th scope="col"><input type="text" value="{{ $empleado[6] }}" class="form-control" readonly name="trabajador_haber[]"></th>
                                                <!-- datos oculatos  -->
                                                <input type="hidden" value="{{ $empleado[7] }}" class="form-control" readonly name="liquidoPago[]">
                                                <input type="hidden" value="{{ $empleado[8] }}" class="form-control" readonly name="contingenciaPrevisional[]">
                                                <input type="hidden" value="{{ $empleado[9] }}" class="form-control" readonly name="contingenciaRemuneracional[]">
                                                <input type="hidden" value="{{ $empleado[10] }}" class="form-control" readonly name="contingenciaContrato[]">
                                                <input type="hidden" value="{{ $empleado[11] }}" class="form-control" readonly name="contingenciaFiniquito[]">
                                                <input type="hidden" value="{{ $empleado[12] }}" class="form-control" readonly name="fecha_retiro[]">
                                                <input type="hidden" value="{{ $empleado[13] }}" class="form-control" readonly name="nacionalidad[]">
                                                <input type="hidden" value="{{ $empleado[14] }}" class="form-control" readonly name="genero[]">
                                                <input type="hidden" value="{{ $empleado[15] }}" class="form-control" readonly name="diasTrabajados[]">
                                                <input type="hidden" value="{{ $empleado[16] }}" class="form-control" readonly name="numeroLocal[]">
                                                <!-- fin datos ocultos -->
                                                <?php $totalH = $totalH + $empleado[6] ?>
                                            </tr>
                                            
                                        @endforeach 

                                    </tbody>
                                    </table>


                                </div>
                            </div>
                        </div>
                    </div>
               <div class="row">
                    <div class="col-xs-12 col-md-4 mt-2">
                        Totales Imponibles :<input type="number" style="text-align:right"  value="<?php echo $totalI ?>" class="form-control" iname="total-imponible" readonly="readonly">
                    </div>
                    <div class="col-xs-12 col-md-4 mt-2">
                        Totales Haber : <input type="number" style="text-align:right" value="<?php echo $totalH ?>" name="total-haberes" class="form-control" readonly="readonly">
                    </div>

                    <div class="col-xs-12 col-md-4 mt-2">
                        Total a Certificar:<input type="number" style="text-align:right" value="<?php echo $num-1 ?>" name="total-certificar" class="form-control" readonly="readonly">
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
                                @foreach($empleadosSegundaNomina as $empleado)
                                            <tr>
                                                <th scope="col"><input type="text" value="<?php echo $num++ ?>" class="form-control" readonly>  </th>
                                                <th scope="col"><input type="text" value="{{ $empleado[0] }}" class="form-control" readonly id="RUT" name="rut_sn[]"></th>
                                               
                                                <th scope="col"><input type="text" value="{{ $empleado[1] }}" class="form-control" readonly id="NOMBRE" name="nombre_sn[]"></th>
                                               
                                               
                                                <th scope="col"><input type="text" value="Desvinculado" name="estado_sn[]" class="form-control" readonly></th>
                                               
                                                <th scope="col"> 
                                                    <select required name="causalSegundaNomina[]" class="form-control">
                                                        <option value="">Seleccione Causal</option>
                                                        <option value="Desvinculado N 159">Desvinculado N 159</option>
                                                        <option value="Desvinculado N 160">Desvinculado N 160</option>
                                                        <option value="Desvinculado N 161">Desvinculado N 161</option>
                                                        <option value="AT">AT</option>
                                                </th>
                                            </tr>
                                            
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
                        Total a Certificar:<input type="number" style="text-align:right" name="total-sn" value="<?php echo $num-1 ?>" class="form-control" readonly="readonly">
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

                                        <td><input type="text"  class="form-control" value="{{ $observacionPlanilla }} @if($cert->mes==1) ENERO @elseif($cert->mes==2) FEBRERO @elseif($cert->mes==3) MARZO @elseif($cert->mes==4) ABRIL @elseif($cert->mes==5) MAYO @elseif($cert->mes==6) JUNIO @elseif($cert->mes==7) JULIO @elseif($cert->mes==8) AGOSTO @elseif($cert->mes==9) SEPTIEMBRE @elseif($cert->mes==10) OCTUBRE @elseif($cert->mes==11) NOVIEMBRE @elseif($cert->mes==12) DICIEMBRE  @endif {{$cert->ano}} RESPECTO DE LOS TRABAJADORES REVISADOS EN EL PERíODO, SEGUN NOMINA.  " name="observacion_1" id="obs_rem" size="100"><br/>
                                        <!-- <input type="text" readonly class="form-control" value="" name="obs_rem2" id="obs_rem2" size="100"> -->
                                    </td>
                                        <td><input type="text"  class="form-control" name="monto_remumeracional"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">2.- Observaciones Previsionales</td>
                                        <td>Monto Previsional</td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" class="form-control" name="observacion_2" value="LAS COTIZACIONES PREVISIONALES CORRESPONDIENTES AL PERIODO CERTIFICADO FUERON PAGADAS EL {{ $fechaPagoCotizaciones }}" name="obs_pre" size="100"><br/></td>
                                        <td><input type="text" class="form-control" name="monto_previsional"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">3.- No presentación de Documentos</td>
                                    </tr>
                                        
                                    <tr>
                                        <td><input type="text" class="form-control" name="observacion_3" value="SIN OBSERVACIONES" size="100"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">4.-Observaciones Administrativas</td>
                                    </tr>
                                    <tr>
                                        <!-- <td><input type="text" class="form-control" id="obs_adm" value="" name="obs_adm" size="100"></td> -->
                                    </tr>
                                    <tr>
                                        <td><input type="text" class="form-control" value="SIN OBSERVACIONES" name="observacion_4" size="100"></td>
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td>Documentación Revisada</td>
                                                    <td>Inspector revisor de esta solicitud, declara haber tenido a la vista la evidencia que marca a continuación</td>
                                                </tr>
                                                  
                                                        <tr>
                                                            <td><center>Contratos</br></center><input type="checkbox" name="rev_contrato" readonly class="form-control"></td>
                                                            <td><center>Finiquitos</br></center><input type="checkbox" name="rev_finiquito" readonly  class="form-control"></td>
                                                            <td><center>Planilla de Sueldos</br></center><input type="checkbox" name="rev_planillaSueldos" readonly  class="form-control"></td>
                                                            <td><center>Cotizaciones Previsionales</br></center><input type="checkbox" name="rev_cotizacionesPrevisionales" readonly  class="form-control"></td>
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
                                        <th><input type="text" readonly value="@if($cert->mes==1) ENERO @elseif($cert->mes==2) FEBRERO @elseif($cert->mes==3) MARZO @elseif($cert->mes==4) ABRIL @elseif($cert->mes==5) MAYO @elseif($cert->mes==6) JUNIO @elseif($cert->mes==7) JULIO @elseif($cert->mes==8) AGOSTO @elseif($cert->mes==9) SEPTIEMBRE @elseif($cert->mes==10) OCTUBRE @elseif($cert->mes==11) NOVIEMBRE @elseif($cert->mes==12) DICIEMBRE  @endif-{{$cert->ano}}" class="form-control" class="largo"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th>Vigentes último período certificado</th>
                                        <th><input type="text"  value="{{ $DotacionFinalAnterior }}" name="dotacionMesAnterior" class="form-control" class="largo"></th>
                                    </tr>
                                    <tr>
                                        <th>Nuevos ingresos</th>
                                        <th><input type="number"  name="TotalEmpleadosNuevos" value="{{ $TotalEmpleadosNuevos }}" class="form-control" class="corto"></th>
                                    </tr>
                                    <tr>
                                        <th>Total revisados</th>
                                        <th><input type="number"   name="totalRevisados" value="{{ $DotacionFinalAnterior + $TotalEmpleadosNuevos }}" class="form-control" class="corto"></th>
                                    </tr>
                                    <tr>
                                        <th>Desvinculados</th>
                                        <th><input type="text"  name="totalDesvinculados" value="{{ $RetirosOfiniquitos + $totalDesvinculadosSN}} " class="form-control" class="corto"></th>
                                    </tr>
                                    <tr>
                                        <th>Dotación final del período</th>
                                        <th><input type="text"  value="{{ ($DotacionFinalAnterior + $TotalEmpleadosNuevos) - ($RetirosOfiniquitos + $totalDesvinculadosSN)}}" name="dotacionFinal" class="form-control" class="corto"></th>
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
                            <div class="card-header">Finalizar solicitud y enviar Certificado a Firma</div>
                            <div class="card-body text-primary text-center">
                                <div class="row">
                                    <textarea name="observacionRechazo" class="form-control mt-2 mb-3 ml-2 mr-2" required  placeholder="Escriba aquí comentarios a la Persona que firma"></textarea>
                                    <div class="col-xs-12 col-md-4">
                                        <label for="">Nómina Extendida.</label>
                                        <select class="form-control" name="nominaExtendida">
                                            <option value="N">No</option>
                                            <option value="S">Si</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <label for="">Segunda Nómina</label>
                                        <select class="form-control" name="segundaNomina">
                                            <option value="S">Si</option>
                                            <option value="N">No</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <label for="">Contrato Visible</label>
                                        <select class="form-control" name="contratoVisible">
                                            <option value="S">Si</option>
                                            <option value="N">No</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-md-4">
                                        <label for="">Habilitar Columnas, Días-Trabajados, Número Local</label>
                                        <select class="form-control" name="columnasDtrabajadosNlocalVisible">
                                            <option value="N">No</option>
                                            <option value="S">Si</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-success  mb-3 mt-3" value="Enviar a Firma">
                                <br/>
                               
                            </div>
                        </div>
                    </div>
                   


            </div>
<div>
                    <!-- fin contenido  -->
        @endforeach            
    </form>             
        </div>
            </div>
        </div>
    </div>
</div>
@endsection