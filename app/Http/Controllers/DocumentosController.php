<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\documento;
use Carbon\Carbon;
use Conner\Tagging\Model\Tag;
use Conner\Tagging\Model\Tagged;
use App\registro;
use App\empresa;
use App\proyecto;
use App\estructura;
use App\detalleregistro;
use App\solicitudeproceso;
use Conner\Tagging\Model\TagGroup;
use Alert;
class DocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $matrizTgas=array();
    public $observacion;
    public $estructura_id;
    
    public $proyecto_id;
    public $contratista_id;
    public $contrato;
    public $solicitud_id;
    public $anio;
    public $mes;
    public $leyenda;
    public $EmpresaPrincipal='Empresa Principal';
    public $contratista="Contratista";
    public $estructuras=array();
    public $matrizDocumentos;
    public $fil=0;
    public $col=0;
    public $etiquetas;
    public function index()
    {
        
        // $documentos=documento::all();
        // return view('Documentos.index',compact('documentos'));
        $empresas = empresa::where('tipoEmpresa','!=',$this->contratista)->get();
        $holding = empresa::where('mutualidad','!=','')->select('mutualidad')->distinct()->get();

        return view('Documentos.index',compact('empresas','holding'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $etiquetas=Tag::all();
        $empresas=empresa::where('tipoEmpresa',$this->EmpresaPrincipal)->orderBy('rut', 'DESC')->get();
        $groups=TagGroup::all();
        $idCarga=registro::create([
            'observacion'=>'Carga de Documentación',
        ]);
        

        $RegistroCarga=$idCarga->id;

        return view('Documentos.create',compact('etiquetas','empresas','groups','RegistroCarga'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
          $nombreArchivo = $request->file('file')->getClientOriginalName();
          $this->matrizArchivo=explode('_',$nombreArchivo);
          

        //   $this->anio=$this->matrizArchivo[0];
        //   $this->mes=$this->matrizArchivo[1];
            $this->solicitud_id=$request->input('numeroSolicitud');
            $solicitud=solicitudeproceso::where('id',$this->solicitud_id)->get();
            foreach($solicitud as $DatosSolicitud){
            $this->contratista_id=$DatosSolicitud->estructura->empresa_id;
            $this->contrato=$DatosSolicitud->estructura->contrato;
            $this->proyecto_id=$DatosSolicitud->estructura->proyecto_id;
        }
        //$this->contratista_id=$request->input('contratista_id');
        //$this->contrato=$request->input('contrato_id');
            
        //$this->proyecto_id=$request->input('proyecto_id');

        $estructuras=estructura::where('contrato',$this->contrato)->where('proyecto_id',$this->proyecto_id)->where('empresa_id',$this->contratista_id)->get();

        if($estructuras->isEmpty()){
                $this->leyenda="El Contrato ".$this->contrato." no existe o no pertenece al Proyecto";
                $detalleArchivo=detalleregistro::create([
                'registro_id'=>$request->idRegistro,
                'nombreArchivo'=>$nombreArchivo,
                'detalle'=>$this->leyenda,
                ]);
                
        }else{
        
        
                    foreach($estructuras as $estructura){
                        $this->estructura_id=$estructura->id;
                    }

        
                    $this->matrizTags=explode(',',$request->input('tags'));

                    $this->fechaActual= new \DateTime();
                    $this->observacion="Carga Masiva";
            

                if($request->hasFile('file')) {
                    
                    $nombreFile = $request->file('file')->getClientOriginalName();
                    
                    //no Upload path
                    $destinationPath = 'Archivos/Cargados/'.$this->estructura_id."/".$this->anio."/".$this->mes."/";
            
                    // Create directory if not exists
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
            
                    // Get file extension
                   
                    $extension = $request->file('file')->getClientOriginalExtension();
                  
                    // Valid extensions
                    $validextensions = array("jpeg","jpg","png","pdf","JPG","rar","csv","CSV","XLSX","xlsx","ZIP","zip");
            
                    // Check extension

                    if(in_array(strtolower($extension), $validextensions)){
            

                        // Rename file 
                        // $fileName = str_slug($nombreFile.Carbon::now().rand(111111, 999999).'.' . $extension); //$request->input('tags').
                        if($estructuras->isEmpty()){
                            return back();
                            
                        }
                        // Uploading file to given path
                        $date = Carbon::now();
 
                        $date = $date->format('Y-m-d');

                        //$nombreFile = $nombreFile."_".$date.".".$extension;
                        $nombreFile = $nombreFile;//.$extension;
                        $request->file('file')->move($destinationPath, $nombreFile); 
            
                        $documentos=documento::create([
                        'documento'=>$nombreFile,
                        'ubicacion'=>$destinationPath,
                        'estructura_id'=>$this->estructura_id,
                        // 'mes'=>$this->mes,
                        // 'anio'=>$this->anio,
                        'registro_id'=>$request->idRegistro,

                        ]);

                        $documentos->tag($this->matrizTags);
                        
                    }
        
                }
            }
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $valor='';
        $etiquetas=Tag::all();
        $documento=documento::where('id',$id)->get();
        return view('Documentos.edit',compact('documento','valor','etiquetas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $borrar=tagged::where('taggable_id',$request->id)->delete();
        
        $this->matrizTags=explode(',',$request->input('tags'));
        $elementos=count($this->matrizTags);

            for($i=0;$i<$elementos;$i++)
            {
                if ($this->matrizTags[$i]!='')
                {   
                    $str = strtolower($this->matrizTags[$i]);
                    //dd($request->id);
                    $id=Tagged::create([
                        'taggable_id'=>$request->id,
                        'taggable_type'=>'App\documento',
                        'tag_name'=>$this->matrizTags[$i],
                        'tag_slug'=>$str,
                    ]);
                };
            };
            
        Alert::success('Documento Actualizado correctamente...');
        $documentos=documento::all();
        return view('Documentos.index',compact('documentos'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $borrar=documento::where('id',$id)->delete();
        return 1;
    }


    public function cargaeinformes(){
        return view('Documentos.cargaeinformes');
    }

    public function destroyMasiva($id){
        $borrarMasivo=documento::where('registro_id',$id)->delete();
        //Alert::success('Documentos Eliminados correctamente...');
        return 1;
    }

    public function documentosXmandante($empresa_id)
    {
        $proyectos=proyecto::with('estructura')->where('empresa_id',$empresa_id)->get();

        foreach($proyectos as $estructura)
        {
            for($i=0;$i<count($estructura->estructura);$i++)
            {
                $documentosxEstructuras=documento::where('estructura_id',$estructura->estructura[$i]->id)->get();
                    foreach($documentosxEstructuras as $documento)
                    {
                        $this->matrizDocumentos[$this->fil][$this->col]=$documento->registro_id;
                        $this->matrizDocumentos[$this->fil][$this->col+1]=$documento->documento;
                            foreach($documento->tags as $tag)
                            {
                                $this->etiquetas.=$tag->name.',';
                            }
                        $this->matrizDocumentos[$this->fil][$this->col+2]=$this->etiquetas;
                        $this->matrizDocumentos[$this->fil][$this->col+3]=$documento->estructura->proyecto->empresa->nombre;
                        $this->matrizDocumentos[$this->fil][$this->col+4]=$documento->estructura->proyecto->proyecto;
                        $this->matrizDocumentos[$this->fil][$this->col+5]=$documento->estructura->empresa->nombre;
                        $this->matrizDocumentos[$this->fil][$this->col+6]=$documento->estructura->contrato;
                        $this->matrizDocumentos[$this->fil][$this->col+7]=$documento->id;
                        $this->matrizDocumentos[$this->fil][$this->col+8]=$documento->ubicacion;
                        $this->matrizDocumentos[$this->fil][$this->col+9]=$documento->estructura->proyecto->empresa->rut;
                        $this->matrizDocumentos[$this->fil][$this->col+10]=$documento->estructura->empresa->rut;
                        $this->fil++;
                        $this->etiquetas='';
                    }
                
            }
        }
        
        return $this->matrizDocumentos;
    }

    // documentos por holding
    public function documentosXholding($holding)
    {
        
        $mandantesXholding=empresa::where('mutualidad','like', '%' .$holding. '%')->where('tipoEmpresa','!=','Contratista')->get();

        //$mandantesXholding=empresa::where('mutualidad',$holding)->where('tipoEmpresa','!=','Contratista')->get();
        foreach($mandantesXholding as $mandante){
            $proyectos=proyecto::with('estructura')->where('empresa_id',$mandante->id)->get();

            foreach($proyectos as $estructura)
            {
                for($i=0;$i<count($estructura->estructura);$i++)
                {
                    $documentosxEstructuras=documento::where('estructura_id',$estructura->estructura[$i]->id)->get();
                        foreach($documentosxEstructuras as $documento)
                        {
                            $this->matrizDocumentos[$this->fil][$this->col]=$documento->registro_id;
                            $this->matrizDocumentos[$this->fil][$this->col+1]=$documento->documento;
                                foreach($documento->tags as $tag)
                                {
                                    $this->etiquetas.=$tag->name.',';
                                }
                            $this->matrizDocumentos[$this->fil][$this->col+2]=$this->etiquetas;
                            $this->matrizDocumentos[$this->fil][$this->col+3]=$documento->estructura->proyecto->empresa->nombre;
                            $this->matrizDocumentos[$this->fil][$this->col+4]=$documento->estructura->proyecto->proyecto;
                            $this->matrizDocumentos[$this->fil][$this->col+5]=$documento->estructura->empresa->nombre;
                            $this->matrizDocumentos[$this->fil][$this->col+6]=$documento->estructura->contrato;
                            $this->matrizDocumentos[$this->fil][$this->col+7]=$documento->id;
                            $this->matrizDocumentos[$this->fil][$this->col+8]=$documento->ubicacion;
                            $this->matrizDocumentos[$this->fil][$this->col+9]=$documento->estructura->proyecto->empresa->rut;
                            $this->matrizDocumentos[$this->fil][$this->col+10]=$documento->estructura->empresa->rut;
                            $this->fil++;
                            $this->etiquetas='';
                        }
                    
                }
            }
        }
        return $this->matrizDocumentos;
    }

    public function documentosXcontratista($contratista_id,$empresa_id,$proyecto_id)
    {
        
       //return ($contratista_id."-".$empresa_id."-".$proyecto_id);
       if ($contratista_id!=0 && $empresa_id!=0 && $proyecto_id!=0){
                $estructuras=estructura::where('empresa_id',$contratista_id)->get();
                foreach($estructuras as $estructura)
                {
                    $documentosxEstructuras=documento::where('estructura_id',$estructura->id)->get();
                        foreach($documentosxEstructuras as $documento)
                        {
                            $this->matrizDocumentos[$this->fil][$this->col]=$documento->registro_id;
                            $this->matrizDocumentos[$this->fil][$this->col+1]=$documento->documento;
                                foreach($documento->tags as $tag)
                                {
                                    $this->etiquetas.=$tag->name.',';
                                }
                            $this->matrizDocumentos[$this->fil][$this->col+2]=$this->etiquetas;
                            $this->matrizDocumentos[$this->fil][$this->col+3]=$documento->estructura->proyecto->empresa->nombre;
                            $this->matrizDocumentos[$this->fil][$this->col+4]=$documento->estructura->proyecto->proyecto;
                            $this->matrizDocumentos[$this->fil][$this->col+5]=$documento->estructura->empresa->nombre;
                            $this->matrizDocumentos[$this->fil][$this->col+6]=$documento->estructura->contrato;
                            $this->matrizDocumentos[$this->fil][$this->col+7]=$documento->id;
                            $this->matrizDocumentos[$this->fil][$this->col+8]=$documento->ubicacion;
                            $this->matrizDocumentos[$this->fil][$this->col+9]=$documento->estructura->proyecto->empresa->rut;
                            $this->matrizDocumentos[$this->fil][$this->col+10]=$documento->estructura->empresa->rut;
                            $this->fil++;
                            $this->etiquetas='';
                        }
                    
                }
            
            return $this->matrizDocumentos;
        }
        if ( $empresa_id!=0 && $proyecto_id==0 && $contratista_id==0){
            $proyectos=proyecto::with('estructura')->where('empresa_id',$empresa_id)->get();

            foreach($proyectos as $estructura)
            {
                for($i=0;$i<count($estructura->estructura);$i++)
                {
                    $documentosxEstructuras=documento::where('estructura_id',$estructura->estructura[$i]->id)->get();
                        foreach($documentosxEstructuras as $documento)
                        {
                            $this->matrizDocumentos[$this->fil][$this->col]=$documento->registro_id;
                            $this->matrizDocumentos[$this->fil][$this->col+1]=$documento->documento;
                                foreach($documento->tags as $tag)
                                {
                                    $this->etiquetas.=$tag->name.',';
                                }
                            $this->matrizDocumentos[$this->fil][$this->col+2]=$this->etiquetas;
                            $this->matrizDocumentos[$this->fil][$this->col+3]=$documento->estructura->proyecto->empresa->nombre;
                            $this->matrizDocumentos[$this->fil][$this->col+4]=$documento->estructura->proyecto->proyecto;
                            $this->matrizDocumentos[$this->fil][$this->col+5]=$documento->estructura->empresa->nombre;
                            $this->matrizDocumentos[$this->fil][$this->col+6]=$documento->estructura->contrato;
                            $this->matrizDocumentos[$this->fil][$this->col+7]=$documento->id;
                            $this->matrizDocumentos[$this->fil][$this->col+8]=$documento->ubicacion;
                            $this->matrizDocumentos[$this->fil][$this->col+9]=$documento->estructura->proyecto->empresa->rut;
                            $this->matrizDocumentos[$this->fil][$this->col+10]=$documento->estructura->empresa->rut;
                            $this->fil++;
                            $this->etiquetas='';
                        }
                    
                }
            }
            
            return $this->matrizDocumentos;
        }

        if ( $empresa_id!=0 && $proyecto_id!=0 && $contratista_id==0){
            $proyectos=proyecto::with('estructura')->where('id',$proyecto_id)->get();

            foreach($proyectos as $estructura)
            {
                for($i=0;$i<count($estructura->estructura);$i++)
                {
                    $documentosxEstructuras=documento::where('estructura_id',$estructura->estructura[$i]->id)->get();
                        foreach($documentosxEstructuras as $documento)
                        {
                            $this->matrizDocumentos[$this->fil][$this->col]=$documento->registro_id;
                            $this->matrizDocumentos[$this->fil][$this->col+1]=$documento->documento;
                                foreach($documento->tags as $tag)
                                {
                                    $this->etiquetas.=$tag->name.',';
                                }
                            $this->matrizDocumentos[$this->fil][$this->col+2]=$this->etiquetas;
                            $this->matrizDocumentos[$this->fil][$this->col+3]=$documento->estructura->proyecto->empresa->nombre;
                            $this->matrizDocumentos[$this->fil][$this->col+4]=$documento->estructura->proyecto->proyecto;
                            $this->matrizDocumentos[$this->fil][$this->col+5]=$documento->estructura->empresa->nombre;
                            $this->matrizDocumentos[$this->fil][$this->col+6]=$documento->estructura->contrato;
                            $this->matrizDocumentos[$this->fil][$this->col+7]=$documento->id;
                            $this->matrizDocumentos[$this->fil][$this->col+8]=$documento->ubicacion;
                            $this->matrizDocumentos[$this->fil][$this->col+9]=$documento->estructura->proyecto->empresa->rut;
                            $this->matrizDocumentos[$this->fil][$this->col+10]=$documento->estructura->empresa->rut;
                            $this->fil++;
                            $this->etiquetas='';
                        }
                    
                }
            }
            
            return $this->matrizDocumentos;
        }
    }

    // documentos por contratista
}