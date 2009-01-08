<?php

  class jax_turbine extends JxTurbine
  {

/*
          BIT  | TINYINT | SMALLINT    | INTEGER    | BIGINT    | FLOAT
        | REAL | NUMERIC | DECIMAL     | CHAR       | VARCHAR   | LONGVARCHAR
        | DATE | TIME    | TIMESTAMP   | BINARY     | VARBINARY | LONGVARBINARY
        | NULL | OTHER   | JAVA_OBJECT | DISTINCT   | STRUCT    | ARRAY
        | BLOB | CLOB    | REF         | BOOLEANINT | BOOLEANCHAR
        | DOUBLE


*/
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

    var $fieldMap    = array('TINYINT'     => 'JxFieldText',
                             'INTEGER'     => 'JxFieldText',
                             'DECIMAL'     => 'JxFieldText',
                             'FLOAT'       => 'JxFieldText',
                             'SMALLINT'    => 'JxFieldText',
                             'CHAR'        => 'JxFieldText',
                             'VARCHAR'     => 'JxFieldText',
                             'LONGVARCHAR' => 'JxFieldTextarea',
                             'VARBINARY'   => 'JxFieldTextarea',
                             'DATE'        => 'JxFieldDate',
                             'TIMESTAMP'   => 'JxFieldHidden');

    function jax_turbine()
    {
      $this->JxTurbine();
    }

    function output()
    {
      while(list(,$table) = each($this->tableArray))
      {
        $admin  = "<?php \n\n";
        $admin .= "  class JxAdmin_".$table['name']." extends JxAdmin\n";
        $admin .= "  {\n";
        $admin .= "    function JxAdmin_".$table['name']."()\n";
        $admin .= "    {\n";
        $admin .= '      $this->JxAdmin();'."\n";
        $admin .= '      $this->table = \''.$table['name'].'\';'."\n"; 
        $admin .= '      $this->label = \''.$table['name'].'\';'."\n"; 
        
        $columns = array();
        $titles = array();
        $showFields = array();
        while(list(,$col) = each($table['columns']))
        {
          $titles[] = ucwords($col['name']);
          $showFields[] = $col['name'];
          if(in_array($col['type'],$this->validFields))
          {
            $columns[$col['name']]['name'] = $col['name'];
            $columns[$col['name']]['label'] = $col['name'];
            $columns[$col['name']]['type'] = $this->fieldMap[$col['type']];

            if(strlen($col['size']))
            {
              if($col['size'] > 45)
              {
                $col['size'] = 45;
              }

              $columns[$col['name']]['size'] = $col['size'];
            }


            if($col['required'] == 'true')
            {
              $columns[$col['name']]['required'] = $col['required'];
            }
          }
        }

        $keys = array();
        $pkey_count = count($table['primary']);
        if($pkey_count)
        {
          if($pkey_count == 1)
          {
            $admin .= '      $this->primaryKey = \''.$table['primary'][0].'\';'."\n"; 
          }
          else
          {
            $admin .= '      $this->primaryKey = array(\''.implode("','",$table['primary']).'\');'."\n"; 
          }
        }

        $admin .= '      $this->titles = array(\''.implode("',\n                            '",$titles)."');\n\n";
        $admin .= '      $this->showFields= array(\''.implode("',\n                               '",$showFields)."');\n";

        if(count($table['foreign']))
        {
          for($i = 0 ; $i < count($table['foreign']) ; ++$i)
          {
            if($table['foreign'][$i]['foreignTable'] == 'content')
            {
              $admin .= '    $this->childTable = \''.$table['name'].'\';'."\n";
            }
          } 
        }

/*
        if(count($table['unique']))
        {
          for($i = 0 ; $i < count($table['unique']) ; ++$i)
          {
            if(!in_array($table['unique'][$i],$table['primary']))
            {
              $keys[] = '  KEY('.$table['unique'][$i].')';
              $keys[] = '  UNIQUE ('.$table['unique'][$i].')';
            }
          } 
        }
*/

        $admin .= "\n";
        while(list($key,$val) = each($columns))
        {
          $admin .= '      $this->addField(array(';
          $sets = array();
          while(list($k,$v) = each($val))
          {
            if($n++ != 0)
            {
              $pad = '                            ';
            }
            $sets[] .= $pad.'\''.$k.'\' => \''.$v.'\'';
          }
          $sets[] = $pad."'value' => ".'$_POST'."['".$val['name']."']";
        
          $admin .= implode(",\n",$sets).'));'."\n\n";
          $n = 0; $pad = '';
          $val = array();
        }

        $admin .= "    }\n\n";
        $admin .= "    function _JxAdmin_".$table['name']."()\n";
        $admin .= "    {\n";
        $admin .= '      $this->_JxAdmin();'."\n";
        $admin .= "    }\n";
        $admin .= "  }\n";
        $admin .= "\n?>";

        $this->fileArray['admin/JxAdmin_'.$table['name'].'.php'] .= $admin;
      }
    }

    function _jax_turbine()
    {
      $this->_JxTurbine();
    }
  }

?>
