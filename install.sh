#!/bin/sh

if [ ! -f ./jax.log ]
then
  echo -n "Creating log file ... "
  touch ./jax.log
  echo "done."
fi

chmod 777 ./jax.log

echo "Setting root level template permissions ... "
echo "     + ./tpl/default/templates_c"
chmod -R 777 ./tpl/default/templates_c
echo "     + ./tpl/default/cache"
chmod -R 777 ./tpl/default/cache
echo "     + ./content"
chmod -R 777 ./content

if [ ! -d ./content ]
then
  echo -n "Creating content directory ... "
  mkdir ./content
  echo "done."
fi

