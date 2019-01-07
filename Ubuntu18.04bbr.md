```
$ echo "net.core.default_qdisc=fq" >> /etc/sysctl.conf
$ echo "net.ipv4.tcp_congestion_control=bbr" >> /etc/sysctl.conf
$ sysctl -p
```
或者  
`
$ echo "net.core.default_qdisc=fq" >> /etc/sysctl.conf&&echo "net.ipv4.tcp_congestion_control=bbr" >> /etc/sysctl.conf&&sysctl -p
`  

查看  
```
$ sysctl net.ipv4.tcp_available_congestion_control

net.ipv4.tcp_available_congestion_control = reno cubic bbr #成功开启 
```

