<?php

  /**
  * JxFunctions
  *
  * Procedural functions that don't have a home anywhere else.
  *
  * @author Joe Stump <joe@joestump.net>
  * @copyright Joe Stump <joe@joestump.net> 
  * @filesource
  * @package Util
  */

  /**
  * createID
  *
  * Create a 
  *
  * @author Joe Stump <joe@joestump.net>
  * @package Util
  * @param string $table
  * @param string $key
  * @return int
  */
  function JxCreateID($table,$key,$floor=100000000,$ceiling=999999999)
  {
    $found = 0;
    $sql = "LOCK TABLES $table";
    $db = JxSingleton::factory('db');
  
    do
    {
      $rand = rand($floor,$ceiling);
  
      $sql = "SELECT *
              FROM $table
              WHERE $key=$rand"; 
      
      $result = $db->query($sql);
      if(!DB::isError($result) && $result->numRows())
      {
        $found = 0;
      }
      else
      {
        $found = 1;
      }

    }while(!$found);
  
    $sql = "UNLOCK TABLES";
    $db->query($sql);

    return $rand;
  }

  /**
  * JxRgb2Hex
  *
  * @author Joe Stump <joe@joestump.net>
  * @access public
  * @package Util
  * @param $r
  * @param $g
  * @param $b
  * @return string
  */
  function JxRgb2Hex($r,$g,$b)
  {
    return dechex($r).dechex($g).dechex($b);  
  }
  

?>
