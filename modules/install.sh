#!/bin/sh

MYSQLUSER=root
MYSQLPASS=password

if [ ! $1 ]
then
  echo "Please supply a database to use for install!"
  exit 99
fi

for i in `ls -F | grep \/ | grep -v CVS`
do
  MODULE=`echo $i |  sed -e "s/\///"`
  if [ -f $MODULE/$MODULE-schema.xml ]
  then
    php -q turbine.php -d$1 -u$MYSQLUSER -p$MYSQLPASS $MODULE
  fi
done

for i in `ls -F | grep \/ | grep -v CVS`
do
  MODULE=`echo $i |  sed -e "s/\///"`
  if [ -f $MODULE/$MODULE.sql ] 
  then
    mysql -f -u$MYSQLUSER -p$MYSQLPASS $1 < $MODULE/$MODULE.sql
  fi
done

for i in `ls -F | grep \/ | grep -v CVS`
do
  MODULE=`echo $i |  sed -e "s/\///"`
  php -q installer.php -d$1 -u$MYSQLUSER -p$MYSQLPASS $MODULE
done

for i in `ls -F | grep \/ | grep -v CVS`
do
  MODULE=`echo $i |  sed -e "s/\///"`
  if [ -f $MODULE/$MODULE-schema.xml ]
  then
    php -q xmldata.php -d$1 -u$MYSQLUSER -p$MYSQLPASS $MODULE
  fi
done

