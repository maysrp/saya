<?php

namespace app\user\model;

use think\Model;

class DanmuModel extends Model{
	public function send_danmu($info){
		$insert['player']=$info['vid'];#player
		$insert['author']=$info['author'];
		$insert['uid']=$info['uid'];
		$insert['time']=$info['time'];
		$insert['atime']=time();
		$insert['text']=$info['text'];
		$insert['color']=$info['color'];
		$insert['type']=$info['type'];
		$insert['ip']=$info['ip'];
		return $this->insert($insert);

	}
	public function get_danmu($vid,$limit=1000){
		$limit=(int)$limit>1000?(int)$limit:1000;
		$where['player']=(int)$vid;#player
		$where['del']=0;
		return $this->where($where)->limit($limit)->column('_id','__v','author','time','text','color','type','player');#array
	}
}
