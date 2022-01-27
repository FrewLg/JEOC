echo "*********** File compression ******************** " >> "$logfile"
#Start scripting 
SRCDIR=/var/log/apache2/
#The file or folder to be compressed
DESTDIR="logs"
#The destination folderto put file
FILENAME=$(date  +%d-%m-%Y )Apache2-Logs.tgz
#The compressed file name after zipped
tar --create --gzip --file=$DESTDIR$FILENAME  $SRCDIR
chown -R 777   $DESTDIR$FILENAME 
