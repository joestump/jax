<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Html extends DB_DataObject
  {

    var $__table = 'html';

    var $contentID;
    var $userID;
    var $title;
    var $name;
    var $html;
    var $lastUpdate;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Html',$k,$v);
    } 
  } 


?>