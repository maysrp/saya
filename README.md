saya
====

AI-Saya

## 配置

###环境
PHP >5.3
Mysql
Aria2 下载 
Livav 视频截图 [若使用FFMPEG请将OndoAction.class.php 中的 avconv 换成 ffmpeg]
Apache [Nginx请配置 pathinfo ]



###定时设置
Ondo下面公共方法

*spider 采集
*curl 获取下载状况
*curl_video 更新发布视频
*curl_image 获取截图

crontab -e

`
*/10 * * * * curl http://your_domain/index.php/Ondo/spider
*/10 * * * * curl http://your_domain/index.php/Ondo/curl
*/10 * * * * curl http://your_domain/index.php/Ondo/curl_video
*/10 * * * * curl http://your_domain/index.php/Ondo/curl_image
`

### 权限
需要777权限的文件夹
1./image
2./video #若选择NEW，则不需要该文件夹 OndoAction.class.php 里面 111行 和112行 选择其中一种，不要的那个注释掉
3./download
4./Index/Runtime

### 数据库
/Index/Conf/config.php

danmu.sql 导入你的数据库中

###后台

严重问题 明文密码

http://your_domain/index.php/Admin/login
