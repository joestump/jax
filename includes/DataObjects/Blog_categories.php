<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Blog_categories extends DB_DataObject
  {

    var $__table = 'blog_categories';

    var $contentID;
    var $name;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Blog_categories',$k,$v);
    } 
  } 


?>