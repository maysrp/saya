    <?php
        class dir{
            public function __construct(){
                isset($_SESSION) OR session_start();
                
            }
            public function scandir($d="."){
                $dir=scandir($d);
                var_dump($dir);

            }
            public function dir($dir='.'){
                if($fdir=opendir($dir)){
                    while(($file=readdir($fdir))!==false){
                        var_dump($file);
                    }
                }
            }
            #$_SESSION['dir'] 以 “. ”为第一个元素
            public function fileopen($key,$file){
                // $key为session中的位置 $file为选择的文件
                $now_length=count($_SESSION['dir'])-1;
                $key=(int)$key>$now_length?$now_length:$key;
                $da=array_slice($_SESSION['dir'],0,$key+1);
                if(isset($file)){
                    $f=$file;
                }else{
                    $f='.';
                }
                $das=implode("/",$da);
                $red=$das."/".$f;
                if(is_dir($red)){
                    $_SESSION['dir']=$da;//切换到当前目录
                    return $red;
                }else{
                    return false;
                }

            }
        }

        $dir=new dir();
        $dir->dir(".");





<?php
	class webdir{
		public $currentPath;
		public $currentPathArray;
		public function __construct(){
			isset($_SESSION) OR session_start();
			$this->currentPathArray=isset($_SESSION['dir'])?$_SESSION['dir']:['.'];
			$this->currentPath=$this->path($this->currentPathArray);
		}
		public function path($array){
			return implode('/',$array);
		}
		public function changePath($key){
			$currentCount=count($this->currentPathArray);
			$key=(int)$key>0?(int)$key:0;
			$nowKey=$key>$currentCount?$currentCount:$key;
			$this->currentPathArray=array_slice($this->currentPathArray,0,$nowKey+1);
			$this->setSessionDir()
			$this->currentPath=$this->path($this->currentPathArray);
		}
		public function path($key='',$file=''){//	用于合成path
			$this->changePath($key);
			$file=$file?$file:'.';
			$path=$this->currentPath.'/'.$file;
			return $path;
		}
		protected function extension($path){
			$info=pathinfo($path);
			return strtoupper($info['extension']);//大写
			// return pathinfo($path,PATHINFO_EXTENSION);
		}
		protected function setSessionDir(){
			$_SESSION['dir']=$this->currentPathArray;
		}
		protected function fileType($pathFile){
			if(is_dir($pathFile)){

			}else{
				$ext=$this->extension($pathFile);
				switch ($ext) {
					case 'mp4':
					case 'avi':
					case 'rm':
					case 'rmvb':
					case 'mkv':
						# code...
						break;
					
					default:
						# code...
						break;
				}
			}
		}
	}
