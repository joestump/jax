<?php 

  require_once('DB/DataObject.php');

  class DataObjects_News extends DB_DataObject
  {

    var $__table = 'news';

    var $contentID;
    var $categoryID;
    var $title;
    var $teaser;
    var $story;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_News',$k,$v);
    } 
  } 


?>