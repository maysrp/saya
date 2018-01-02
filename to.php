<?php
		//默认 path最后为/·11			
	class webdir{
			public $currentPath;
			public $currentPathArray;
			public $current;//当前目录文件信息
			public $currentD;
			public $currentF;
			public $json_file;
			public $password;
			public $filterArray;
			public function __construct(){
				if(!isset($_SESSION)){
					session_start();
				}
				$this->filterArray=['.','..'];
				$this->password='admin';
				$this->json_file='./json/info.json';
				$this->getSessionDir();
				$this->currentPath=$this->path($this->currentPathArray);
			}
			//-----------------------//
			public function login(){
				if($_GET['password']==$this->password){
					$_SESSION['user']='I love rem';
				}else{
					//none
				}
				
			}
			public function jugg(){//登入判斷
				if(isset($_SESSION['user'])){
					return true;
				}else{
					return false;
				}
			}

			//----------------------//
			public function path($array){
				return implode('/',$array);
			}
			public function changePath($key){
				$currentCount=count($this->currentPathArray);
				$key=(int)$key>0?(int)$key:0;
				$nowKey=$key>$currentCount?$currentCount:$key;
				$this->currentPathArray=array_slice($this->currentPathArray,0,$nowKey);
				$this->currentPath=$this->path($this->currentPathArray);
				$this->setSessionDir();
			}
			
			public function keyPath($key){
				$this->changePath($key);
				if($pinfo=$this->openPath($this->currentPath)){
					return True;
				}else{
					return False;
				}
			}
			public function setPath($path){// 设置path 点击下一目录文件
				$path=trim($path);//防止跳到前一目錄
				$path=str_replace('/','', $path);
				if($path=='..'){
					$path='.';
				}
				//
				$nowPath=$this->currentPath.'/'.$path;
				if(is_dir($nowPath)){
					$this->currentPath=$nowPath;
					$this->currentPathArray[]=$path;
					$this->setSessionDir();
					$this->openPath($this->currentPath);
					return True;
				}else{
					$this->openPath($this->currentPath);
					return False;//无该文件目录
				}
			}
			public function openPath($path){
				if(is_dir($path)){
					if($dh=opendir($path)){
						$current;
						while(($file=readdir($dh))!==false){
							if(!$this->filter($file)){
								$file=$path."/".$file;
								$current[]=$this->info($file);	
							}
						}
						$this->current=$current;
						closedir($dh);
					}
					return True;
				}else{
					return False;
				}
			}
			public function info($file){
				$re['name']=$this->basename($file);
				$re['basename']=$this->currentPath.'/'.$this->basename($file);
				$re['atime']=$this->atime($file);
				$re['ctime']=$this->ctime($file);
				$re['mtime']=$this->mtime($file);
				if(is_dir($file)){
					$re['extension']='';
					$re['dir']=True;
					$re['size']='';
					$this->currentD[]=$re;
				}else{
					$re['extension']=$this->extension($file);
					$re['dir']=False;
					$re['size']=$this->fileSize($file);
					$this->currentF[]=$re;
				}
				
				return $re;
			}
			//================================//
			public function createKey($file,$type,$password){
				switch ($type) {
					case 'p':
						$array['type']='p';
						$array['password']=$password;
						$array['key']=md5($file.$type.$password.time().mt_rand(1000,9999));
						$re=$this->json_save($array);
						break;
					case 'n':
						$array['type']='n';
						$array['password']="";
						$array['key']=md5($file.$type.$password.time().mt_rand(1000,9999));
						$re=$this->json_save($array);
						break;
					default:
						$array['type']='n';
						$array['password']="";
						$array['key']=md5($file.$type.$password.time().mt_rand(1000,9999));
						$re=$this->json_save($array);
						break;
				}
				if($re){
					return $array['key'];
				}else{
					return false;
				}
			}
			public function json_save($array){
				if(is_array($array)){
					$json_array=$this->json_open();
					$josn_array[$array['key']]=$array;
					$json=json_encode($json_array);
				}
				file_put_contents($this->josn_file, $json);
			}
			public function json_open(){
					$file=file_get_contents($this->josn_file);
					$json_array=json_decode($file,True);
					return $json_array;
			}
			public function getKey($key){
				$json_array=$this->json_open();
				if(isset($josn_array[$key])){
					return $json_array[$key];
				}else{
					return false;
				}
			}
			public function authKey($key,$password){
			


			}


			//================================//
			public function json($array){
				header('Content-type:text/json');
				echo json_encode($array);
			}
			public function upload(){//文件上传
			}
			public function mkdir(){//用于创建目录
			}
			public function auth(){//验证
			}
			public function download($info){//用于下载生成
			}
			public function htmlTable(){//用于生成列表
			
				foreach ($this->currentD as $key => $value) {//directory
					echo "<tr>";
						echo "<td>".$value['basename']."</td>";
						echo "<td>".$value['ctime']."</td>";
						echo "<td>"."</td>";
					echo "</tr>";
				}
				foreach ($this->currentF as $key => $value) {//file
					echo "<tr>";
						echo "<td>".$value['basename']."</td>";
						echo "<td>".$value['ctime']."</td>";
						echo "<td>".$value['size']."</td>";
					echo "</tr>";
				}
			}
			protected function setSession($xkey,$dir){//设置key
			}
			protected function getSession($xkey,$dir){
				
			}
			protected function filter($file){//匹配過濾
					return in_array($file,$this->filterArray);
			}
			protected function extension($path){
				$info=pathinfo($path);
				return strtoupper($info['extension']);//大写
				// return pathinfo($path,PATHINFO_EXTENSION);
			}
			protected function basename($path){
				$info=pathinfo($path);
				return strtoupper($info['basename']);//大写
				// return pathinfo($path,PATHINFO_BASENAME);
			}
			protected function fileSize($path){
				$fz=filesize($path);
				return $this->formatSize($fz);
			}
			protected function setSessionDir(){
				$_SESSION['directory']=$this->currentPathArray;////////////////////
			}
			protected function getSessionDir(){
				$_SESSION['directory']=isset($_SESSION['directory'])&&is_array($_SESSION['directory'])?$_SESSION['directory']:['.'];//////
				$this->currentPathArray=$_SESSION['directory'];
			}
			protected function mtime($file){
				return date("Y-m-d H:i:s",filemtime($file));
			}
			protected function atime($file){
				return date("Y-m-d H:i:s",fileatime($file));
			}
			protected function ctime($file){
				return date("Y-m-d H:i:s",filectime($file));
				
			}
			protected function formatSize($size){
				if ($size>1073741824) {
					$re=$size/1073741824;
					$re=round($re,2);
					$re=$re."GB";
				}elseif ($size>1048576) {
					$re=$size/1048576;
					$re=round($re,2);
					$re=$re."MB";
				}elseif($size>1024) {
					$re=$size/1024;
					$re=round($re,2);
					$re=$re."KB";
				}else{
					$re=$size.'B';
				}
				return $re;
			}
			
		}
		
		date_default_timezone_set("PRC");
		$wd=new webdir();
		$setKeyPath=isset($_GET['keypath'])?$_GET['keypath']:'';
		$setPath=isset($_GET['path'])?$_GET['path']:'';
		if($setKeyPath||$setPath){
			if($setKeyPath){
				$wd->keyPath($setKeyPath);
			}else{
				$wd->setPath($setPath);
			}
		}else{
			$wd->keyPath(count($wd->currentPathArray));
		}
		$rf['dir']=$wd->currentPath;
		$rf['dirArray']=$wd->currentPathArray;
		$rf['file']=$wd->currentF;
		$rf['directory']=$wd->currentD;
		$wd->json($rf);


?>