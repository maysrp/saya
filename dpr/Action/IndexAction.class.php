<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
	header("access-control-allow-origin:*");
    	$id=I('get.id');
    	$max=I('get.max')?I('get.max'):1000;
    	$request_body = file_get_contents('php://input');
    	$info=json_decode($request_body,true);
    	$info['ip']=I('server.REMOTE_ADDR');
    	if($id){
    		$re=D('Danmu')->achieve($id,$max);
    	}else{
    		if($this->token($info)){
				$re=D('Danmu')->input($info);
			}
    	}
		echo json_encode($re);
    }
    protected function token($info){
    	$pl=strlen($info['player']);
    	if($pl&&($pl<64)){
    		return true;
    	}
    }
}