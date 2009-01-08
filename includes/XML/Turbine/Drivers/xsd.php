<?php

  class xsd_turbine extends JxTurbine
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

    var $fieldMap    = array('BIT'           => null,
                             'TINYINT'       => 'unsignedbyte',
                             'SMALLINT'      => 'short',
                             'INTEGER'       => 'integer',
                             'BIGINT'        => 'long',
                             'FLOAT'         => 'double',
                             'REAL'          => 'float',
                             'NUMERIC'       => 'decimal',
                             'DECIMAL'       => 'decimal',
                             'CHAR'          => 'string',
                             'VARCHAR'       => 'string',
                             'LONGVARCHAR'   => 'string',
                             'DATE'          => 'timeinstant',
                             'TIME'          => 'timeinstant',
                             'TIMESTAMP'     => 'unsignedlong',
                             'BINARY'        => null,
                             'VARBINARY'     => null,
                             'LONGVARBINARY' => null,
                             'BLOB'          => 'string',
                             'CLOB'          => 'string',
                             'BOOLEANINT'    => null,
                             'BOOLEANCHAR'   => null,
                             'DOUBLE'        => 'double');

    function xsd_turbine()
    {
      $this->JxTurbine();
    }

    function output()
    {
      $xsd  = '<?xml version="1.0"?>'."\n";
      $xsd .= '<xsd:schema xmlns:xsd="http://www.w3.org/2000/10/XMLSchema"'."\n"; 
      $xsd .= '            xmlns:od="urn:schemas-microsoft-com:officedata">'."\n";

//      $xsd  = "<xsd:complexType>\n";
      while(list(,$table) = each($this->tableArray))
      {
//        $sql = "create table ".$table['name']." ( \n";
        
        $xsd .= '  <xsd:element name="'.$table['name'].'">'."\n";
        $xsd .= '    <xsd:complexType>'."\n";
        $xsd .= '    <xsd:sequence>'."\n";
        $columns = array();
        while(list(,$col) = each($table['columns']))
        {
          $type = $this->fieldMap[$col['type']];
          $xsd .= '      <xsd:element name="'.$col['name'].'">'."\n";
          if($type !== null)
          {
            $xsd .= '      <xsd:simpleType>'."\n";
            if(strlen($col['size']))
            {
              $xsd .= '        <xsd:restriction base="'.$type.'">'."\n";
              $xsd .= '          <xsd:maxLength value="'.$col['size'].'"/>'."\n";
              $xsd .= '        </xsd:restriction>'."\n";
            }
            else
            {
              $xsd .= '        <xsd:restriction base="'.$type.'"/>'."\n";
            }

/*
            if(strlen($col['default']))
            {
              $column .= " DEFAULT '".$col['default']."'";
            }

            if($col['required'] == 'true')
            {
              $column .= " NOT NULL";
            }

*/

            $xsd .= '      </xsd:simpleType>'."\n";

          }
          $xsd .= '      </xsd:element>'."\n";
        }

        $xsd .= '    </xsd:sequence>'."\n";
        $xsd .= '    </xsd:complexType>'."\n";
        $xsd .= '  </xsd:element>'."\n";

//        $this->fileArray[$this->project.'.sql'] .= $sql;
      }

      $xsd .= "</xsd:schema>\n";
      $this->fileArray[$this->project.'.xsd'] = $xsd;
    }

    function _xsd_turbine()
    {
      $this->_JxTurbine();
    }
  }

?>
