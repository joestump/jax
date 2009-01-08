<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Modules extends DB_DataObject
  {

    var $__table = 'modules';

    var $moduleID;
    var $name;
    var $title;
    var $description;
    var $image;
    var $posted;
    var $available;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Modules',$k,$v);
    } 
  } 


?>