<?php
//ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)');
//$html=file_get_contents("https://www.nyaa.se/?offset=2");
//@file_put_contents("nyaaswap.html", $html);

include 'phpQuery/phpQuery.php';
phpQuery::newDocumentFile("https://www.nyaa.se/?offset=2"); 

//echo pq("body")->html(); 
$exx=pq(".tlistrow"); 
//var_dump($exx);
//echo pq("tr")->html(); 
$no=1;
foreach ($exx as $value) {
$no=$no+1;
//echo pq($value)->html();

//tlistsize size
//tlistname name a[文件下一层]
//tlisticon a tittle="Anime >> Non-English-translated"
//tlist sn ln dn[已经完成]
$rl=pq($value)->find(".tlistdownload a")->attr("href");
$url="https:".$rl;
ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)');
$html=file_get_contents($url);
@file_put_contents($no.".torrent", $html);

echo "<hr>";


}