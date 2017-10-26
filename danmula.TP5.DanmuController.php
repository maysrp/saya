<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 老猫 <thinkcmf@126.com>
// +----------------------------------------------------------------------
namespace app\portal\controller;

use cmf\controller\HomeBaseController;
use app\user\model\DanmuModel;

class DanmuController extends HomeBaseController
{
    public function index(){
        header("access-control-allow-origin:*");
        $id=$this->request->param('id', 0, 'intval');
        $max=$this->request->param('max', 1000, 'intval');
        $request_body = file_get_contents('php://input');
        $info=json_decode($request_body,true);
        $info['ip']=get_client_ip(0,true);
        $Danmu=new DanmuModel();
        if($id){
            $re=D('Danmu')->get_danmu($id,$max);
        }else{
            if($this->token($info)){
                $user=cmf_get_current_user();
                if($user){
                    $info['uid']=$user['id'];//??
                    $info['author']=$user['user_login'];
                    $re=D('Danmu')->send_danmu($info);
                }else{//可以删除 用于未登入用户发弹幕
                    $info['uid']=$user['id'];//??
                    $info['author']=$user['user_login'];
                    $re=D('Danmu')->send_danmu($info);
                }
            }
        }
        //header('Content-type:text/json');
        $re=isset($re)?$re:[];
        echo json_encode($re);
    }
        
    protected function token($info){//验证
        if(isset($info['player'])){
            $pl=strlen($info['player']);
            if($pl&&($pl<64)){
                return true;
            }
        }
       
    }
}
