<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Modules_groups extends DB_DataObject
  {

    var $__table = 'modules_groups';

    var $moduleID;
    var $groupID;
    var $permissions;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Modules_groups',$k,$v);
    } 
  } 


?>