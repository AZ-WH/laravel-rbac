<?php
/**
 * Created by PhpStorm.
 * User: woody
 * Date: 17-2-16
 * Time: 下午10:46
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Admin\AdminController;

class UploadController extends AdminController {

    public function __construct()
    {
    }


    /**
     * @param Request $request
     * @return mixed
     * 上传本地服务器
     */
    public function uploadImg(Request $request , $owner) {

        $param = 'imgs';

        if($request->hasFile($param)){

            $file = $request->file($param);

            $destinationPath	= "/tmp/upload/{$owner}/";
            $filename			= uniqid();

            $exten = substr($file->getClientOriginalName()  , strpos($file->getClientOriginalName() , '.' ) + 1 );

            if( $request->file($param)->isValid() ){
                if( $file->move($destinationPath , $filename . '.' . $exten )  ){
                    $filePath = "/upload/{$owner}/".$filename.'.'.$exten;
                    return response()->json( array( 'code' => 0 , 'img_path' => $filePath ) );
                }
            }
        }
        return response()->json( array( 'code' => -1001 ) );
    }

}