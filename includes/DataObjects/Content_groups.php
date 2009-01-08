<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Content_groups extends DB_DataObject
  {

    var $__table = 'content_groups';

    var $contentID;
    var $groupID;
    var $permissions;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Content_groups',$k,$v);
    } 
  } 


?>