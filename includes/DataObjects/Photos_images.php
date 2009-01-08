<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Photos_images extends DB_DataObject
  {

    var $__table = 'photos_images';

    var $imageID;
    var $userID;
    var $caption;
    var $type;
    var $posted;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Photos_images',$k,$v);
    } 
  } 


?>