<?php
namespace Modules\Importador\Http\Controllers;


use App\FileEntry;
use Illuminate\Support\Facades\Storage;
use Pingpong\Modules\Routing\Controller;
use Illuminate\Http\Request;
use App\Obra as obr;
use App\Etapa as etap;
use App\Subetapa as sub;
use App\Importacao as imp;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;

class ImportadorController extends Controller {
	
	public function index()
	{
		$obras = obr::all(); 
		return view('importador::index',compact('obras'));
	}

	public function getEtapas(Request $request){
		$dados = $request->all();
        $data = $dados['id'];
        $that = etap::where('obra_id', $data)->get();
        $all = '';
        $x = 0;
        foreach($that as $etapa){
            $all .= $etapa->id.'&'.$etapa->codigo;
            $x++;
            if($x < count($that)){
                $all .= '&x&';
            }

        }
            return $all;
        die(); 
    }

    public function getSubetapas(Request $request){
		$dados = $request->all();
        $data = $dados['id'];
        $that = sub::where('etapa_id', $data)->get();
        $all = '';
        $x = 0;
        foreach($that as $subetapa){
            $all .= $subetapa->id.'&'.$subetapa->cod;
            $x++;
            if($x < count($that)){
                $all .= '&x&';
            }

        }
            return $all;
        die(); 
    }

    public function toImport(Request $request){
    	$dados = $request->all();
    	$data = $dados['id'];
    	$subetapa = sub::find($data);
    	$send = array(
    		'subetapa_id'  =>  $subetapa->id
    	); 
        return json_encode($send);
    }

    public function gravar(Request $request){
        $getRequest = $request->all();
        $subetapa_id = $getRequest['subetapa_id'];
        $observacoes = $getRequest['observacoes'];
        $dados = sub::find($subetapa_id);
        $files =  $request->files->all();
        $extDone = array();
        $exts = array('dbf', 'ifc', 'fbx');
        foreach($files as $namess){
            foreach($namess as $names){
     

                if(!empty($names)){
                    list($nam, $ext) = explode('.',$names->getClientOriginalName());
                    $ext = strtolower($ext);
                    if(!in_array($ext, $exts)){
                         \Session::flash('imp_danger', '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;  Falha na Importação, Envie somente arquivos dbf, ifc ou fbx.');
                         return back()
                        ->withInput();
                    }elseif(in_array($ext, $extDone)){
                         \Session::flash('flash_danger', '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;  Falha na Importação, Envie somente um arquivo de cada tipo.');
                        return redirect()->route('importador')->withInput();
                    }else{
                        $extDone[] = $ext;
                    }
                }
            }
        }
        if(!isset($dados->importacoes->importacaoNr)){
            if(count($extDone) < 2){
                \Session::flash('imp_danger', '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;  Arquivos dbf e ifc obrigatorios na primeira Importação.');
                     return back()->withInput();
            }elseif(!in_array('dbf', $extDone)){
                 \Session::flash('imp_danger', '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;  Arquivos dbf e ifc obrigatorios na primeira Importação.');
                     return back()->withInput();
            }elseif(!in_array('ifc', $extDone)){
               \Session::flash('imp_danger', '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;  Arquivos dbf e ifc obrigatorios na primeira Importação.');
                     return back()->withInput();
            }
        }  
        $maxSize = 1024 * 1024 * 10;
        $nroImportacao = count($dados->importacao);
        $nroImportacao = (!empty($nroImportacao)) ? ($nroImportacao+1) : 1;
        $path = $dados->locatario_id . "/" . $dados->etapa->obra->cliente_id . "/" . $dados->etapa->obra_id . "/" . $dados->etapa_id . "/" . $dados->id . "/" . $nroImportacao . "/";
        foreach($files as $filex){
            foreach($filex as $file){

                if(!Input::hasfile($file)){
                   unset($file);
                }else{
                   Storage::put( $path.'nome', File::get($file));
                }
            }
        }
        die('Sucesso');
        
        
        

    }
	
}