#!/bin/bash
#set -x
CASA="$HOME"
# OS VIDEOS DO NVR SAO ENVIADOS VIA SFTP PARA seu_ip:ftp
ORIGEM="$CASA/ftp/192.168.1.100"
HOST="teotonios.com.br"
DESTINO="$HOST/cftv"
OPTS="-c:v libx264 -crf 24 -filter:v"
OPTS="-c:v libx264"  # FORMATO MP4
cd $ORIGEM
pwd
DATAS=`ls`
# NVR_ch1_main_20240120044703_20240120044829.dav
# .....+....1....+....2....+....3....+....4....+.
for data in $DATAS;do
   LOG="$CASA/$data.log"
   tempo=$(date)
   echo "$tempo CONVERTENDO ARQUIVOS DE $data" >>$LOG
   cd $data
   rm -f *.jpg 2>/dev/null
   VIDEOS=$(ls *.dav 2>/dev/null)
   if [ ${#VIDEOS} -eq 0 ];then
      echo "$tempo SEM ARQUIVOS DE VIDEO - ABORTAR" >>$LOG
      cd ..
      rmdir $data
      continue
   fi
   for video in $VIDEOS;do
      tempo=$(date)
      echo $tempo CONVERTENDO VIDEO $video >>$LOG
      canal=${video:6:1}
      ano=${video:13:4}
      mes=${video:17:2}
      dia=${video:19:2}
      hora=${video:21:2}
      minuto=${video:23:2}
      nome="$ano-$mes-$dia-$hora-$minuto-$canal.mp4"
      ffmpeg -i $video -threads 12 -y $OPTS /tmp/video.mp4 2>/dev/null >>$LOG
      scp  /tmp/video.mp4 $HOST:$DESTINO/videos/$nome >>$LOG
      rm /tmp/wget.log 2>/dev/null
      wget https://$DESTINO/info.php?n="$nome" -O /tmp/wget.log >>$LOG
      rm -v $video >>$LOG
      tempo=$(date)
      echo $tempo $video CONVERTIDO E NA NUVEM >>$LOG
   done
   cd ..
   rmdir $data
done
