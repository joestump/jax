<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Blog_bits extends DB_DataObject
  {

    var $__table = 'blog_bits';

    var $bitID;
    var $userID;
    var $title;
    var $description;
    var $url;
    var $hits;
    var $posted;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Blog_bits',$k,$v);
    } 
  } 


?>