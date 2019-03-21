<?php
namespace App\Http\Controllers\Matter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Storage;

class MatterController extends Controller
{
    public function matter()
    {
        $key = "accesstoken";
        $accessToken = cache($key);
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$accessToken&type=image";
        $file = "./imgs/a3.jpg";
        $filesize = filesize($file);
        //echo $filesize;
        $objimg = new \CURLFile($file);
        //dump($objimg);
        //exit;
        $media = array(
            'media_id' => $objimg,
            "form-data" => array(
                'filename' => "a3.jpg",
                'filelength' => "$filesize",
                'content-type' => "image/jpeg",
            ),
        );
        $obj = new \url();
        $val = $obj->sendPost($url, $media);
        //dump($val);

    }

    public function getmatter()
    {
        $key = "accesstoken";
        $accessToken = cache($key);
        $media_id = "zpRV0P07-spkqNAlmFRnefLc25DVY6yJF3A35bE6glTO7Qnju6X_xfY-NgqJDXMo";
        $url = "https://api.weixin.qq.com/cgi-bin/media/get?access_token=$accessToken&media_id=$media_id";
        $obj = new \url();
        $val = $obj->sendGet($url);
        //dump($val);
        file_put_contents("./imgs/aaaaa.jpg", $val);
    }

    /*
     * 图片上传*/
    public function upload(Request $request)
    {
        if ($request->isMethod('POST')) { //判断是否是POST上传
            $fileCharater = $request->file('file');
            if ($fileCharater->isValid()) {
                //获取文件绝对路径
                $ext = $fileCharater->getClientOriginalExtension();
                $path = $fileCharater->getRealPath();
                $filename = md5(time())."{$ext}" ;
                Storage::disk('public')->put($filename, file_get_contents($path));
                $filepath="./uploads/$filename";
                $info = $this->matter($filepath);
                $arrimg = json_decode($info,true);
                $media_id = $arrimg['median_id'];
                $presenttime = time();
                $time = time()+86400*3;
                $data = array(
                        'media_id'=>$media_id,
                        'time'=> $time,
                        'filepath' => $filepath,
                        'presenttime' => $presenttime,
                );
                $this->cache($data);

            }
        }
        return view('matter.matter');
    }
    public function cache($data){
        $redis = new \redis();
        $redis->connect("127.0.0.1",6379);//exit;
        $id = $redis->incr('id');
        $hest = "id_{$id}";
        $like = "redis";
        //dump($data);
        $redis->hset($hest,"id",$id);
        $redis->hset($hest,"media_id",$data['media_id']);
        $redis->hset($hest,"time",$data['time']);
        $redis->hset($hest,"presenttime",$data['presenttime']);
        $redis->hset($hest,"filepath",$data['filepath']);
        $redis->rPush($like,$hest);
    }
    public function showupload(){

        $first=empty($_GET['page'])?1:$_GET['page'];
        $pnum=1;
        $limit=($first-1)*$pnum;  //开始位置
        $end=$limit+$pnum-1;
        $redis = new \redis();
        $redis->connect("127.0.0.1",6379);//exit;
        $like="redis";
        $count=$redis->llen($like);
        $last=ceil($count/$pnum);

        $data=$redis->lrange($like,$limit,$end);
        foreach ($data as $k=>$v){
            $arr[]=$redis->hGetAll($v);
        }
        if(!empty($arr)){
//            dump($arr);exit;
            foreach($arr as $k=>$v){
                $arr[$k]['presenttime']=date("Y:m:d  H:i:s",$v['presenttime']);
                $arr[$k]['time']=date("Y:m:d  H:i:s",$v['time']);
            }
//            dump($arr);
            $page=[
                'first'=>1,
                'prevpage'=>$first-1<1?1:$first-1,
                'nextpage'=>$first+1>$last?$last:$first+1,
                'total'=>$last
            ];
            return view('matter.mattershow',['data'=>$arr,'arr'=>$page]);
        }else{
            echo "暂时未查到你说需要的素材";die;
        }
    }

}
