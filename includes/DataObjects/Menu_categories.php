<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Menu_categories extends DB_DataObject
  {

    var $__table = 'menu_categories';

    var $contentID;
    var $name;
    var $url;
    var $hits;
    var $sort;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Menu_categories',$k,$v);
    } 
  } 


?>