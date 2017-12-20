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
