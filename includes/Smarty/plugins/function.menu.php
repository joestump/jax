<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     menu
 * Version:  1.0
 * Date:     July 1, 2002
 * Author:   Joe Stump <joe@joestump.net>
 * Purpose:  display page menu
 * -------------------------------------------------------------
 */
  function smarty_function_menu($params, &$smarty)
  {
    extract($params);

    if(empty($type))
    {
        $smarty->trigger_error("assign: missing 'type' parameter");
        return;
    }

    $menu = & new JxMenu();
    return $menu->getMenu($type);

  }

?>
