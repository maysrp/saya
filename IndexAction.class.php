<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function cindex(){
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
        $this->nyaa(1);
        $this->nyaa(2);
    }
    function index(){
        $rt=mt_rand(1,3);
            
        if($rt==1){
            $this->list_178();
                        //$this->sxp_index(1);
                        //$this->nyanya();
        }elseif ($rt==2) {
            # code...
            $this->sxp_index(1);
        }else{
            $this->nyanya();
        }
        /*
        echo $this->sxp_cont("https://share.dmhy.org/topics/view/455840_Xrip_01_%21_Kono_Subarashii_Sekai_ni_Shukufuku_o%21_2_09_2160P_HEVC.html");
        $pa=M('Forum_post')->count();
        $pid=$pa+900000000+1;
        echo $pid;
        */
    }
    protected function nyanya(){
        $json=file_get_contents("http://www.nyanya.tv/index.php/Index/info_json");
        $info_array=json_decode($json,true);
        foreach ($info_array as $key => $value) {
          //var_dump($value);
            $this->online_video($value);
        }
    }
    protected function online_video($value){
        //var_dump($value);
        $time=time();
        $info['subject']="在线:".$value['name'];
        $tj=M('Forum_thread')->where($info)->select();
        if($tj){
            return;
        }
        $info['fid']=57;
        $info['author']="admin";
        $info['authorid']=1;
        $info['dateline']=$time;
        $info['lastpost']=$time;
        $info['lastposter']="admin";
        $tid=M('Forum_thread')->add($info);

       $post['message']="<iframe frameborder=\"no\" border=\"0\" marginwidth=\"0\" marginheight=\"0\" scrolling=\"no\" allowtransparency=\"yes\" width=\"1000px\" height=\"800px\" src=\"http://nyanya.tv/index.php/Index/share/vid/".$value['vid']."\" ></iframe>";

        $pa=M('Forum_post')->limit(1)->order('pid desc')->select();
        $pid=$pa[0]['pid']+1;
        $post['tid']=$tid;
        $post['pid']=$pid;
        $post['first']=1;
        $post['author']="admin";
        $post['authorid']=1;
        $post['dateline']=$time;
        $post['htmlon']=1;
        $post['subject']=$info['subject'];
        $post['usesig']=1;
        M('Forum_post')->add($post);
    }
    protected function sxp_cont($url){
        include_once 'phpQuery/phpQuery.php';
        phpQuery::newDocumentFile($url); 
        $info=pq(".topic-nfo")->html(); 
        $file_list=pq(".file_list")->html();
        $magnet=pq("#magnet2")->html();
        return $info."<hr><blockquote style=\"background-color:#FAFAFA;border-radius:10px;padding:5px;\"><h3>下载地址:<a href=\"".$magnet."\">".$magnet."</a></h3><h3>文件列表</h3>".$file_list."</blockquote>";

    }
    protected function sxp_index($count){
        include_once 'phpQuery/phpQuery.php';
        phpQuery::newDocumentFile("https://share.dmhy.org/topics/list/page/".$count); 
        $exx=pq("tr"); 
        foreach ($exx as $value) {
            $info['magnet']=pq($value)->find(".download-arrow")->attr("href");//magnet
            if(!$info['magnet']){
                continue;
            }
            $info['zname']=trim(pq($value)->find(".title a:eq(0)")->text());//字幕组*******
            $info['fname']=trim(pq($value)->find(".title a:eq(1)")->text());//文件名 a attr("href")地址***********
            if(!$info['fname']){
                $info['fname']=$info['zname'];
                $info['zname']="";
                $info['url']=pq($value)->find(".title a:eq(0)")->attr("href");//文件名 a attr("href")地址
            }else{
                $info['url']=pq($value)->find(".title a:eq(1)")->attr("href");//文件名 a attr("href")地址
            }
            $info['ctime']=pq($value)->find("td:first span ")->text();//time ************
            $info['ntype']=trim(pq($value)->find("td:eq(1)")->text());//类型 ****************
            $info['size']=pq($value)->find("td:eq(4)")->text();//大小
            $info['download']=pq($value)->find("td:eq(6)")->text();//下载
            $info['cdownload']=pq($value)->find("td:eq(7)")->text();//完成
            $url="https://share.dmhy.org".$info['url'];
            $info['post']=$this->sxp_cont($url);//帖子内容 ****************
            $this->insert_info($info);
        }
    }
    protected function insert_info($add){
        $jugg['subject']=$add['fname'];
        $tj=M('Forum_thread')->where($jugg)->select();
        if($tj){
            return;
        }
        $time=time();
        switch ($add['ntype']) {
            case '動畫':
                $info['fid']=2;
                break;
            case '季度全集':
                $info['fid']=56;
                break;
            case '流行音樂':
            case '動漫音樂':
            case '音樂':
            case '同人音樂':
                $info['fid']=38;
                break;
            case '漫畫':
            case '港台原版':
            case '日文原版':
                $info['fid']=36;
                break;
            case '日劇':
                $info['fid']=48;
                break;
            case '遊戲':
            case '電腦遊戲':
            case '遊戲周邊':
                $info['fid']=37;
                break;
            default:
                $info['fid']=54;
                break;
        }
        $info['author']="admin";
        $info['authorid']=1;
        $info['dateline']=$time;
        $info['lastpost']=$time;
        $info['lastposter']="admin";
        $info['subject']=$add['fname'];
        $tid=M('Forum_thread')->add($info);

        $pa=M('Forum_post')->limit(1)->order('pid desc')->select();
        $pid=$pa[0]['pid']+1;
        $post['tid']=$tid;
        $post['pid']=$pid;
        $post['first']=1;
        $post['author']="admin";
        $post['authorid']=1;
        $post['dateline']=$time;
        $post['htmlon']=1;
        $post['subject']=$add['fname'];
        $post['message']=$add['post'];
        $post['usesig']=1;
        M('Forum_post')->add($post);

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
    function nyaa($page){
        $this->nyaa_info($page);
        $this->sukebei_info($page);
    }
    protected function nyaa_info($page){
        include_once 'phpQuery/phpQuery.php';
        phpQuery::newDocumentFile("https://www.nyaa.se/?offset=".$page); 
        $exx=pq(".tlistrow");
        foreach ($exx as $value) {
            $info=array("");
            $rl=pq($value)->find(".tlistdownload a")->attr("href");
            $ur=pq($value)->find(".tlistname a")->attr("href");
            $info['url']="https:".$ur;
            $info['torrent_url']="https:".$rl;//torrent download
            $info['size']=pq($value)->find(".tlistsize")->text();
            $info['name']=pq($value)->find(".tlistname")->text();//$name
            $ico=pq($value)->find(".tlisticon a")->attr("title");
            $ico_a=explode(" >> ", $ico);
            $info['type_1']=array_pop($ico_a);
            $info['type_2']=array_pop($ico_a);
            $re=D('Nyaa')->jugg_info($info);
            if($re){
            }else{
                $info['sn']=pq($value)->find(".tlistsn")->text();
                $info['ln']=pq($value)->find(".tlistln")->text();
                $info['dn']=pq($value)->find(".tlistdn")->text();
                $info['torrent']=$this->download($info['torrent_url'],"nyaa");
                D('Nyaa')->add_info($info);
            }
        } 
    }
    protected function sukebei_info($page){
        include_once 'phpQuery/phpQuery.php';
        phpQuery::newDocumentFile("https://sukebei.nyaa.se/?offset=".$page); 
        $exx=pq(".tlistrow");
        foreach ($exx as $value) {
            $info=array("");
            $rl=pq($value)->find(".tlistdownload a")->attr("href");
            $ur=pq($value)->find(".tlistname a")->attr("href");
            $info['url']="https:".$ur;
            $info['torrent_url']="https:".$rl;//torrent download
            $info['size']=pq($value)->find(".tlistsize")->text();
            $info['name']=pq($value)->find(".tlistname")->text();//$name
            $ico=pq($value)->find(".tlisticon a")->attr("title");
            $ico_a=explode(" >> ", $ico);
            $info['type_1']=array_pop($ico_a);
            $info['type_2']=array_pop($ico_a);
            $re=D('Sukebei')->jugg_info($info);
            if($re){
            }else{
                $info['sn']=pq($value)->find(".tlistsn")->text();
                $info['ln']=pq($value)->find(".tlistln")->text();
                $info['dn']=pq($value)->find(".tlistdn")->text();
                $info['torrent']=$this->download($info['torrent_url'],"sukebei");
                D('Sukebei')->add_info($info);
            }
        } 
    }
    protected function download($url,$type){
        ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)');
        $html=file_get_contents($url);
        $no=md5($url);
        @file_put_contents("./torrent/".$type."/".$no.".torrent", $html);
        return "./torrent/".$type."/".$no.".torrent";
    }

protected function list_178(){
        $url="http://acg.178.com/";
        include_once 'phpQuery/phpQuery.php';
        phpQuery::newDocumentFile($url); 
        $textbox=pq(".textbox")->find("a");
        foreach ($textbox as $value) {
            $url=pq($value)->attr("href");
            $title=pq($value)->text();
            $jugg['subject']=$title;
            $tj=M('Forum_thread')->where($jugg)->select();
            if($tj){
                continue;
            }
            $url="http://acg.178.com".$url;
            $this->new_178($url);
        }
    }

    protected function new_178($url){//178文章采集
        include_once 'phpQuery/phpQuery.php';
        phpQuery::newDocumentFile($url); 
        $title=pq("h1")->text();
        $cont=pq(".artical-content")->html();
        $img=pq($cont)->find("img");
        foreach ($img as $value) {
            $url=pq($value)->attr("src");
            $img_file=$this->image_download($url);
            $cont=str_replace($url,$img_file, $cont);
        }
        $post['title']=$title;
        $post['cont']=$cont;
        $this->sql_178($post);
    }
    protected function image_download($img){
        ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)');
        $img_ar=explode(".", $img);
        $ex=array_pop($img_ar);
        $html=file_get_contents($img);
        $no=md5($img);
        @file_put_contents("./download/image/".$no.".".$ex, $html);
        return "./download/image/".$no.".".$ex;//返回文件下载地址
    }
    protected function sql_178($my){
        $info['subject']=$my['title'];
        $time=time();
        $info['fid']=58;
        $info['author']="admin";
        $info['authorid']=1;
        $info['dateline']=$time;
        $info['lastpost']=$time;
        $info['lastposter']="admin";
        $tid=M('Forum_thread')->add($info);

        $pa=M('Forum_post')->limit(1)->order('pid desc')->select();
        $pid=$pa[0]['pid']+1;
        $post['tid']=$tid;
        $post['pid']=$pid;
        $post['first']=1;
        $post['author']="admin";
        $post['authorid']=1;
        $post['dateline']=$time;
        $post['htmlon']=1;
        $post['subject']=$my['title'];
        $post['message']=$my['cont'];
        M('Forum_post')->add($post);
    }

    protected function acfun_dm(){
         $url="http://http://www.acfun.cn/v/list74/index.htm/";
        include_once 'phpQuery/phpQuery.php';
        phpQuery::newDocumentFile($url); 
        $ar=pq(".hint-comm-article");
        foreach ($ar as $key => $value) {
           
        }
        //http://www.acfun.cn/comment_list_json.aspx?contentId=3551123&currentPage=1 评论接口 50个一次
    }


}