<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     strip_slashes
 * Purpose:  Strip all slashes from a string. Works just like
 *           PHP's stripslashes() function.
 * Example:  {$var|strip_slashes} 
 * Author:   Joe Stump <joe@joestump.net> 
 * Version:  1.0
 * Date:     August 20th, 2003
 * -------------------------------------------------------------
 */
function smarty_modifier_strip_slashes($text)
{
	return stripslashes($text);
}

/* vim: set expandtab: */

?>
