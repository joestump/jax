<?php

  require_once('XML/Parser.php');

  class JxTurbine extends XML_Parser
  {
    var $project;

    var $tableArray;
    var $fileArray;

    var $database;
    var $table;
    var $columns;

    var $primary;
    var $foreign;
    var $unique;
    var $key;

    var $data;

    var $debug;

    function JxTurbine()
    {
      $this->XML_Parser();

      $this->tableArray = array();
      $this->fileArray  = array();
      $this->table      = null;
      $this->columns    = array();
 
      $this->primary    = array();
      $this->foreign    = array();
      $this->unique     = array();
      $this->key        = array();
      $this->data       = array();
    }  

    function &factory($type)
    {
      $file = JX_CORE_PATH.'/includes/XML/Turbine/Drivers/'.$type.'.php';
      if(@include_once($file))
      {
        $class = $type.'_turbine';
        return new $class(); 
      }  

      return new PEAR_Error('Invalid turbine type!');
    }

    function output()
    {
      print_r($this->tableArray);
    }

    function mkdir()
    {
      return null;
    }

    function write()
    {
      if(count($this->fileArray))
      {
        while(list($file,$contents) = each($this->fileArray))
        {
          // $this->projectFile = $this->getFile();
          if($file !== null && strlen($contents))
          {
            $fp = fopen($this->projectPath.'/'.$file,'w');
            if(is_resource($fp))
            {
              fwrite($fp,$contents,strlen($contents));
              fclose($fp);
              echo "Writing ".$file." ... \n";
            }
            else
            {
              die("Could not write to project file!");
            } 
          }
          else
          {
            echo "Nothing to output ... strange.\n";
          }
        }
      } 
    }

    function startHandler($xp,$elem,&$attribs)
    {
      switch(strtolower($elem))
      {
        case 'column':
          $cleanAttributes = $this->_formatAttributes($attribs);
          $this->columns[] = $cleanAttributes;

          if($cleanAttributes['primarykey'] == 'true')
          {
            $this->primary[] = $cleanAttributes['name'];          
          }

          break;

        case 'table':
          $this->table = $attribs['NAME'];
          break;

        case 'database':
          if(strlen($attribs['NAME']))
          {
            $this->database = $attribs['NAME'];
          }
          else
          {
            die('<database> requires a name attribute!'."\n");
          }

          break;

        case 'index-column':
          $this->key[] = $attribs['NAME'];
          break;

        case 'unique-column':
          $this->unique[] = $attribs['NAME'];
          break;

        case 'foreign-key':
          $this->data['foreignTable'] = $attribs['FOREIGNTABLE'];
          break;

        case 'reference':
          if(strlen($this->data['foreignTable']))
          {
            $this->data['local']   = $attribs['LOCAL'];
            $this->data['foreign'] = $attribs['FOREIGN'];
          }

          break;
      }
    }

    function endHandler($xp,$elem)
    {
      switch(strtolower($elem))
      {
        case 'foreign-key':
          $this->foreign[] = $this->data;
          $this->data      = array();

          break;

        case 'table':
          $this->tableArray[$this->table] = array('name'    => $this->table,
                                                  'columns' => $this->columns,
                                                  'primary' => $this->primary,
                                                  'unique'  => $this->unique,
                                                  'key'     => $this->key,
                                                  'foreign' => $this->foreign);

          $this->table   = null;
          $this->columns = array();
    
          $this->primary = array();
          $this->foreign = array();
          $this->unique  = array();
          $this->key     = array();
          $this->data    = array();

          break;
        case 'database':
          $this->mkdir();
          $this->output();
          $this->write();
          break;
      }
    }

    function _formatAttributes($attribs)
    {
      $ret = array();
      if(is_array($attribs) && count($attribs))
      {
        while(list($key,$val) = each($attribs))
        {
          $ret[strtolower($key)] = $val;  
        }
      }

      return $ret;
    }


    function _JxTurbine()
    {
      return null;
    }
  }

?>
