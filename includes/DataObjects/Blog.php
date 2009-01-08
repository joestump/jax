<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Blog extends DB_DataObject
  {

    var $__table = 'blog';

    var $contentID;
    var $categoryID;
    var $title;
    var $teaser;
    var $story;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Blog',$k,$v);
    } 
  } 


?>