<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use \Chumper\Zipper\Zipper;
use ZipArchive;
use App\documento;
use App\empresa;
use App\solicituddocumento;
use App\solicitudeproceso;
use Alert;
class ComprimirDescargar extends Controller
{
    public $archivos = array();
    public $ano;
    public $num = 0;
    public $zip;
    public $nombreZip;
    public $MarcaFecha;
    public $anioID=0;
    public $contratista="Contratista";

    public function comprimirD($id){
        $zipper = new \Chumper\Zipper\Zipper;
        $archivos=solicituddocumento::where('solicitudeproceso_id',$id)->get();
        $ano=solicitudeproceso::where('id',$id)->get();
        foreach($ano as $dato){
            $this->ano = $dato->ano;
        }
        foreach($archivos as $archivo){
            $this->archivos[$this->num] = glob(public_path('archivos/'.$this->ano.'/'.$archivo->documento));
            $this->num++;
        }
        
            $files = $this->archivos;
          
            $zipper->make(storage_path('public/comprimidos/ArchivosComprimidos'.$id.'.zip'))->add($files)->close();
          
         
          return response()->download(storage_path('public/comprimidos/ArchivosComprimidos'.$id.'.zip'));

          unlink(storage_path('public/comprimidos/ArchivosComprimidos'.$id.'.zip'));//Destruye el archivo temporal
    }
    
    public function Comprimir(request $request){
        
        if($request->documentos==null){
            $documentos=documento::all();
            $empresas = empresa::where('tipoEmpresa','!=',$this->contratista)->get();
            alert::error('No existen documentos para descargar');
            return view('Documentos.index',compact('empresas'));
        }
        $this->MarcaFecha=rand(111111111, 999999999);
        $this->files=$request->documentos;
            foreach ($this->files as $file) {
                $documento=documento::where('documento',$file)->get();
                    foreach ($documento as $ruta) {
                        $relativeNameInZipFile = basename($ruta->documento);
                        $this->zip[$this->num]=glob(public_path()."/".$ruta->ubicacion. $relativeNameInZipFile);
                        $this->num++;
                    }
            }
        $this->nombreZip='ArchivosComprimidos-'.$this->MarcaFecha.'.zip';
        $zipper = new \Chumper\Zipper\Zipper;
        
        $zipper->make(base_path('zipper/'.$this->nombreZip))->add($this->zip);
        //$zipper->make(base_path('zipper/lara-master.zip'))->extractTo(base_path('zipper/lara-master'));
        $zipper->close();
        // return response()->download(base_path('zipper/ArchivosComprimidos.zip'));
      
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename='.$this->nombreZip);
        header('Content-Length: ' . filesize(base_path('zipper/'.$this->nombreZip)));
        readfile(base_path('zipper/'.$this->nombreZip));
        unlink(base_path('zipper/'.$this->nombreZip));


        $documentos=documento::all();
        Alert::success('Descaga Realizada Correctamente...');
        return view('Documentos.index',compact('documentos'));
        
       
    }

    public function ComprimirDocumentoSolicitud(request $request){
        $this->MarcaFecha=rand(111111111, 999999999);


        
        //$this->files=$request->documentos;
        $documentos=solicituddocumento::where('solicitudeproceso_id',$request->solicitud_id_zip)->get();
            foreach ($documentos as $file) {
                $solicitud=solicitudeproceso::where('id',$request->solicitud_id_zip)->get();
                
                foreach($solicitud as $numero){
                    $this->anioID = $numero->ano;
                }
                
                $relativeNameInZipFile = basename($file->documento);
                
                //dd(glob(public_path()."/Archivos/".$this->anioID."/"));
                $this->zip[$this->num]=glob(public_path()."/Archivos/".$this->anioID."/".$relativeNameInZipFile);
                        $this->num++;
                   
            }

        //dd($this->zip);
        $this->nombreZip=$request->solicitud_id_zip."-".'ArchivosComprimidos-'.$this->MarcaFecha.'.zip';
        $zipper = new \Chumper\Zipper\Zipper;
        
        $zipper->make(base_path('zipper/'.$this->nombreZip))->add($this->zip);
        //$zipper->make(base_path('zipper/lara-master.zip'))->extractTo(base_path('zipper/lara-master'));
        $zipper->close();
        // return response()->download(base_path('zipper/ArchivosComprimidos.zip'));
      
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename='.$this->nombreZip);
        header('Content-Length: ' . filesize(base_path('zipper/'.$this->nombreZip)));
        readfile(base_path('zipper/'.$this->nombreZip));
        unlink(base_path('zipper/'.$this->nombreZip));


        //$documentos=documento::all();
        Alert::success('Descaga Realizada Correctamente...');
        $solicitudes=solicitudeproceso::with('solicituddocumento')->where('estado',$this->enviada)->orWhere('estado',$this->declaracion)->where('inspector_id',NULL)->get();

        return view('Admin.solicitudesNuevas',compact('solicitudes')); //,'primerEnvio'
    }
}
