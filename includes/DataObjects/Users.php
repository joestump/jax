<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Users extends DB_DataObject
  {

    var $__table = 'users';

    var $userID;
    var $password;
    var $email;
    var $fname;
    var $lname;
    var $posted;
    var $admin;
    var $available;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Users',$k,$v);
    } 
  } 


?>