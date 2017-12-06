<?php    
//RSS源地址列表数组    
$url= "https://mikanani.me/RSS/MyBangumi?token=vOBkU42RZC7qRjUbOeDg7w%3d%3d";    
     
$data=rss($url);

var_dump($data);

// function rss($rssfeed){
// 	//设置编码为UTF-8    
// 	header('Content-Type:text/html;charset= UTF-8');         
	     
// 	for($i=0;$i<sizeof($rssfeed);$i++){//分解开始    
// 	    $buff = "";    
// 	    $rss_str="";    
// 	    //打开rss地址，并读取，读取失败则中止    
// 	    $fp = fopen($rssfeed[$i],"r") or die("can not open $rssfeed");     
// 	    while ( !feof($fp) ) {    
// 	        $buff .= fgets($fp,4096);    
// 		}    
// 	    //关闭文件打开    
// 	    fclose($fp);    
	            
// 	    //建立一个 XML 解析器    
// 	    $parser = xml_parser_create();    
// 	    //xml_parser_set_option -- 为指定 XML 解析进行选项设置    
// 	    xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);    
// 	    //xml_parse_into_struct -- 将 XML 数据解析到数组$values中    
// 	    xml_parse_into_struct($parser,$buff,$values,$idx);    
// 	    //xml_parser_free -- 释放指定的 XML 解析器    
// 	    xml_parser_free($parser);    
		        
// 		return $values;
// 	}    
// }


function rss($rssfeed){
	//设置编码为UTF-8    
	header('Content-Type:text/html;charset= UTF-8');         
	    $buff = "";    
	    $rss_str="";    
	    //打开rss地址，并读取，读取失败则中止    
	    $fp = fopen($rssfeed,"r") or die("can not open $rssfeed");     
	    while ( !feof($fp) ) {    
	        $buff .= fgets($fp,4096);    
		}    
	    //关闭文件打开    
	    fclose($fp);    
	    //建立一个 XML 解析器    
	    $parser = xml_parser_create();    
	    //xml_parser_set_option -- 为指定 XML 解析进行选项设置    
	    xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);    
	    //xml_parse_into_struct -- 将 XML 数据解析到数组$values中    
	    xml_parse_into_struct($parser,$buff,$values,$idx);    
	    //xml_parser_free -- 释放指定的 XML 解析器    
	    xml_parser_free($parser);    
		return $values;
	   
}

?>   
