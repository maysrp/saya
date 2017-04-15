<?php
	/**
	* 
	*/
	class DanmuModel extends Model
	{
		
		function achieve($id,$max){
			$rem['player']=$id;
			$ba=$this->where($rem)->select();
			if(!$ba){
				$ba=array();
			}
			$re['code']=1;
			$re['danmaku']=$ba;
			return $re;
			
		}
		function input($info){
			$add['author']=$info['author'];
			$add['color']=$info['color'];
			$add['player']=$info['player'];
			$add['time']=$info['time'];
			$add['text']=$info['text'];
			$add['type']=$info['type'];
			$add['ip']=$info['ip'];
			$add['atime']=time();
			$m=$this->add($add);
			if($m){
				$re['code']=1;
				//$re['data']=$this->find($m);
			}else{
				$re['code']=0;
				$re['data']="";
			}
			return $re;
		}
	}