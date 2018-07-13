    import os
    import pymysql

    def disk_stat():  
        import os  
        hd={}  
        disk = os.statvfs("/")  
        hd['available'] = disk.f_bsize * disk.f_bavail  
        hd['capacity'] = disk.f_bsize * disk.f_blocks  
        hd['used'] = disk.f_bsize * disk.f_bfree  
        return hd  
    def load_stat():  
        loadavg = {}  
        f = open("/proc/loadavg")  
        con = f.read().split()  
        f.close()  
        loadavg['lavg_1']=float(con[0])  
        loadavg['lavg_5']=float(con[1])  
        loadavg['lavg_15']=float(con[2])  
        loadavg['nr']=con[3]  
        loadavg['last_pid']=con[4]  
        return loadavg  
    def fsize(size):
        if size>1024*1024*1024:
            rs=size/(1024*1024*1024)
            return str(round(rs,2))+"GB"
        elif size>1024*1024:
            rs=size/(1024*1024)
            return str(round(rs,2))+"MB"
        elif size>1024:
            rs=size/1024
            return str(round(rs,2))+"KB"
        else:
            return str(size)+"B"

    ppp=fsize(1212312)
    disk=disk_stat()
    load=load_stat()
    if disk['available']>102410241024:
        if load['lavg_1']<2.0 and load['lavg_5']<2.0 and load['lavg_15']<2.0:
            pid=os.getpid()
            db=pymysql.connect("localhost",'','','db')
            cursor=db.cursor()
            cursor.execute("SELECT * FROM cmf_cron_ffmpeg WHERE starttime=0 AND del=0")
            data=cursor.fetchone()
            
            
            # log=data[0][3]
            # odir=data[0][8] //  加前缀
            # ndir=data[0][10] //
            # fmpeg -i 1.mp4 222.mp4 2>&1|tee lool.log
            # ffmpeg -i MVI_7274.MOV -vcodec libx264 -preset fast -crf 20 -y -vf "scale=1920:-1" -acodec libmp3lame -ab 128k a.mp4
            str="ffmpeg -i %s -vcodec libx264 -preset fast -crf 20 -y -vf \"scale=1920:-1\" -acodec libmp3lame -ab 128k %s 2>&1|tee %s" % (data[8],data[10],data[3])

            data[2]
            pass
        esle:
            pass
    else:
        pass
