<?php

  require_once('Console/Getopt.php');
  require_once('DB.php');

  function usage()
  {
    die("php -q mysql2turbine.php"); 
  }

  $short = 'u:p:';
  $result = Console_Getopt::getopt($argv,$short);
  if(PEAR::isError($result))
  {
    die($result->getMessage()."\n");
  } 

  list($args,$info) = $result;

  $argList = array('u' => array('user','root'),
                   'p' => array('pass',''));


  $final = array();
  while(list($arg,$defaults) = each($argList))
  {
    for($i = 0 ; $i < count($args) ; ++$i)
    {
      $var = $args[$i][0];
      $val = $args[$i][1];  
      if($arg == $var)
      {
        $final[$defaults[0]] = $val;
      }
    }

    if(!isset($final[$defaults[0]]) && empty($final[$defaults[0]]))
    {
      $final[$defaults[0]] = $defaults[1]; 
    }
  }

  $database = $info[0];
  $tables = array();
  for($i = 1 ; $i < count($info) ; ++$i)
  {
    $tables[] = $info[$i];
  }

  $dsn = 'mysql://'.$final['user'].':'.$final['pass'].'@localhost/'.$database;
  $db = DB::connect($dsn);
  if(!DB::isError($db))
  {
    $db->setFetchMode(DB_FETCHMODE_ASSOC);
    if(!count($tables)) // Convert *all* tables
    {
      $sql = "SHOW TABLES";
      $result = $db->query($sql);
      if(!DB::isError($result) && $result->numRows())
      {
        while($row = $result->fetchRow())
        {
          $tables[] = $row['Tables_in_'.$database];
        }
      }
      else
      {
        die("ERROR: No tables to convert \n"); 
      }
    }

    $fieldMap = array('text'      => 'LONGVARCHAR',
                      'mediumint' => 'SMALLINT',
                      'int'       => 'INTEGER',
                      'blob'      => 'VARBINARY');

    echo '<?xml version="1.0"?>'."\n";
    echo '<!-- MySQL does not support foreign keys. This means   -->'."\n";
    echo '<!-- that this XML file will not reflect foreign key   -->'."\n";
    echo '<!-- relationships. You will have to do that yourself. -->'."\n";
    echo '<database name="'.$database.'">'."\n";
    for($i = 0 ; $i < count($tables) ; ++$i)
    {
      $sql = "DESC ".$tables[$i];
      $result = $db->query($sql);
      if(!DB::isError($result) && $result->numRows())
      {
        // UNI, PRI, MUL
        $unique = array(); // UNI
        $index  = array(); // MUL

        echo '  <table  name="'.$tables[$i].'">'."\n";
        while($row = $result->fetchRow())
        {
          $data = array();
          echo '    <column name="'.$row['Field'].'"'."\n";

          $data['required'] = ($row['Null'] == 'YES') ? 'false' : 'true';
          $data['default']  = ($row['Default'] == null) ? null : $row['Default'];

          switch($row['Key'])
          {
            case 'PRI':
              $data['primaryKey'] = 'true';
              break;
            case 'UNI':
              $unique[] = $row['Field'];
              break;
            case 'MUL':
              $index[]  = $row['Field'];
              break;
          }

          list($type,$size) = explode('(',$row['Type']);
          list($data['size'],) = explode(')',$size);

          if(strlen($fieldMap[$type]))
          {
            $type = $fieldMap[$type];
          }

          $data['type'] = strtoupper($type);

          $sets = array();
          while(list($key,$val) = each($data))
          {
            if($val !== null)
            {
              $sets[] = '            '.$key.'="'.$val.'"';
            }
          }

          echo implode("\n",$sets).'/>'."\n";
          
//          print_r($row);
//          print_r($data);
        }

        if(count($index))
        {
          echo '    <index>'."\n";
          for($x = 0 ; $x < count($index) ; ++$x)
          {
            echo '      <index-column name="'.$index[$x].'"/>'."\n";
          }
          echo '    </index>'."\n";
        }

        if(count($unique))
        {
          echo '    <unique>'."\n";
          for($x = 0 ; $x < count($unique) ; ++$x)
          {
            echo '      <unique-column name="'.$unique[$x].'"/>'."\n";
          }
          echo '    </unique>'."\n";
        }

        echo '  </table>'."\n";
      }      
      else
      {
        echo '  <!-- Invalid table '.$tables[$i].' -->'."\n";
      }
    }
    echo '</database>'."\n";
    echo '<!-- END OF MYSQL2TURBINE DUMP -->'."\n";
  }
  else
  {
    die($db->getMessage()."\n");
  }

?>
