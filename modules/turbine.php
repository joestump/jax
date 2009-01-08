<?php

  require_once('../JxConfig.php');
  require_once(JX_CORE_PATH.'/includes/XML/Turbine/JxTurbine.php');

  $moduleName = $argv[1];
  $hostName = $argv[2];

  $path = '.';
  if (strlen($hostName)) {
      $path = $GLOBALS['jax']['JAX_Config']['JX_HOSTED_PATH'];
      $path = sprintf($path,$hostName);
      echo "Hosted path: $path \n";
  }

  if(!strlen($moduleName) || !is_dir($path.'/modules/'.$moduleName)) {
      echo "Either an invalid module name or bad path: \n\n";
      echo "module: $moduleName \n";
      echo "  path: $path/modules/$moduleName \n\n";
      die("Usage: php -q turbine.php module\n");
  }

  $turbineFile = $path.'/modules/'.$moduleName.'/'.
                 $moduleName.'-schema.xml';

  echo $turbineFile."\n"; 

  if (file_exists($turbineFile)) {
      $factories = array('mysql','jax','dbdo');
      for ($i = 0 ; $i < count($factories) ; ++$i) {
          $turbine = & JxTurbine::factory($factories[$i]); 
          $turbine->setInputFile($turbineFile);
          $turbine->project = $moduleName;
          $turbine->projectPath = $path.'/modules/'.$moduleName;
          echo 'Project Path: '.$turbine->projectPath."\n";
          $turbine->parse();
      }
  } else {
    die("Could not find $turbineFile \n");
  }

?>
