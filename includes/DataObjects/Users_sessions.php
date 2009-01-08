<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Users_sessions extends DB_DataObject
  {

    var $__table = 'users_sessions';

    var $userID;
    var $sessionID;
    var $posted;
    var $track;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Users_sessions',$k,$v);
    } 
  } 


?>