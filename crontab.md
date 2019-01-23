# ubuntu开启Crontab日志

`vim /etc/rsyslog.d/50-default.conf`把其中的`#cron.*  /var/log/cron.log`的#注释符去掉（cron前面的`#`去掉） 

` service rsyslog  restart`
