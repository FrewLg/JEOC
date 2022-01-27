chmod -R 777 var/
#chmod -R 777 public/
rm -r var/cache/*
git add .
git commit -m "Changes has been made $(date +'%d-%m-%Y %H:%M:%S')"
git pull
#./bin/console doctrine:schema:update --force 
rm -r var/cache/*
rm -r var/*
mkdir var
chmod -R 777 var/
#git push origin firra
#chmod -R 777 public/
#mkdir yegitlab_dir
#chmod -R 777 yegitlab_dir
