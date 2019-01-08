<?php
/***积分积分明细列表***/
/***开发：田鑫***/
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class InteDetailsController Extends Controller{
    public function index(){
        date_default_timezone_set('PRC');
        $thisMonth=date("Y-m",time());
        $day_counts = date('t', strtotime($thisMonth));
        if($day_counts==28){
            $time_Begin=strtotime($thisMonth.'-01 00:00:00');
            $time_midd=strtotime($thisMonth.'-01 23:59:59');
            $time_End=strtotime($thisMonth.'-28 23:59:59');
        }elseif($day_counts==29){
            $time_Begin=strtotime($thisMonth.'-01 00:00:00');
            $time_midd=strtotime($thisMonth.'-01 23:59:59');
            $time_End=strtotime($thisMonth.'-29 23:59:59');
        }elseif($day_counts==30){
            $time_Begin=strtotime($thisMonth.'-01 00:00:00');
            $time_midd=strtotime($thisMonth.'-01 23:59:59');
            $time_End=strtotime($thisMonth.'-30 23:59:59');
        }else{
            $time_Begin=strtotime($thisMonth.'-01 00:00:00');
            $time_midd=strtotime($thisMonth.'-01 23:59:59');
            $time_End=strtotime($thisMonth.'-31 23:59:59');
        }
        $url=config('wechat.official_account.default.list');
        $data=[
            'client_id'=>config('wechat.official_account.default.client_id'),
            'client_secret'=>config('wechat.official_account.default.client_secret'),
            'user_id'=>session('pointUserId'),
            'user_uuid'=>session('useruuid'),
            'access_token'=>session('pointAccessToken'),
            'start_date'=>$time_Begin,
            'end_date'=>$time_End,
        ];
        $arr=$this->curl_post($url,$data);
        if($arr['list']!=''){
            for($i=0;$i<16;$i++){
                $line[$i]=0;
                if($i==0){
                    foreach($arr['list'] as $val){
                        if(($time_Begin<=$val['created_at'])&&($val['created_at']<$time_midd)){
                            $line[$i]+=$val['bonus_point'];
                        }
                    }
                }else{
                    $time_B=$time_midd+172800*($i-1);
                    $time_E=$time_midd+172800*$i;
                    foreach($arr['list'] as $val){
                        if(($time_B<=$val['created_at'])&&($val['created_at']<$time_E)){
                            $line[$i]+=$val['bonus_point'];
                        }
                    }
                }
            }
            $curve_line=implode(',',$line);
        }else{
            for($i=0;$i<16;$i++){
                $line[$i]=0;
            }
            $curve_line=implode(',',$line);
        }
        return view('InteDetails.index',['arr'=>$arr,'thisMonth'=>$thisMonth,'curve_line'=>$curve_line]);
    }
    public function curl_post($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);
        $arr = json_decode($res, true);
        curl_close($ch);
        return $arr;
    }
    public function resContents(Request $request){
        date_default_timezone_set('PRC');
        $dates=$request->dates;
        $day_counts = date('t', strtotime($dates));
        if($day_counts==28){
            $time_Begin=strtotime($dates.'-01 00:00:00');
            $time_End=strtotime($dates.'-28 23:59:59');
        }elseif($day_counts==29){
            $time_Begin=strtotime($dates.'-01 00:00:00');
            $time_End=strtotime($dates.'-29 23:59:59');
        }elseif($day_counts==30){
            $time_Begin=strtotime($dates.'-01 00:00:00');
            $time_End=strtotime($dates.'-30 23:59:59');
        }else{
            $time_Begin=strtotime($dates.'-01 00:00:00');
            $time_End=strtotime($dates.'-31 23:59:59');
        }
        $url=config('wechat.official_account.default.list');
        $data=[
            'client_id'=>config('wechat.official_account.default.client_id'),
            'client_secret'=>config('wechat.official_account.default.client_secret'),
            'user_id'=>session('pointUserId'),
            'user_uuid'=>session('useruuid'),
            'access_token'=>session('pointAccessToken'),
            'start_date'=>$time_Begin,
            'end_date'=>$time_End,
        ];
        $arr=$this->curl_post($url,$data);
        return $arr;
    }
    public function curve(Request $request){
        date_default_timezone_set('PRC');
        $dates=$request->dates;
        $day_counts = date('t', strtotime($dates));
        if($day_counts==28){
            $time_Begin=strtotime($dates.'-01 00:00:00');
            $time_midd=strtotime($dates.'-01 23:59:59');
            $time_End=strtotime($dates.'-28 23:59:59');
        }elseif($day_counts==29){
            $time_Begin=strtotime($dates.'-01 00:00:00');
            $time_midd=strtotime($dates.'-01 23:59:59');
            $time_End=strtotime($dates.'-29 23:59:59');
        }elseif($day_counts==30){
            $time_Begin=strtotime($dates.'-01 00:00:00');
            $time_midd=strtotime($dates.'-01 23:59:59');
            $time_End=strtotime($dates.'-30 23:59:59');
        }else{
            $time_Begin=strtotime($dates.'-01 00:00:00');
            $time_midd=strtotime($dates.'-01 23:59:59');
            $time_End=strtotime($dates.'-31 23:59:59');
        }
        $url=config('wechat.official_account.default.list');
        $data=[
            'client_id'=>config('wechat.official_account.default.client_id'),
            'client_secret'=>config('wechat.official_account.default.client_secret'),
            'user_id'=>session('pointUserId'),
            'user_uuid'=>session('useruuid'),
            'access_token'=>session('pointAccessToken'),
            'start_date'=>$time_Begin,
            'end_date'=>$time_End,
        ];
        $arr=$this->curl_post($url,$data);
        if($arr['list']!=''){
            for($i=0;$i<16;$i++){
                $line[$i]=0;
                if($i==0){
                    foreach($arr['list'] as $val){
                        if(($time_Begin<=$val['created_at'])&&($val['created_at']<$time_midd)){
                            $line[$i]+=$val['bonus_point'];
                        }
                    }
                }else{
                    $time_B=$time_midd+172800*($i-1);
                    $time_E=$time_midd+172800*$i;
                    foreach($arr['list'] as $val){
                        if(($time_B<=$val['created_at'])&&($val['created_at']<$time_E)){
                            $line[$i]+=$val['bonus_point'];
                        }
                    }
                }
            }
        }else{
            for($i=0;$i<16;$i++){
                $line[$i]=0;
            }
        }
        return json_encode($line);
    }
}
?>

