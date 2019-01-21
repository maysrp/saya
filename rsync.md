## 服务端安装
首先需要安装rsync，Ubuntu下安装`apt-get install rsync`安装完成后开始配置文件。  
### 配置文件
`vim /etc/rsyncd.conf`  
```
uid = root
gid = root
use chroot = no
read only = yes
max connections = 10

port = 873
pid file = /var/run/rsyncd.pid
lock file = /var/run/rsync.lock
log file = /var/log/rsync.log 
log format = %t %a %m %f %b
syslog facility = local3
timeout = 300

[www]
path = /home/wwwroot/
comment = el.psy.congroo
ignore errors
read only = yes
list = no
auth users = els
secrets file = /etc/rsync.pwd
# exclude = book
# exclude from = /etc/exclude_rsync.info
hosts allow = 备份服务器IP
hosts deny = *
```

+ [www]:需要在客户端中相互对应
+ path:需要备份的目录
+ comment:设置名称[无关紧要]
+ secrets file:密码文件[格式 用户吗:密码]
+ auth users:用户名
+ exclude:排除目录[相对目录][可以注释掉]
+ exclude from:排除目录 文件导入[可以注释掉]
+ hosts allow:备份服务器IP,需要填写
+ log file:rsync日志查看  

### 密码文件
`echo '用户名:密码'> /etc/rsync.pwd`  
用户名就是前面配置文件的用户名，密码随意设置。  
`chmod 600 /etc/rsync.pwd`  
密码文件必需600的权限才能使用  

### 启动rsync
`rsync --daemon`  
该命令将自动读取/etc/rsyncd.conf下的配置来启动rsync。  
## 客户端
### 安装
安装`apt-get install rsync`  
密码文件设置`echo '密码'> /etc/rsync.pwd` 此处只需要密码即可。
```
echo "rsync -avzP --delete --password-file=/etc/rsync.pwd 用户名@服务端ip::www /back/www">/root/back.sh
```
+ --password-file=:密码文件地址
+ 用户名@需要备份服务器的ip
+ www为服务端中[www]的配置
+ /back/www:备份到客户端的地址，必需已经存在不存在请先`mkdir -p /back/www`创建。

执行`sh /root/back.sh`即可运行备份。  
`crontab -e`中添加一个定时任务:
`* * */1 * * sh /root/back.sh `每日执行一次备份

