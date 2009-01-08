<?php

  /**
  * JxDate
  *
  * Creates the $JX_DATE_MONTHS and $JX_DATE_DAYS arrays that are used by
  * the JxFieldDate class as of now.
  *
  * @author Joe Stump <joe@joestump.net>
  * @package Util
  */

  for($i = 1 ; $i <= 12 ; ++$i)
  {
    $time = mktime(0,0,0,$i,1,date("Y"));
    $JX_DATE_MONTHS[sprintf('%02d',$i)] = date("F",$time); 
  }

  for($i = 1 ; $i <= 31 ; ++$i)
  {
    $JX_DATE_DAYS[sprintf('%02d',$i)] = sprintf('%02d',$i);
  }

?>
