<?php

  require_once('Config.php');

  class dbdo_turbine extends JxTurbine
  {
    var $validFields = array('TINYINT',
                             'INTEGER',
                             'DECIMAL',
                             'FLOAT',
                             'SMALLINT',
                             'CHAR',
                             'VARCHAR',
                             'LONGVARCHAR',
                             'VARBINARY',
                             'DATE',
                             'TIMESTAMP');

    var $fieldMap    = array('TINYINT'     => 1,
                             'INTEGER'     => 1,
                             'DECIMAL'     => 1,
                             'FLOAT'       => 1,
                             'SMALLINT'    => 1,
                             'CHAR'        => 2,
                             'VARCHAR'     => 2,
                             'LONGVARCHAR' => 2,
                             'VARBINARY'   => 2,
                             'DATE'        => 2,
                             'TIMESTAMP'   => 1);
    function dbdo_turbine()
    {
      $this->JxTurbine();
    }

    function output()
    {
      $iniFile = $this->projectPath.'/../../includes/DataObjects/'.
                 $this->database.'.ini';

      if(!file_exists($iniFile))
      {
        touch($iniFile);
      }

      $iniLinksFile = $this->projectPath.'/../../includes/DataObjects/'.
                      $this->database.'.links.ini';

      if(!file_exists($iniLinksFile))
      {
        touch($iniLinksFile);
      }

      $iniConfig = & new Config();
      $iniLinksConfig = & new Config();
       
      $ini = $iniConfig->parseConfig($iniFile,'inifile');
      $iniFinal = (PEAR::isError($ini)) ? array() : $ini->toArray();

      $links = $iniLinksConfig->parseConfig($iniLinksFile,'inifile');
      $linksFinal = (PEAR::isError($links)) ? array() : $links->toArray();

      $conf = "<?php \n\n".
'  require_once(\'PEAR.php\');'."\n".
'  require_once(\'DB/DataObject.php\');'."\n";


      while(list(,$table) = each($this->tableArray))
      {
        $class = ucwords(strtolower($table['name']));
        $dbdo  = "<?php \n\n";
        $dbdo .= "  require_once('DB/DataObject.php');\n\n";
        $dbdo .= "  class DataObjects_".$class." extends DB_DataObject\n";
        $dbdo .= "  {\n\n";
        $dbdo .= '    var $__table = \''.$table['name']."';\n\n";
        
        
        while(list(,$col) = each($table['columns']))
        {
          $dbdo .= '    var $'.$col['name'].";\n";
          if(in_array($col['type'],$this->validFields))
          {
            $iniArray[$table['name']][$col['name']] = $this->fieldMap[$col['type']];
          }
        }

        $ini_keys = array();
        if(count($table['foreign']))
        {
          $fkeys = array();
          for($i = 0 ; $i < count($table['foreign']) ; ++$i)
          {
/*
            $links .= $table['foreign'][$i]['local'].' = '.
                      $table['foreign'][$i]['foreignTable'].':'.            
                      $table['foreign'][$i]['foreign']."\n";
*/

            $fkeys[$table['name']][] = $table['foreign'][$i];

            if(!in_array($table['foreign'][$i],$ini_keys))
            {
              $ini_keys[$table['name']][] = $table['foreign'][$i]['local'];
            }

/*
            $fkeys[$table['foreign'][$i]['foreignTable']][] = array(
              'local' => $table['foreign'][$i]['foreign'],
              'foreignTable' => $table['name'],
              'foreign' => $table['foreign'][$i]['local']
            );
*/
          }

          while(list($tbl,$fkey) = each($fkeys))
          {
            for($i = 0 ; $i < count($fkey) ; ++$i)
            {
              $iniLinksArray[$tbl][$fkey[$i]['local']] = $fkey[$i]['foreignTable'].':'.$fkey[$i]['foreign'];
            }
          }
        }

        if(count($table['primary']))
        {
          for($i = 0 ; $i < count($table['primary']) ; ++$i)
          {
            if(!in_array($table['primary'][$i],$ini_keys))
            {
              $ini_keys[$table['name']][] = $table['primary'][$i];
            }
          }
        }
        
        if(count($table['key']))
        {
          for($i = 0 ; $i < count($table['key']) ; ++$i)
          {
            if(!in_array($table['key'][$i],$ini_keys))
            {
              $ini_keys[$table['name']][] = $table['key'][$i];
            }
          }
        }

        while(list($key,$val) = each($ini_keys))
        {
          // $ini .= "\n[{$key}__keys]\n";
          for($i = 0 ; $i < count($val) ; ++$i)
          {
            // $ini .= $val[$i].' = 1'."\n";
            $iniArray[$key.'__keys'][$val[$i]] = 1;
          }
          // $ini .= "\n";
        }

 
        $dbdo .= "\n\n";
        $dbdo .= '    function __clone() { return $this; } '."\n\n";
        $dbdo .= '    function staticGet($k,$v=null)'."\n";
        $dbdo .= '    { '."\n";
        $dbdo .= '      return DB_DataObjects::staticGet(\'DataObjects_'.$class.'\',$k,$v);'."\n";
        $dbdo .= '    } '."\n";
        $dbdo .= '  } '."\n";
        $dbdo .= "\n\n?>";

        $conf .= '  require_once(JX_CORE_PATH.\'/includes/DataObjects/'.$class.'.php\');'."\n";

        $this->fileArray['../../includes/DataObjects/'.$class.'.php'] .= $dbdo;
      }

      if(is_array($iniArray) && count($iniArray))
      {
        while(list($key,$val) = each($iniArray))
        {
          $iniFinal['root'][$key] = array_merge($iniFinal['root'][$key],$val);
        }
      }

      if(!is_array($iniLinksArray))
      {
        $iniLinksArray = array();
      }

      if (is_array($linksFinal['root']) && count($linksFinal['root'])) {
          while(list($key,$val) = each($linksFinal['root'])) {
              while(list($k,$v) = each($val)) {
                  if(!isset($iniLinksArray[$key][$k])) {
                      $iniLinksArray[$key][$k] = $v;  
                  }
              }
          }
      }

      $linksFinal['root'] = $iniLinksArray;

      $ini = '';
      if(is_array($iniFinal['root']) && count($iniFinal['root']))
      {
        while(list($key,$val) = each($iniFinal['root']))
        {
          $ini .= "[{$key}]\n";
          while(list($k,$v) = each($val))
          {
            $ini .= $k.' = '.$v."\n";
          }
          $ini .= "\n";
        }

        $this->fileArray['../../includes/DataObjects/'.$this->database.'.ini'] = $ini;
      }


      if(is_array($linksFinal['root']) && count($linksFinal['root']))
      {
        $links = '';
        while(list($key,$val) = each($linksFinal['root']))
        {
          $links .= "[{$key}]\n";
          while(list($k,$v) = each($val))
          {
            $links .= $k.' = '.$v."\n";
          }
          $links .= "\n";
        }

        $this->fileArray['../../includes/DataObjects/'.$this->database.'.links.ini'] = $links;
      }


      $conf .= "\n?>";

      $this->fileArray['config.php'] = $conf;
//      $this->fileArray['init.php'] = $init;
    }

    function mkdir()
    {
      return false;
    }

    function _dbdo_turbine()
    {
      $this->_JxTurbine();
    }
  }

?>
