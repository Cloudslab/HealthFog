#!/bin/bash
apt-get update
apt-get upgrade -y
apt-get install oracle-java8-jdk dos2unix -y
apt-get install ant git vim -y
apt-get install apache2 -y
echo "ServerName 127.0.0.1" >> /etc/apache2/apache2.conf
apache2ctl configtest
apt-get install php libapache2-mod-php php-mcrypt php-mysql -y
service apache2 restart
apt-get install mysql-server -y
service apache2 restart
cd /var/www/html/
git clone https://github.com/Cloudslab/HealthFog.git
cd HealthFog
sudo chmod -R 777 *
cd /var/www/html/HealthKeeper/
sudo chmod -R -f 777 ./*
echo ".................................."
echo "Successfully Installed HealthFog"
echo "Note the worker IP address :"
hostname -I
echo "Press Enter to run"
read
cd HeartModel
python3 MasterInterface.py
