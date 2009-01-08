<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Plugins extends DB_DataObject
  {

    var $__table = 'plugins';

    var $name;
    var $module;
    var $title;
    var $available;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Plugins',$k,$v);
    } 
  } 


?>