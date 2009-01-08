<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Groups extends DB_DataObject
  {

    var $__table = 'groups';

    var $groupID;
    var $name;
    var $sticky;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Groups',$k,$v);
    } 
  } 


?>