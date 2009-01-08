<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Content extends DB_DataObject
  {

    var $__table = 'content';

    var $contentID;
    var $userID;
    var $posted;
    var $lastUpdate;
    var $available;
    var $mime;
    var $title;
    var $search;
    var $module;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Content',$k,$v);
    } 
  } 


?>