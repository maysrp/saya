<?php 
	class InfoModel extends Model{
		function add_info($info){
			$jugg=$this->jugg_info($info);
			if($jugg){
			}else{
				$this->add($info);
			}
		}
		function jugg_info($info){
			$where['magnet']=$info['magnet'];
			$re=$this->where($where)->select();
			if($re){
				return true;
			}else{
				return false;
			}
		}
	}