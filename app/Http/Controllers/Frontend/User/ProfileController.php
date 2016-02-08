<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\User\UserContract;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Models\Access\User\User as userr;
use App\Images as img;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;
use Image;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Frontend
 */
class ProfileController extends Controller
{
    /**
     * @return mixed
     */
    public function edit()
    {
        return view('frontend.user.profile.edit')
            ->withUser(access()->user());
    }

    /**
     * @param  UserContract         $user
     * @param  UpdateProfileRequest $request
     * @return mixed
     */
    public function update(UserContract $user, UpdateProfileRequest $request)
    {
        $ThisUser = userr::find(access()->id());
        $dados = $request->all();
        if(isset( $request['image'])){
             $image = $request['image'];
            $exts = array('jpg', 'jpeg', 'png', 'gif', 'jpe', 'jif', 'jfif', 'jfi');
            $extension = $image->getClientOriginalExtension();
            if(!in_array($extension, $exts)){
                return back()->withFlashDanger('Formato de Imagem invalido (aceitos: jpg, png e gif)');
            }
        $name = $this->toAscii($ThisUser->name.'x'.date('yxmxdxhxixs')).'.'.$extension;
        $path = 'avatar/'.access()->user()->locatario_id.'/'.access()->id().'/';
        $deleteAll = File::deleteDirectory(storage_path().'/app/'.$path);
        $checking = Storage::put( $path.$name, File::get($image));
        if(isset($checking)){
            
            $ThisImage = img::where('user_id',access()->id())->delete();
            $attr = array('user_id' => access()->id(), 'image' => $name);
            $img = img::create($attr);
        }
        }
       
        $user->updateProfile(access()->id(), $dados);
        \Session::flash('flash_success', '<i class="fa fa-check"></i>&nbsp;&nbsp;  Perfil Editado com Sucesso!');
        return redirect()->route('frontend.user.perfil');
    }

    public function preview($id){
        $file = img::find($id);
        $path = storage_path('app/avatar/') . access()->user()->locatario_id.'/'.access()->id().'/'.$file->image;
        $handler = new \Symfony\Component\HttpFoundation\File\File($path);
        $handler->getMTime();
        $handler->getMimeType();
        $handler->getSize();
        $lifetime = 31556926;

        $file_time = $handler->getMTime(); // Get the last modified time for the file (Unix timestamp)
        $header_content_type = $handler->getMimeType();
        $header_content_length = $handler->getSize();
        $header_etag = md5($file_time . $path);
        $header_last_modified = gmdate('r', $file_time);
        $header_expires = gmdate('r', $file_time + $lifetime);
        $headers = array(
            'Content-Disposition' => 'inline; filename="' . $file->image . '"',
            'Last-Modified' => $header_last_modified,
            'Cache-Control' => 'must-revalidate',
            'Expires' => $header_expires,
            'Pragma' => 'public',
            'Etag' => $header_etag
        );
        $h1 = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $_SERVER['HTTP_IF_MODIFIED_SINCE'] == $header_last_modified;
        $h2 = isset($_SERVER['HTTP_IF_NONE_MATCH']) && str_replace('"', '', stripslashes($_SERVER['HTTP_IF_NONE_MATCH'])) == $header_etag;
        if ($h1 || $h2) {
            return (new Response('', 304, $headers));
        }
        $headers = array_merge($headers, array(
            'Content-Type' => $header_content_type,
            'Content-Length' => $header_content_length
        ));

     //   return Response::make(file_get_contents($path), 200, $headers);
        return (new Response(file_get_contents($path), 200, $headers));





    }

    
    private function toAscii($str) {
        setlocale(LC_ALL, 'pt_BR.UTF8');
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_| -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_| -]+/", '-', $clean);

    return $clean;
}

}