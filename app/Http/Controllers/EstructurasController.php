<?php
namespace App\Http\Controllers;
use App\empresa;
use Alert;
use App\User;
use App\proyecto;
use App\estructura;
use Illuminate\Http\Request;
class EstructurasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $ep="Empresa Principal";
    public $m="Mixto";
    public $con="Contratista";
    public $pivote = array();
   
    public $n=0;
    public $c=0;
    public $v=0;
    public $f=0;
    public $activo=1;
    public $empresas_id = array(); 
    public $proyecto_idP;
    public $contratos = array(); 
    public $ruts = array();
    Public $vacios = array();
    public $valor1="";
    public $valor2="";
    public $empresa;
    public $contrato;
    public $activoC;
    public $rut;
    public $fechaInicio;
    public $asignados=0;
    public $rechazados=0;
    public $nrechazados=0;
    public $contratistasProyecto = array(); 
    public $pivot;
    public $user;
    public $verificar;

    public function index()
    {
        $proyectos=proyecto::all();
        return view('Estructuras.index', compact('proyectos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $empresas = empresa::select('id','rut','nombre')->where('tipoEmpresa',$this->ep)->orWhere('tipoEmpresa',$this->m)->orderBy('nombre', 'ASC')->get();
        $contratistas = empresa::select('id','rut','nombre')->where('tipoEmpresa',$this->con)->orWhere('tipoEmpresa',$this->m)->get();
        return view('Estructuras.create', compact('empresas','contratistas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
     

        $this->empresas_id = $request->input("empresa_id");
        $this->proyecto_idP = $request->proyecto_id;
        $this->contratos = $request->input("contrato");
        $this->fechasInicio = $request->input("fechaInicio");
        $this->ruts = $request->input("rut");

        
        $this->n=count($request->input("empresa_id"));
        
        foreach($request->input("empresa_id") as $empresas)
        {
            $this->pivote=$this->empresas_id[$this->c]."-".$this->contratos[$this->c]."-".$this->proyecto_idP;
                       
            $this->empresa=$this->empresas_id[$this->c];
            $this->contrato=$this->contratos[$this->c];
            $this->fechaInicio=$this->fechasInicio[$this->c];
            $this->rut = $this->ruts[$this->c];
            
            if($this->contrato!="" && $this->fechaInicio!="")
            {
          
                    $busqueda=estructura::where('pivote',$this->pivote)->get();
        
                    if (count($busqueda)==0){

                            estructura::create([
                                'empresa_id'=>$this->empresa,
                                'contrato'=>$this->contrato,
                                'fechaInicio'=>$this->fechaInicio,
                                'proyecto_id'=>$request->proyecto_id,
                                'activo'=>$this->activo,
                                'pivote'=>$this->pivote,
                                'User_id'=>auth()->User()->id,
                            ]);
                                $this->asignados++;
                         
                    }else{
                        
                    }
                }else{
                    $this->rechazados++;
                 
                if($this->contrato!="" || $this->fechaInicio!=""){
                $this->vacios[$this->v]=$this->rut;
                
                $this->v++;
                }
            }
            $this->c++;
            
        }

        $ing=$this->asignados;
        $vac = $this->vacios;
        $nrechazados=$this->rechazados;
         $empresas = empresa::where('tipoEmpresa',$this->ep, ['id','rut','nombre'])->orWhere('tipoEmpresa',$this->m, ['id','rut','nombre'])->get();
         $contratistas = empresa::where('tipoEmpresa',$this->con, ['id','rut','nombre'])->get();
        Alert::success('Contratistas Guardados Exitosamente');
        // return back()->withInput(['ing' => $ing, 'malos' => $this->vacios,'empresas'=>$empresas,'contratistas'=>$contratistas,'numeroRechazados'=>$this->rechazados]);
         //return view('Estructuras.create',compact('ing'>$ing,'vac','empresas','contratistas','nrechazados'));

         return view('Estructuras.create',['ing'=>$ing,'malos'=>$this->vacios,'empresas'=>$empresas,'contratistas'=>$contratistas,'numeroRechazados'=>$this->rechazados]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contratistas=estructura::where('proyecto_id',$id)->get();
        return view('Estructuras.show',compact('contratistas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proyectos=proyecto::all();
        $empresas=empresa::all();
        $contratistas=estructura::where('proyecto_id',$id)->get();
        return view('Estructuras.edit',compact('contratistas','proyectos','empresas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->empresas_id = $request->input("empresa_id");
        $this->contratos = $request->input("contrato");
        $this->proyectos_id = $request->input("proyecto_id");
        $this->fechasInicio = $request->input("fechaInicio");
        $this->activoC = $request->input("activo");


        $this->pivote = $this->empresas_id[0]."-".$this->contratos;
     
        
        
        if($this->contratos!="" && $this->fechasInicio!="")
        {
      
                $busqueda=estructura::where('pivote',$this->pivote)->get();
    
                if (count($busqueda)==0){

                    $act=estructura::where('id',$id)->update(['proyecto_id' =>$this->proyectos_id[0],'empresa_id'=>$this->empresas_id[0],'contrato'=>$this->contratos,'fechaInicio'=>$this->fechasInicio,'activo'=>$this->activoC]);
                    Alert::success('Contratistas Actualizado Exitosamente');
                   
                    return back();
                  
                }else{
                    $act=estructura::where('id',$id)->update(['fechaInicio'=>$this->fechasInicio,'activo'=>$this->activoC]);
                    Alert::success('se actualiz?? Correctamente Fecha de Inicio y Estado');
                    
                    return back();
                    
                     
                }
        }else{
            
            $this->vacios[$this->v]=$this->rut;
            
            $this->v++;
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $borrar=proyecto::where('id',$id)->delete();
        return ;
    }

    public function listaProyectosEmpresa($id){
        return proyecto::where('empresa_id',$id)->where('activo','1')->get();
    }


    public function listaEmpresasProyecto($id)
    {
     
         return $solicitudesNuevas=estructura::with('empresa')->distinct()->select('empresa_id')->where('proyecto_id',$id)->get();
    }

    public function listaContratoEmpresa($proy_id, $id){
        return estructura::where('empresa_id',$id)->where('proyecto_id',$proy_id)->get();
    }

    public function AsignacionIndividual($empresa_id,$proyecto_id,$cliente_id,$contratistaSubcontrato_id,$contratoContratista,$fechaingresoContratista){
        //$this->user = auth()->User()->id;
        //return $this->user;
        if($contratistaSubcontrato_id!=0){
            $this->pivot=$cliente_id.'-'.$contratoContratista.'-'.$proyecto_id.'-'.$contratistaSubcontrato_id;
            //return $this->pivot;
            $siExiste=estructura::where('pivote',$this->pivot)->get();
            foreach($siExiste as $comprobacion){
                $this->verificar = $comprobacion->id;
            }
                if($this->verificar!=NULL){
                     return 0;
                 }else{
                    estructura::create([
                        'empresa_id'=>$cliente_id,
                        'contrato'=>$contratoContratista,
                        'fechaInicio'=>$fechaingresoContratista,
                        'proyecto_id'=>$proyecto_id,
                        'activo'=>$this->activo,
                        'pivote'=>$this->pivot,
                        'User_id'=>1,
                        'contratistasubcontrato_id'=>$contratistaSubcontrato_id,
            
                    ]);
                 }
                return 1;
        }else{
            $this->pivot=$cliente_id.'-'.$contratoContratista.'-'.$proyecto_id;
            //return $this->pivot;
            $siExiste=estructura::where('pivote',$this->pivot)->get();
            foreach($siExiste as $registro){
                $this->verificar=$registro->id;
             }    
                if($this->verificar!=NULL){
                    return 0;
                }else{
                   estructura::create([
                       'empresa_id'=>$cliente_id,
                       'contrato'=>$contratoContratista,
                       'fechaInicio'=>$fechaingresoContratista,
                       'proyecto_id'=>$proyecto_id,
                       'activo'=>$this->activo,
                       'pivote'=>$this->pivot,
                       'User_id'=>1,
           
                   ]);
                   return 1;
                }
           
                          
        }

    }

    public function Asignacionlistacontratista(){
        return 1;
    }
}
