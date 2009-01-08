<?php

  // Parse XML data files with JxXMLData

  require_once('../JxConfig.php');
  require_once(JX_CORE_PATH.'/includes/XML/JxXMLData.php');

  $moduleName = $argv[1];

  
  if(is_dir('./'.$moduleName) && 
     file_exists('./'.$moduleName.'/'.$moduleName.'-data.xml'))
  {

    echo 'Attempting to import XML ... ';

    $db  = & JxSingleton::factory('db');
    $xml = & new JxXMLData();
    $xml->setInputFile('./'.$moduleName.'/'.$moduleName.'-data.xml');
    $xml->parse();

    if(PEAR::isError($xml))
    {
      die("\n".$xml->getMessage()."\n");
    }

    $sql = $xml->getSQL();
    $errors = array();
    if(is_array($sql) && count($sql))
    {
      for($i = 0 ; $i < count($sql) ; ++$i)
      {
        $result = $db->query($sql[$i]);
        if(DB::isError($result))
        {
          $errors[] = $result->getMessage();
          $errors[] = $sql[$i];
        } 
      }

      if(count($errors))
      {
        echo "\n";
        echo "!!!!!!!!!!! THE FOLLOWING ERRORS WERE REPORTED !!!!!!!!!!!\n";
        for($i = 0 ; $i < count($errors) ; ++$i)
        {
          echo $errors[$i]."\n";
        }
      }
      else
      {
        echo "done.\n";
      }
    }
  }
  else
  {
    echo "Please specify a valid module name!\n";
  }

?>
