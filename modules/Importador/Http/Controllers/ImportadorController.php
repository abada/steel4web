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
use App\Handle as handle;
use App\Temp_Handle as tempH;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\Response;

class ImportadorController extends Controller {
	
	public function index()
	{  
        $obras = obr::all(); 
        if(\Session::get('history')){
            $subID = \Session::get('history');
            $dados = sub::find($subID);
            $etapaID = $dados->etapa->id;
            $etapas = etap::where('obra_id',$dados->etapa->obra_id)->get();
            $subetapas = sub::where('etapa_id',$dados->etapa_id)->get();
            $imps = imp::where('subetapa_id',$dados->id)->get();
            $history = true;
            return view('importador::index',compact('obras', 'etapas', 'subetapas', 'imps','history','subID','etapaID' ));
        }
		
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
        $impsNr =  count($subetapa->importacoes);
        if($impsNr > 0){
            $sentido = $subetapa->importacoes[0]->sentido;
        }else{
            $sentido = 1;
        }
    	$send = array(
    		'subetapa_id'   =>  $subetapa->id,
            'importacaoNr'  =>  $impsNr,
            'sentido'       =>  $sentido,
            'importacoes'   =>  $subetapa->importacoes,
            'editar'        =>  url('importador/editar'),
            'excluir'       =>  url('importador/excluir'),
            'download'      =>  storage_path().'/app',
            'image'         =>  asset('img/')
    	); 
        return json_encode($send);
    }

    public function gravar(Request $request){
        $getRequest  = $request->all();
        if(isset($getRequest['subetapa_id'])){
          $subetapa_id = $getRequest['subetapa_id'];
          $request->session()->put('subID', $subetapa_id);
        }
        else{
            \Session::flash('flash_danger', '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;  Falha na Importação, Tente Reselecionar a Subetapa.');
            return redirect()->route('importador');
        }
         \Session::flash('history', $subetapa_id);
        if(!empty($getRequest['descricao']))
             $descricao = $getRequest['descricao'];
        else{
            \Session::flash('imp_danger', '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;  Informe a Descrição desta importação.');
            return redirect()->route('importador');
        }
        $observacoes = isset($getRequest['observacoes']) ? $getRequest['observacoes'] : null;
        
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
                         return redirect()->route('importador');
                    }elseif(in_array($ext, $extDone)){
                         \Session::flash('flash_danger', '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;  Falha na Importação, Envie somente um arquivo de cada tipo.');
                        return redirect()->route('importador');
                    }else{
                        $extDone[] = $ext;
                    }
                }
            }
        }

        if(empty($extDone)){
            \Session::flash('imp_danger', '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;  Falha na Importação, Nenhum Arquivo Recebido.');
               return redirect()->route('importador');
        }
        
        $maxSize = 1024 * 1024 * 50;
        $final = array();
        $nroImportacao = count($dados->importacoes);
        $nroImportacao = (!empty($nroImportacao)) ? ($nroImportacao+1) : 1;

        if($nroImportacao == 1){
            if(isset($getRequest['sentido']))
             $sentido     = $getRequest['sentido'];
            else{
                \Session::flash('imp_danger', '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;  Informe o Sentido de Construção.');
                return redirect()->route('importador');
            }
        }else{
            $sentido = $dados->importacoes[0]->sentido;
        }
        
        $path = $dados->locatario_id . "/" . $dados->etapa->obra->cliente_id . "/" . $dados->etapa->obra_id . "/" . $dados->etapa_id . "/" . $dados->id . "/" . $nroImportacao . "/";
         if($nroImportacao <= 1){
            if(count($extDone) < 2){
                \Session::flash('imp_danger', '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;  Arquivos dbf e ifc obrigatorios na primeira Importação.');
                     return redirect()->route('importador');
            }elseif(!in_array('dbf', $extDone)){
                 \Session::flash('imp_danger', '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;  Arquivos dbf e ifc obrigatorios na primeira Importação.');
                     return redirect()->route('importador');
            }elseif(!in_array('ifc', $extDone)){
               \Session::flash('imp_danger', '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;  Arquivos dbf e ifc obrigatorios na primeira Importação.');
                     return redirect()->route('importador');
            }
        } 

        foreach($files as $filex){
            foreach($filex as $file){

                if(isset($file)){
                    if($file->getSize() > $maxSize){
                        \Session::flash('imp_danger', '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;  O arquivo enviado é muito grande, envie arquivos de até 50MB.');
                     return redirect()->route('importador');
                    }
                    $extension = $file->getClientOriginalExtension();
                    $finalName = $file->getClientOriginalName();
                   $checking = Storage::put( $path.$finalName, File::get($file));
                   if(isset($checking)){
                        if(strtolower($extension) == 'dbf'){
                        $final['dbf2d'] = $finalName;
                    }elseif(strtolower($extension) == 'ifc'){
                        $final['ifc_orig'] = $finalName;
                    }elseif(strtolower($extension) == 'fbx'){
                        $final['fbx_orig'] = $finalName;
                    }
                   }

                }
            }   
        }
        $final['locatario_id'] = access()->user()->locatario_id;
        $final['cliente_id'] = $dados->etapa->obra->cliente_id;
        $final['obra_id'] = $dados->etapa->obra_id;
        $final['etapa_id'] = $dados->etapa_id;
        $final['subetapa_id'] = $dados->id;
        $final['importacaoNr'] = $nroImportacao;
        $final['observacoes'] = $observacoes;
        $final['sentido'] = $sentido;
        $final['user_id'] = access()->user()->id;
        $final['descricao'] = $descricao;
        $errorr = array();
        $impSucess = imp::create($final);
        if(isset($impSucess)){
            if(!empty($final['dbf2d'])){
            if($nroImportacao == 1){
                $recordDbf = $this->savedbf($impSucess->id);
              if($recordDbf === false) $errorr['dbf'] = '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp; Falha ao cadastrar DBF, certifique-se de que o arquivo segue o padrão previsto.';
            }else{
                $temp = true;
                 $recordDbf = $this->savedbf($impSucess->id, $temp);
                 if($recordDbf != 'ok'){
                    $errorr['dbf'] = "<p><i class='fa fa-exclamation-triangle'></i>&nbsp;&nbsp;O(s) seguinte(s) conjunto(s): <br><br><strong>
                    ";
                        foreach($recordDbf as $copy){
                            list($mark, $x, $y, $z) = explode('&', $copy);
                            $x = empty($x) ? 0 : $x;
                            $y = empty($y) ? 0 : $y;
                            $z = empty($z) ? 0 : $z;
                            $errorr['dbf'] .= $mark.' - X:'.$x.' - Y:'.$y.' - Z:'.$z.'<br>';
                        }
                     $errorr['dbf'] .= "</strong><br> Ja estão cadastrado(s) no sistema. <br><strong> Importação não realizada.</strong></p>";
                 }elseif($recordDbf === false){
                    $errorr['dbf'] = '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;Falha ao cadastrar DBF, certifique-se de que o arquivo segue o padrão previsto.';
                }
              
               }
             }
            if(!empty($final['ifc_orig'])){
              $convertIFC = $this->converteIfc($impSucess->id);
              if($convertIFC === false) $errorr['ifc'] = '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;Falha ao converter IFC.';
            }
            if(!empty($final['fbx_orig'])){
              $convertFBX = $this->converteFbx($impSucess->id);
              if($convertFBX === false) $errorr['fbx'] = '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;Falha ao converter FBX.';
            }
            if(count($errorr) > 0){
                $erroMsg = '';
                $this->Wrath($impSucess->id);
                foreach($errorr as $ero){
                    $erroMsg .= $ero.'<br>';
                }
                 \Session::flash('imp_danger', $erroMsg);
                     return redirect()->route('importador');
            }else{
                \Session::flash('flash_success', '<i class="fa fa-check"></i>&nbsp;&nbsp;  Importação realizada com sucesso!');
                return redirect()->route('importador'); 
                
            }
        }else{
            \Session::flash('imp_danger', '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;  Falha ao Importar.');
                return redirect()->route('importador');
        }
    }

    private function savedbf($importacaoID,$temp = null) {
        $check = true;
        $desc = $this->getFields();
        $dados = imp::find($importacaoID);
        $path = storage_path().'/app';
        $arquivo = $path . "/" . $dados->locatario_id . "/" . $dados->cliente_id . "/" . $dados->obra_id . "/" 
        . $dados->etapa_id . "/" . $dados->subetapa_id . "/" . $dados->importacaoNr . "/" . $dados->dbf2d;
        $fdbf = fopen($arquivo,'r'); 
        $fields = array(); 
        $buf = fread($fdbf,32); 
        $header=unpack( "VRecordCount/vFirstRecord/vRecordLength", substr($buf,4,8));
        $goon = true; 
    $unpackString=''; 
    while ($goon && !feof($fdbf)) { // read fields: 
        $buf = fread($fdbf,32); 
        if (substr($buf,0,1)==chr(13)) {$goon=false;} // end of field list 
        else { 
            $field=unpack( "a11fieldname/A1fieldtype/Voffset/Cfieldlen/Cfielddec", substr($buf,0,18));
                $unpackString.="A$field[fieldlen]$field[fieldname]/"; 
                array_push($fields, $field);}} 
        fseek($fdbf, $header['FirstRecord']+1); // move back to the start of the first record (after the field definitions)
        for ($i=1; $i<=$header['RecordCount']; $i++) { 
            $buf = fread($fdbf,$header['RecordLength']); 
            $record=unpack($unpackString,$buf);

        if($record['NUM_COM'] != 'MATHEUS' && $record['NUM_DIS'] != 'TESTANDO'){

        if(!isset($chekc)){
          $RKeys = array_keys($record);
              foreach($RKeys as $key){
                if(in_array($key, $desc)){
                    $check = $check;
                }else{
                    $check = false;
                }
              }
              foreach($desc as $ddd){
                if(in_array($ddd, $RKeys)){
                    $check = $check;
                }else{
                    $check = false;
                }
              }
              if($check === false){
                fclose($fdbf);
                return false;
              }else{
                $chekc = 1;
              }
              
         }

            $record['obra_id']         = $dados->obra_id;
            $record['etapa_id']      = $dados->etapa_id;
            $record['importacao_id'] = $dados->id;
            $record['subetapa_id']  = $dados->subetapa_id;
            $record['locatario_id']    = access()->user()->locatario_id;
            $record['user_id']    = access()->user()->id;
         if(isset($temp)){
            $importID = tempH::create($record);
         }else{
            $importID = handle::create($record);
         }
           
       }
        }
        if(isset($importID) && isset($temp)){
           $tempCheck = $this->checkTemp($dados->id);
           if($tempCheck == 'ok'){
                $this->insertTemp($importacaoID);
                $tempDel = tempH::where('importacao_id',$importacaoID);
                $tempDel = tempH::delete();
                fclose($fdbf);
                return 'ok';
            }else{
                fclose($fdbf);
                return $tempCheck; 
            }
        }
         
    }

    private function checkTemp($importacaoID){
    $dados = tempH::where('importacao_id',$importacaoID)->get();
    $here = handle::where('subetapa_id',$dados[0]->subetapa_id)->get();
    $xyz = array();
    $x=0;
    foreach($dados as $dado){
        if($dado->FLG_REC == 3 && $dado->NUM_COM != 'MATHEUS' && $dado->NUM_DIS != 'TESTANDO'){
            foreach($here as $hr){
                if($hr->FLG_REC == 3){
                    if($dado->X == $hr->X && $dado->Y == $hr->Y && $dado->Z == $hr->Z){
                        $tempxyz = $dado->MAR_PEZ.'&'.str_replace(' ', '', $dado->X).'&'.str_replace(' ', '', $dado->Y).'&'.str_replace(' ', '', $dado->Z);
                        if(!in_array($tempxyz, $xyz)){
                            $xyz[] = $tempxyz;
                        }
                    }
                }
            }
        }
    }
       $xyz = !empty($xyz[0]) ? $xyz : 'ok';
       return $xyz;
    }

    private function insertTemp($importacaoID){

        $dados = tempH::where('importacao_id',$importacaoID)->get();
        foreach($dados as $dado){
            dd($dado);
            unset($dado->id);
            $importID = handle::create($dado);
        }
        if(!empty($importID)){
            return $importID;
        }else{
            return false;
        }
    }

    private function converteIfc($importacaoID)
    {

        $dados = imp::find($importacaoID);

        $path = storage_path().'/app/' . $dados->locatario_id . "/" . $dados->cliente_id . "/" . $dados->obra_id . "/" . $dados->etapa_id . "/" 
        . $dados->subetapa_id . "/" . $dados->importacaoNr . "/";

        $Ifc_File = $path . $dados->ifc_orig;

        $IFC_convert_exe = base_path().'/exe/ifcconvert.exe';

        $ifcfile = $dados->importacaoNr . "_ifc.obj";
        $Ifc_Destino = $path . $ifcfile;

        exec("$IFC_convert_exe --use-object-type --convert-back-units $Ifc_File $Ifc_Destino");

        if(file_exists($Ifc_Destino)) {
            $attibutes = array(
                'ifc'      => $ifcfile
                );

            $dates = imp::find($importacaoID)->update($attibutes);
            return true;
        }
        return false;
    }

     private function converteFbx($importacaoID)
    {


         $dados = imp::find($importacaoID);

        $path = storage_path().'/app/' . $dados->locatario_id . "/" . $dados->cliente_id . "/" . $dados->obra_id . "/" . $dados->etapa_id . "/" 
        . $dados->subetapa_id . "/" . $dados->importacaoNr . "/";

        $Fbx_File = $path . $dados->fbx_orig;

        $FBX_convert_exe = base_path().'/exe/FbxConverter.exe';

        $fbxfile = $dados->importacaoNr . "_fbx.obj";
        $Fbx_Destino = $path . $fbxfile;

        exec("$FBX_convert_exe $Fbx_File $Fbx_Destino");

       if(file_exists($Fbx_Destino)) {
            $attibutes = array(
                'fbx'      => $fbxfile
                );

            $dates = imp::find($importacaoID)->update($attibutes);
            return true;
        }
        return false;
    } 

    public function download(Request $request){
        $dados = $request->all();
        list($impId, $ext) = explode('&&&',$dados['data']);
        $imp = imp::find($impId);
        if($ext == 'dbf')
            $file = $imp->dbf2d;
        elseif($ext=='ifc_orig')
            $file = $imp->ifc_orig;
        else
            $file = $imp->fbx_orig;
        
        $path = storage_path('app').'/'.$imp->locatario_id.'/'.$imp->obra->cliente_id.'/'.$imp->obra_id.'/'.$imp->etapa_id.'/'.$imp->subetapa_id.'/'.$imp->importacaoNr.'/'.$file;
        return response()->download($path);

    }

    
 

    private function Wrath($Morgoth){
        $Angband = imp::find($Morgoth);
        $Balrogs = tempH::where('importacao_id',$Morgoth);
        $Finarfin = $Balrogs->get();
        if(!empty($Finarfin))
             $Balrogs = tempH::where('importacao_id',$Morgoth)->delete();
        $Ancalagon = handle::where('importacao_id',$Morgoth);
        $Earendil  = $Ancalagon->get();
        if(!empty($Earendil))
             $Ancalagon = tempH::where('importacao_id',$Morgoth)->delete();
        $IronHills = storage_path().'/app/'.$Angband->locatario_id . "/" . $Angband->obra->cliente_id . "/" . $Angband->obra_id . "/" . $Angband->etapa_id . "/" . $Angband->subetapa_id . "/" . $Angband->importacaoNr;
        $Ruin = File::deleteDirectory($IronHills);
        $Angband->delete();
    }


    private function getFields(){
        $fields = [
        'HANDLE',
        'FLG_REC',
        'NUM_COM',
        'DES_COM',
        'LOT_COM',
        'DLO_COM',
        'CLI_COM',
        'IND_COM',
        'DT1_COM',
        'DT2_COM',
        'NUM_DIS',
        'DES_DIS',
        'NOM_DIS',
        'REV_DIS',
        'DAT_DIS',
        'TRA_PEZ',
        'SBA_PEZ',
        'DES_SBA',
        'TIP_PEZ',
        'MAR_PEZ',
        'MBU_PEZ',
        'DES_PEZ',
        'POS_PEZ',
        'NOT_PEZ',
        'ING_PEZ',
        'MAX_LEN',
        'QTA_PEZ',
        'QT1_PEZ',
        'MCL_PEZ',
        'COD_PEZ',
        'COS_PEZ',
        'NOM_PRO',
        'LUN_PRO',
        'LAR_PRO',
        'SPE_PRO',
        'MAT_PRO',
        'TIP_BUL',
        'DIA_BUL',
        'LUN_BUL',
        'PRB_BUL',
        'PUN_LIS',
        'SUN_LIS',
        'PRE_LIS',
        'FLG_DWG',
        'GROUP',
        'CATE',
        'X',
        'Y',
        'Z',
        'A',
        'B'
    ];

    return $fields;
    }

	
}