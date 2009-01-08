<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Faq extends DB_DataObject
  {

    var $__table = 'faq';

    var $contentID;
    var $categoryID;
    var $question;
    var $answer;
    var $hits;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Faq',$k,$v);
    } 
  } 


?>