<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Photos_albums extends DB_DataObject
  {

    var $__table = 'photos_albums';

    var $albumID;
    var $title;
    var $description;
    var $userID;
    var $posted;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Photos_albums',$k,$v);
    } 
  } 


?>