<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EstructurasController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/eliminar/{id}/User/','UserController@destroy');
Route::get('/eliminar/{id}/Role/','RolesProfilesController@destroy')->name('rolesprofiles.destroy')->middleware('permission:rolesprofiles.destroy');//Ruta de eliminación del rol directamente;
Route::get('/datos/{rut}/Empresa/','EmpresasController@RecuperaDatosEmpresa');
Route::get('/proyectos/{idEmpresa}/empresa/','ProyectosController@proyectosEmpresa');
Route::get('/Listaproyectos/{id}/empresa','EstructurasController@listaProyectosEmpresa');
Route::get('/eliminar/{id}/Proyecto/','EstructurasController@destroy');
Route::get('/eliminar/{id}/UsuContForm/','UsucontformsController@destroy');
Route::get('/aprobar/{id}/certificado/{nfact}/','solicitudesAdminController@ApruebaCertificado');
Route::get('/rechazar/{id}/certificado/{obs}/rechazo/','solicitudesAdminController@RechazaCertificado');
Route::get('/prueba/lista/empresas/','EmpresasController@listaCsharp');
Route::get('/NombreTag/{ids}/tags','TagsController@NombreTags');
Route::get('/eliminar/{id}/tags/','TagsController@destroy');
Route::get('/eliminar/{id}/documentos/','DocumentosController@destroy');
Route::get('/NombreGroupsTag/{id}/tags','GroupTagsController@NombresTags');
Route::get('/NombreGroupsQuitarTag/{id}/tags','GroupTagsController@NombresTagsQuitar');
Route::get('listado/{idRegistro}/reporte','RegistroDetalleController@show');
Route::get('/eliminar/{id}/documentos/carga/masiva','DocumentosController@destroyMasiva');
Route::get('/ListaEmpresas/{id}/proyecto','EstructurasController@listaEmpresasProyecto');
Route::get('/Lista/{pro_id}/{id}/Empresa','EstructurasController@listaContratoEmpresa');
Route::get('/restaurar/{id}/solicitud','solicitudesAdminController@restauraSolicitud');
Route::get('/mandante/{empresa_id}/proyecto/{proyecto_id}/cliente/{cliente_id}/contratista/{contratistaSubcontrato_id}/contrato/{contratoContratista}/fechaIngreso/{fechaingresoContratista}/asignacion/','EstructurasController@AsignacionIndividual');
Route::get('/agrega_lista/mandante/{empresa_id}/proyecto/{proyecto_id}/cliente/{cliente_id}/contratista/{contratistaSubcontrato_id}/contrato/{contratoContratista}/fechaIngreso/{fechaingresoContratista}/asignacion/','EstructurasController@Asignacionlistacontratista');
Route::get('/empresas/{proyecto_id}/porproyecto','UsucontformsController@empresasxproyecto');
Route::get('/clonacion/{actual_usuario_id}/permisos/{destino_usuario_id}/usuarios/','UsucontformsController@clonacionperfiles');
Route::get('/documento/{empresa_id}/mandante','DocumentosController@documentosXmandante');
Route::get('/documento/{holding}/holding','DocumentosController@documentosXholding');
Route::get('/documento/{contratista_id}/Xcontratatista/{empresa_id}/{proyecto_id}/boton/','DocumentosController@documentosXcontratista');
