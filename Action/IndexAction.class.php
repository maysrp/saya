<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
    //$count=D('info')->count();
	//echo "<br><br><br><center><h1>已经采集了".$count."条信息！</h1></center>";
    	if(strlen($_POST['fname'])>=1){
    		$fname=trim($_POST['fname']);
    		$where['fname']=array("like","%".$fname."%");
    		$re=M('info')->where($where)->select();
    		$this->assign("info",$re);
    		$this->display("table");
    	}else{
    		$this->display();
    	}
    }
    function sp(){ 
       		$this->sxp(1);
		$this->sxp(2);
		$this->sxp(3);



    }
    protected function sxp($count){
    	include_once 'phpQuery/phpQuery.php';
		phpQuery::newDocumentFile("https://share.dmhy.org/topics/list/page/".$count); 
		$exx=pq("tr"); 
		foreach ($exx as $value) {
			$info['magnet']=pq($value)->find(".download-arrow")->attr("href");//magnet
			if(!$info['magnet']){
				continue;
			}
			$info['zname']=trim(pq($value)->find(".title a:eq(0)")->text());//字幕组
			$info['fname']=trim(pq($value)->find(".title a:eq(1)")->text());//文件名 a attr("href")地址
			if(!$info['fname']){
				$info['fname']=$info['zname'];
				$info['zname']="";
				$info['url']=pq($value)->find(".title a:eq(0)")->attr("href");//文件名 a attr("href")地址
			}else{
				$info['url']=pq($value)->find(".title a:eq(1)")->attr("href");//文件名 a attr("href")地址
			}
			$info['ctime']=pq($value)->find("td:first span ")->text();//time
			$info['ntype']=trim(pq($value)->find("td:eq(1)")->text());//类型
			$info['size']=pq($value)->find("td:eq(4)")->text();//大小
			$info['download']=pq($value)->find("td:eq(6)")->text();//下载
			$info['cdownload']=pq($value)->find("td:eq(7)")->text();//完成
			D('Info')->add_info($info);
		}
    }
    protected function spide_count(){
    	$num=M('count')->count();
    	$info['time']=time();
    	M('count')->add($info);
    	return $num+1;
    }
}