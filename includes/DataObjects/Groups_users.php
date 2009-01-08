<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Groups_users extends DB_DataObject
  {

    var $__table = 'groups_users';

    var $groupID;
    var $userID;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Groups_users',$k,$v);
    } 
  } 


?>