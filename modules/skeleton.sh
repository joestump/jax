#!/bin/sh

if [ ! $1 == "" ]
then

  if [ ! $2 ]
  then
    echo "Supply an auth type!"
    exit
  fi

  echo -n "Creating skeleton version of $1 ($2) ... "

  mkdir $1
  touch $1/config.php
  touch $1/$1.php
  touch $1/admin.php
  touch $1/init.php
  touch $1/install.php
  mkdir $1/admin
  mkdir $1/plugins
  mkdir $1/tpl
  mkdir $1/tpl/templates
  mkdir $1/tpl/templates_c
  mkdir $1/tpl/config
  mkdir $1/tpl/cache
  mkdir $1/tpl/images
  mkdir $1/tpl/css
  mkdir $1/tpl/javascript
  touch $1/tpl/templates/$1.tpl
  #chown -R nobody $1/tpl
  #chmod -R 770 $1/tpl

  echo "<?php " > $1/$1.php
  echo >> $1/$1.php
  echo "  class $1 extends $2 " >> $1/$1.php
  echo "  {" >> $1/$1.php
  echo "      function $1()" >> $1/$1.php
  echo "      {" >> $1/$1.php
  echo "          \$this->$2();" >> $1/$1.php
  echo "      }" >> $1/$1.php
  echo >> $1/$1.php
  echo >> $1/$1.php
  echo >> $1/$1.php
  echo "      function _$1()" >> $1/$1.php
  echo "      {" >> $1/$1.php
  echo "          \$this->_$2();" >> $1/$1.php
  echo "      }" >> $1/$1.php
  echo "  }" >> $1/$1.php
  echo >> $1/$1.php
  echo "?>" >> $1/$1.php

  echo "<?php " > $1/install.php
  echo >> $1/install.php
  echo "  \$module['moduleID'] = JxCreateID('modules','moduleID',100,999);" >> $1/install.php
  echo "  \$module['name'] = '$1';" >> $1/install.php
  echo "  \$module['title'] = '$1';"  >> $1/install.php 
  echo "  \$module['description'] = '$1';" >> $1/install.php
  echo "  \$module['posted'] = time();" >> $1/install.php
  echo "  \$module['available'] = 1;" >> $1/install.php
  echo "  \$module['groups'] = array(1 => '700'," >> $1/install.php
  echo "                            2 => '500'," >> $1/install.php
  echo "                            3 => '400');" >> $1/install.php
  echo >> $1/install.php
  echo "?>" >> $1/install.php
  
  echo "Done."
else
  echo "Please supply a module name"
fi
