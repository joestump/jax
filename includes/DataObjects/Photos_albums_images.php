<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Photos_albums_images extends DB_DataObject
  {

    var $__table = 'photos_albums_images';

    var $imageID;
    var $albumID;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Photos_albums_images',$k,$v);
    } 
  } 


?>