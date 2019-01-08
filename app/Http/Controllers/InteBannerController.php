<?php
/***积分商城首页banner后台上传***/
/***开发：田鑫***/
namespace App\Http\Controllers;
use Session;
use DB;
use CRUDbooster;
use Illuminate\Http\Request;
class InteBannerController Extends \crocodicstudio\crudbooster\controllers\CBController {
    public function index(){
        $banner1=DB::table('cancel_banner1')->orderBy('banner_dates','desc')->first();
        $banner2=DB::table('cancel_banner2')->orderBy('banner_dates','desc')->first();
        $banner3=DB::table('cancel_banner3')->orderBy('banner_dates','desc')->first();
        return view('InteBanner.index',['banner1'=>$banner1,'banner2'=>$banner2,'banner3'=>$banner3]);
    }
    public function upload1(Request $request){
        if($request->banner_id){
            $banner_id=$request->banner_id;
            if($request->hasFile('banner1')){
                $arr = array("png", "jpg", "gif", "bmp","jpeg");
                $extension = $request->file('banner1')->extension();
                if(in_array($extension,$arr)){
                    $banner1_url=$request->banner1_url;
                    $path=$request->file('banner1')->store('banner1');
                    $path='/storage/'.$path;
                    if($path){
                        $res=DB::table('cancel_banner1')->where('banner_id',$banner_id)->update(['banner_url'=>$banner1_url,'banner_path'=>$path,'banner_dates'=>time()]);
                        if($res){
                            return json_encode(['status'=>1,'banner_path'=>$path,'banner_url'=>$banner1_url,'msg'=>'上传成功']);
                        }else{
                            return json_encode(['status'=>0,'msg'=>'上传失败']);
                        }
                    }else{
                        return json_encode(['status'=>0,'msg'=>'上传失败']);
                    }
                }else{
                    return json_encode(['status'=>2,'msg'=>'请检查文件类型']);
                }
            }elseif($request->banner1_path){
                $banner1_path=$request->banner1_path;
                $banner1_url=$request->banner1_url;
                $res=DB::table('cancel_banner1')->where('banner_id',$banner_id)->update(['banner_url'=>$banner1_url,'banner_path'=>$banner1_path,'banner_dates'=>time()]);
                if($res){
                    return json_encode(['status'=>1,'banner_path'=>$banner1_path,'banner_url'=>$banner1_url,'msg'=>'更新成功']);
                }else{
                    return json_encode(['status'=>0,'msg'=>'更新失败']);
                }
            }
        }else{
            if($request->hasFile('banner1')){
                $arr = array("png", "jpg", "gif", "bmp","jpeg");
                $extension = $request->file('banner1')->extension();
                if(in_array($extension,$arr)){
                    $banner1_url=$request->banner1_url;
                    $path=$request->file('banner1')->store('banner1');
                    $path='/storage/'.$path;
                    if($path){
                        $res=DB::table('cancel_banner1')->insert(['banner_url'=>$banner1_url,'banner_path'=>$path,'banner_dates'=>time()]);
                        if($res){
                            return json_encode(['status'=>1,'banner_path'=>$path,'banner_url'=>$banner1_url,'msg'=>'上传成功']);
                        }else{
                            return json_encode(['status'=>0,'msg'=>'上传失败']);
                        }
                    }else{
                        return json_encode(['status'=>0,'msg'=>'上传失败']);
                    }
                }else{
                    return json_encode(['status'=>2,'msg'=>'请检查文件类型']);
                }
            }else{
                return json_encode(['status'=>0,'msg'=>'上传失败']);
            }
        }
    }
    public function upload2(Request $request)
    {
        if ($request->banner_id) {
            $banner_id = $request->banner_id;
            if ($request->hasFile('banner2')) {
                $arr = array("png", "jpg", "gif", "bmp", "jpeg");
                $extension = $request->file('banner2')->extension();
                if (in_array($extension, $arr)) {
                    $banner2_url = $request->banner2_url;
                    $path = $request->file('banner2')->store('banner2');
                    $path = '/storage/' . $path;
                    if ($path) {
                        $res = DB::table('cancel_banner2')->where('banner_id', $banner_id)->update(['banner_url' => $banner2_url, 'banner_path' => $path, 'banner_dates' => time()]);
                        if ($res) {
                            return json_encode(['status' => 1, 'banner_path' => $path, 'banner_url' => $banner2_url, 'msg' => '上传成功']);
                        } else {
                            return json_encode(['status' => 0, 'msg' => '上传失败']);
                        }
                    } else {
                        return json_encode(['status' => 0, 'msg' => '上传失败']);
                    }
                } else {
                    return json_encode(['status' => 2, 'msg' => '请检查文件类型']);
                }
            } elseif ($request->banner2_path) {
                $banner2_path = $request->banner2_path;
                $banner2_url = $request->banner2_url;
                $res = DB::table('cancel_banner2')->where('banner_id', $banner_id)->update(['banner_url' => $banner2_url, 'banner_path' => $banner2_path, 'banner_dates' => time()]);
                if ($res) {
                    return json_encode(['status' => 1, 'banner_path' => $banner2_path, 'banner_url' => $banner2_url, 'msg' => '更新成功']);
                } else {
                    return json_encode(['status' => 0, 'msg' => '更新失败']);
                }
            }
        } else {
            if ($request->hasFile('banner2')) {
                $arr = array("png", "jpg", "gif", "bmp", "jpeg");
                $extension = $request->file('banner2')->extension();
                if (in_array($extension, $arr)) {
                    $banner2_url = $request->banner2_url;
                    $path = $request->file('banner2')->store('banner2');
                    $path = '/storage/' . $path;
                    if ($path) {
                        $res = DB::table('cancel_banner2')->insert(['banner_url' => $banner2_url, 'banner_path' => $path, 'banner_dates' => time()]);
                        if ($res) {
                            return json_encode(['status' => 1, 'banner_path' => $path, 'banner_url' => $banner2_url, 'msg' => '上传成功']);
                        } else {
                            return json_encode(['status' => 0, 'msg' => '上传失败']);
                        }
                    } else {
                        return json_encode(['status' => 0, 'msg' => '上传失败']);
                    }
                } else {
                    return json_encode(['status' => 2, 'msg' => '请检查文件类型']);
                }
            } else {
                return json_encode(['status' => 0, 'msg' => '上传失败']);
            }
        }
    }
    public function upload3(Request $request)
    {
        if ($request->banner_id) {
            $banner_id = $request->banner_id;
            if ($request->hasFile('banner3')) {
                $arr = array("png", "jpg", "gif", "bmp", "jpeg");
                $extension = $request->file('banner3')->extension();
                if (in_array($extension, $arr)) {
                    $banner3_url = $request->banner3_url;
                    $path = $request->file('banner3')->store('banner3');
                    $path = '/storage/' . $path;
                    if ($path) {
                        $res = DB::table('cancel_banner3')->where('banner_id', $banner_id)->update(['banner_url' => $banner3_url, 'banner_path' => $path, 'banner_dates' => time()]);
                        if ($res) {
                            return json_encode(['status' => 1, 'banner_path' => $path, 'banner_url' => $banner3_url, 'msg' => '上传成功']);
                        } else {
                            return json_encode(['status' => 0, 'msg' => '上传失败']);
                        }
                    } else {
                        return json_encode(['status' => 0, 'msg' => '上传失败']);
                    }
                } else {
                    return json_encode(['status' => 2, 'msg' => '请检查文件类型']);
                }
            } elseif ($request->banner3_path) {
                $banner3_path = $request->banner3_path;
                $banner3_url = $request->banner3_url;
                $res = DB::table('cancel_banner3')->where('banner_id', $banner_id)->update(['banner_url' => $banner3_url, 'banner_path' => $banner3_path, 'banner_dates' => time()]);
                if ($res) {
                    return json_encode(['status' => 1, 'banner_path' => $banner3_path, 'banner_url' => $banner3_url, 'msg' => '更新成功']);
                } else {
                    return json_encode(['status' => 0, 'msg' => '更新失败']);
                }
            }
        } else {
            if ($request->hasFile('banner3')) {
                $arr = array("png", "jpg", "gif", "bmp", "jpeg");
                $extension = $request->file('banner3')->extension();
                if (in_array($extension, $arr)) {
                    $banner3_url = $request->banner3_url;
                    $path = $request->file('banner3')->store('banner3');
                    $path = '/storage/' . $path;
                    if ($path) {
                        $res = DB::table('cancel_banner3')->insert(['banner_url' => $banner3_url, 'banner_path' => $path, 'banner_dates' => time()]);
                        if ($res) {
                            return json_encode(['status' => 1, 'banner_path' => $path, 'banner_url' => $banner3_url, 'msg' => '上传成功']);
                        } else {
                            return json_encode(['status' => 0, 'msg' => '上传失败']);
                        }
                    } else {
                        return json_encode(['status' => 0, 'msg' => '上传失败']);
                    }
                } else {
                    return json_encode(['status' => 2, 'msg' => '请检查文件类型']);
                }
            } else {
                return json_encode(['status' => 0, 'msg' => '上传失败']);
            }
        }
    }
}
?>

