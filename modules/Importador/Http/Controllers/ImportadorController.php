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
        $impsNr =  count($subetapa->importacoes);
    	$send = array(
    		'subetapa_id'   =>  $subetapa->id,
            'importacaoNr'  =>  $impsNr
    	); 
        return json_encode($send);
    }

    public function gravar(Request $request){
        $getRequest  = $request->all();
        $subetapa_id = $getRequest['subetapa_id'];
        $sentido     = $getRequest['sentido'];
        $observacoes = $getRequest['observacoes'];
        $descricao = $getRequest['descricao'];
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
        $maxSize = 1024 * 1024 * 50;
        $final = array();
        $nroImportacao = count($dados->importacao);
        $nroImportacao = (!empty($nroImportacao)) ? (count($nroImportacao)+1) : 1;
        $path = $dados->locatario_id . "/" . $dados->etapa->obra->cliente_id . "/" . $dados->etapa->obra_id . "/" . $dados->etapa_id . "/" . $dados->id . "/" . $nroImportacao . "/";
        foreach($files as $filex){
            foreach($filex as $file){

                if(isset($file)){
                    if($file->getSize() > $maxSize){
                        \Session::flash('imp_danger', '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;  O arquivo enviado é muito grande, envie arquivos de até 50MB.');
                     return back()->withInput();
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

        $impSucess = imp::create($final);
        if(isset($impSucess)){
            if(!empty($final['dbf2d'])){
              $recordDbf = $this->savedbf($impSucess->id);
            }
            if(!empty($final['ifc_orig'])){
              $convertIFC = $this->converteIfc($impSucess->id);
            }
            if($recordDbf !== false && $convertIFC !== false){
                \Session::flash('flash_success', '<i class="fa fa-check"></i>&nbsp;&nbsp;  Importação realizada com sucesso!');
                return redirect()->route('importador'); 
            }else{
                 \Session::flash('imp_danger', '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;  Falha ao cadastrar DBF, certifique-se de que o arquivo segue o padrão previsto..');
                     return back()->withInput();
            }

           
        }
    }

    private function savedbf($importacaoID) {
        $check = true;
        $desc = $this->getFields();
        $dados = imp::find($importacaoID);
        $path = 'C:/xampp/htdocs/FeeltheSteel/storage/app';
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
            $record['locatario_id']    = access()->user()->locatario_id;
            $record['user_id']    = access()->user()->id;
         
           $importID = handle::create($record);
       }
        }
        if(!empty($importID)){
            fclose($fdbf);
            return $importID;
        }else{
            fclose($fdbf);
            return false;
        }
         
    }

    private function converteIfc($importacaoID)
    {

        $dados = imp::find($importacaoID);

        $path = 'C:/xampp/htdocs/FeeltheSteel/storage/app/' . $dados->locatario_id . "/" . $dados->cliente_id . "/" . $dados->obra_id . "/" . $dados->etapa_id . "/" 
        . $dados->subetapa_id . "/" . $dados->importacaoNr . "/";

        $Ifc_File = $path . $dados->ifc_orig;

        $IFC_convert_exe = 'C:/xampp/htdocs/FeeltheSteel/exe/ifcconvert.exe';

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

        $path = 'C:/xampp/htdocs/FeeltheSteel/storage/app/' . $dados->locatario_id . "/" . $dados->cliente_id . "/" . $dados->obra_id . "/" . $dados->etapa_id . "/" 
        . $dados->subetapa_id . "/" . $dados->importacaoNr . "/";

        $Fbx_File = $path . $dados->fbx_orig;

        $FBX_convert_exe = 'C:/xampp/htdocs/FeeltheSteel/exe/FbxConverter.exe';

        $fbxfile = $dados->importacaoNr . "_fbx.obj";
        $Fbx_Destino = $path . $fbxfile;

        exec("$FBX_convert_exe $Fbx_File $Fbx_Destino");

        if(file_exists($Fbx_Destino)){
            $attibutes = array(
                    'arquivo'      => $fbxfile,
                    'locatario_id'  => $dados->locatario_id,
                    'cliente_id'    => $dados->cliente_id,
                    'obra_id'       => $dados->obra_id,
                    'etapa_id'      => $dados->etapa_id,
                    'subetapa_id'   => $dados->subetapa_id,
                    'importacaoNr' => $dados->importacaoNr,
                    'observacoes'  => 'Convertido pelo sistema'
                    );

            $importacaoID = $this->import->insert($attibutes);
            return true;
        }
        return false;
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