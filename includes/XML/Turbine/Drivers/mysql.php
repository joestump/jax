<?php

  class mysql_turbine extends JxTurbine
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

    var $fieldMap    = array('DECIMAL'     => 'float',
                             'SMALLINT'    => 'mediumint',
                             'VARBINARY'   => 'blob',
                             'LONGVARCHAR' => 'text');

    function mysql_turbine()
    {
      $this->JxTurbine();
    }

    function output()
    {
      while(list(,$table) = each($this->tableArray))
      {
        $sql = "create table ".$table['name']." ( \n";
        
        $columns = array();
        while(list(,$col) = each($table['columns']))
        {
          $column = '';
          if(in_array($col['type'],$this->validFields))
          {
            $column = '  '.$col['name'].' ';
            $type = $col['type'];
            if(strlen($this->fieldMap[$type])) 
            {
              $type = $this->fieldMap[$type];
            }

            $column .= $type;
            
            if(strlen($col['size']))
            {
              $column .= '('.$col['size'].')';
            }

            if(strlen($col['default']))
            {
              $column .= " DEFAULT '".$col['default']."'";
            }

            if($col['required'] == 'true')
            {
              $column .= " NOT NULL";
            }

            $columns[] = $column;
          }
        }

        $sql .= implode(",\n",$columns);

        $keys = array();
        if(count($table['primary']))
        {
          $sql .= ",\n";
          $keys[] = "  PRIMARY KEY (".implode(',',$table['primary']).")"; 
        }
        else
        {
          $sql .= ",\n";
        }

        if(count($table['key']))
        {
          for($i = 0 ; $i < count($table['key']) ; ++$i)
          {
            if(!in_array($table['key'][$i],$table['primary']) && 
               !strlen($keys[$table['key'][$i]]))
            {
              $keys[$table['key'][$i]] = '  KEY('.$table['key'][$i].')';
            }
          } 
        }

        if(count($table['foreign']))
        {
          for($i = 0 ; $i < count($table['foreign']) ; ++$i)
          {
            if(!in_array($table['foreign'][$i]['local'],$table['primary']) &&
               !strlen($keys[$table['foreign'][$i]['local']]))
            {
              $keys[$table['foreign'][$i]['local']] = '  KEY('.$table['foreign'][$i]['local'].')';
            }
          } 
        }

        if(count($table['unique']))
        {
          for($i = 0 ; $i < count($table['unique']) ; ++$i)
          {
            if(!in_array($table['unique'][$i],$table['primary']))
            {
              if(!strlen($keys[$table['unique'][$i]]))
              {
                $keys[] = '  KEY('.$table['unique'][$i].')';
              }
              $keys[] = '  UNIQUE ('.$table['unique'][$i].')';
            }
          } 
        }

        $sql .= implode(",\n",$keys)."\n";
        $sql .= ");\n\n";
        $this->fileArray[$this->project.'.sql'] .= $sql;
      }
    }

    function _mysql_turbine()
    {
      $this->_JxTurbine();
    }
  }

?>
