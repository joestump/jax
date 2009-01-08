<?php 

  require_once('DB/DataObject.php');

  class DataObjects_Blog_comments extends DB_DataObject
  {

    var $__table = 'blog_comments';

    var $contentID;
    var $entryID;
    var $name;
    var $email;
    var $url;
    var $comments;


    function __clone() { return $this; } 

    function staticGet($k,$v=null)
    { 
      return DB_DataObjects::staticGet('DataObjects_Blog_comments',$k,$v);
    } 
  } 


?>