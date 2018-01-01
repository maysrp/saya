<?php
	class webdir{
		//默认 path最后为/·11			
		public $currentPath;
		public $currentPathArray;
		public $current;//当前目录文件信息
		public $currentD;
		public $currentF;
		public $db;
		public function __construct(){
			if(!isset($_SESSION)){
				session_start();
			}
		

			$this->getSessionDir();
			$this->currentPath=$this->path($this->currentPathArray);
			
			
			$this->keyPath(count($this->currentPathArray)+1);
		}
		public function path($array){
			return implode('/',$array);
		}
		public function changePath($key){
			$currentCount=count($this->currentPathArray);
			$key=(int)$key>0?(int)$key:0;
			$nowKey=$key>$currentCount?$currentCount:$key;
			$this->currentPathArray=array_slice($this->currentPathArray,0,$nowKey+1);
			$this->setSessionDir();
			$this->currentPath=$this->path($this->currentPathArray);
			$this->setSessionDir();
		}
		
		public function keyPath($key){
			$this->changePath($key);
			if($pinfo=$this->openPath($this->currentPath)){
				return True;
				//$this->json($this->current);//输出不用该SSSS
			}else{
				return False;
			}
		}
		public function setPath($path){// 设置path 点击下一目录文件
			$nowPath=$this->currentPath.'/'.$path;
			if(is_dir($path)){
				$this->currentPath=$nowPath;
				$this->currentPathArray[]=$path;
				//$_SESSION['dir']=$this->currentPathArray;//用于合成path/////////////////////////
				$this->setSessionDir();

				$this->openPath($this->currentPath);
				// $this->json($this->current);
				return True;
			}else{
				return False;
			}
		}
		public function openPath($path){
			if(is_dir($path)){
				if($dh=opendir($path)){
					$current;
					while(($file=readdir($dh))!==false){

						$file=$path."/".$file;

						$current[]=$this->info($file);
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
		public function createKey($file,$type,$time,$password){



			return $key;
		}
		public function authKey($key){

		}
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
	


	
	$wd=new webdir();



?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="renderer" content="webkit">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
	<script src="https://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>
<body>
	<table class="table">
		<?php
			$wd->htmlTable();
		?>
	</table>
</body>
</html>
	
