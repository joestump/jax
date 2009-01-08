<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     strip_slashes
 * Purpose:  Quickly display a number as currency. Changing 
 *           1002.325 to $1,002.33
 * Example:  {$var|strip_slashes}
 * Author:   Joe Stump <joe@joestump.net>
 * Version:  1.0
 * Date:     August 20th, 2003
 * -------------------------------------------------------------
 */
function smarty_modifier_currency($text)
{
  return '$'.number_format($text,2);
}

/* vim: set expandtab: */

?>
