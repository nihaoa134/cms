<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function upload(){
     return view('upload.upload');
    }
    public function uploadinfo(){
        $data = $_FILES;
        $tmpname = $data['file']['tmp_name'];
        $info = file_get_contents($tmpname);
        $name = $data['file']['name'];
        $res = file_put_contents("./imgs/$name",$info,FILE_APPEND);
        echo json_encode($res);
    }
}
