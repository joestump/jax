<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Modules_config extends DB_DataObject
  {

    var $__table = 'modules_config';

    var $module;
    var $var;
    var $value;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Modules_config',$k,$v);
    } 
  } 


?>