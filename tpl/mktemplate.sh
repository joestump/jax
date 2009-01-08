#!/bin/sh

if [ ! $1 ]
then
  echo "Usage: mktemplate.sh templateName"
  exit 99
fi

DIRS="cache config css images javascript templates templates_c"

echo "Creating template $1 ..."
mkdir $1
for i in $DIRS
do
  mkdir $1/$i
  touch $1/$i/index.html
  echo "     + $i "
done

cp default/javascript/*.js $1/javascript
cp default/css/*.css $1/css
cp default/templates/*.tpl $1/templates
cp default/images/*.* $1/images

chmod 777 $1/cache
chmod 777 $1/templates_c
echo "done."

