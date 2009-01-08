<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     number_format
 * Purpose:  A frontend to PHP's number_format() function
 * Example:  {$var|number_format:"3"}
 * Author:   Joe Stump <joe@joestump.net>
 * Version:  1.0
 * Date:     September 8th, 2003
 * -------------------------------------------------------------
 */
function smarty_modifier_number_format($text,$decimal=2)
{
  return number_format($text,$decimal);
}

/* vim: set expandtab: */

?>

