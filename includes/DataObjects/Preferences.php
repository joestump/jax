<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Preferences extends DB_DataObject
  {

    var $__table = 'preferences';

    var $userID;
    var $module;
    var $var;
    var $value;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Preferences',$k,$v);
    } 
  } 


?>