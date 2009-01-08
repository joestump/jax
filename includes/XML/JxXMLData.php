<?php

  class JxXMLData extends XML_Parser
  {
    var $__array    = array();
    var $__data     = null;
    var $__table    = null;
    var $__field    = null;
    var $__pointer  = 0;

    function JxXMLData()
    {
      $this->XML_Parser(null,'func');
    }

    function getData()
    {
      return $this->__array;
    }

    function getSQL()
    {
      $ret = array();
      while(list($table,$row) = each($this->__array))
      {
        for($i = 0 ; $i < count($row) ; ++$i)
        {
          $fields = $values = array();

          if(is_array($row[$i]) && count($row[$i]))
          {
            $sql = "INSERT INTO $table ";
            while(list($field,$value) = each($row[$i]))
            {
              $fields[] = $field;
              $values[] = $value;
            }
   
            $sql .= '('.implode(',',$fields).') VALUES ';
            $sql .= "('".implode("','",$values)."')";
  
            $ret[] = $sql;
          }
        }
      }

      return $ret;
    }

    function xmltag_table($xp,$elem,$attribs)
    {
      $this->__table = $attribs['NAME'];
    }

    function xmltag_table_($xp,$elem)
    {
      $this->__pointer = 0;
    }
 
    function xmltag_field($xp,$elem,$attribs)
    {
      $this->__field = $attribs['NAME'];
    }

    function xmltag_field_($xp,$elem)
    {
      $this->__array[$this->__table][$this->__pointer][$this->__field] = $this->__data;
    }

    function xmltag_row_($xp,$elem)
    {
      $this->__pointer++;
    }

    function defaultHandler($xp,$data)
    {
      $this->__data = $data;
    }
  }

?>
