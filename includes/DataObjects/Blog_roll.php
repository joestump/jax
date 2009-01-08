<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Blog_roll extends DB_DataObject
  {

    var $__table = 'blog_roll';

    var $rollID;
    var $userID;
    var $title;
    var $description;
    var $url;
    var $hits;
    var $posted;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Blog_roll',$k,$v);
    } 
  } 


?>