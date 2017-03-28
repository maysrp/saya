<?php



#rule



		function rid($rid){
			$rid=(int)$rid;
			$ba=$this->find($rid);
			if($ba){
				return $ba;
			}else{
				return false;
			}
		}
		function add_one($info){
			$add['type']=isset($info['type'])?1:0;
			$add['point']=(int)$info['point'];
			$add['con']=trim($info['trim']);
			return $this->add($add);
		}
		function del_one($rid){
			$rid=(int)$rid;
			if($rid<=10){
				return false;//不允许删除保留端
			}
			return $this->delete($rid);
		}
		function change_one($info){
			$save['rid']=(int)$info['rid'];
			$save['type']=isset($info['type'])?1:0;
			$save['point']=(int)$info['point'];
			$save['con']=trim($info['trim']);
			return $this->save($save);
		}
		//固定方法 1 弹幕删除扣分rid 1  2签到加分rid 2 3文章审核通过 rid 3 4文章修改-1 rid 4 5评论删除扣分rid 5 6评论添加加分 rid 6  
		//弹幕 + - 
		//签到 +
		//文章 审核+ 未通过/删除 - 
		//评论 + - 
		//日最多 积分MAX100？

#userpoint
		function uid_point($uid){//返回分数
			$where['uid']=$uid;
			$ba=$this->where($where)->select();
			if($ba){
				return $ba[0];
			}else{
				$add['uid']=$uid;
				$add['time']=time();
				$poi=$this->add($add);
				return $this->find($poi);
			}
		}

		function uid_point($uid){
			$where['uid']=$uid;
			$ba=$this->where($where)->select();
			if($ba){
				return $ba[0]['point'];
			}else{
				return false;
			}
		}
		function change_point($uid,$rid,$by="system"){//积分处理
			$rule=M('Pointrule')->find($rid);
			if($rule){
				$ba=$this->uid_point($uid);
				if($rule['type']){//1+
					$ve['uid']=$uid;
					$history=json_decode($ba['history'],true);
					$history[]=array("rid"=>$rid,"time"=>time(),"by"=>$by);
					$ba['history']=json_encode($history);
					$ba['point']=$ba['point']+$rule['point'];
					$ba['time']=time();
					$this->save($ba);
					//添加历史
					D('Home/Pointhistory')->add_history($ba['history']);
				}else{//0-
					$ve['uid']=$uid;
					$history=json_decode($ba['history'],true);
					$history[]=array("rid"=>$rid,"time"=>time(),"by"=>$by);
					$ba['history']=json_encode($history);
					$ba['point']=$ba['point']-$rule['point'];
					$ba['time']=time();
					D('Home/Pointhistory')->add_history($ba['history']);
					$this->save($ba);
				}
			}else{
				$re['status']=false;
				$re['con']="没有该规则!";
			}
		}
#pointhistory
 function add_history($info){
 	$add['time']=time();
 	$add['history']=$info;
 	$this->add($add);
 }

 #=====
#签到
		function qiandao($uid){//Model如果今天没有钱到则签到
			if($this->jugg_qian($uid)){
				$re['status']=false;
				$re['con']="已经签到";
			}else{
				$add['uid']=$uid;
				$add['time']=time();
				$add['day']=data("Ymd");
				$lian=$this->yesterday($uid);
				$add['lian']=$lian+1;
				$this->add($add);
				$re['status']=true;
				$re['con']="签到成功";
			}
			return $re;
		}
		function jugg_qian($uid){
			$where['uid']=$uid;
			$where['day']=date("Ymd");
			$ba=where($where)->select();
			if($ba){
				return true;//已经签
			}else{
				return false;
			}
		}
		function yesterday($uid){//查看昨日是否签到
			$where['day']=date("Ymd",strtotime("-1 day"));
			$where['uid']=$uid;
			$ba=where($where)->select();
			if($ba){
				return $ba[0]['lian'];//昨天已经签,返回签到数
			}else{
				return false;
			}
		}



 #controller
 function login_point(){

 }
