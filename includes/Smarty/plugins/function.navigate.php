<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     navigate
 * Version:  1.0
 * Date:     July 1, 2002
 * Author:	 Joe Stump <joe@joestump.net> 
 * Purpose:  display pagination
 * -------------------------------------------------------------
 */
function smarty_function_navigate($params, &$smarty)
{
  extract($params);
  if(!strlen($start))
  {
    $smarty->trigger_error("navigate: missing 'start' parameter");
  }
  elseif(!strlen($limit))
  {
    $smarty->trigger_error("navigate: missing 'limit' parameter");
  }
  elseif(!strlen($total))
  {
    $smarty->trigger_error("navigate: missing 'total' parameter");
  }

  $pageTotal = ($pages > 0) ? $pages : 10;

  // Prep the URL string we use. We can't keep "start" in the URL because
  // it will confuse scripts.
  if ($params['url']) {
      $url = $params['url'];
  } else {
      $url  = $_SERVER['SCRIPT_NAME'].$_SERVER['PATH_INFO'];
  }

  $sets = array();
  foreach($_GET as $key => $val)
  {
    if($key == 'start') {
      continue;
    }

    if (strlen($key) && strlen($val)) {
        if(!ereg($key."=",$_SERVER['PATH_INFO']) && !eregi('\?',$val))
        {
            if (is_array($val)) {
                for($i = 0 ; $i < count($val) ; ++$i) {
                    $sets[] = $key.'[]='.$val[$i];
                }
            } else {
                $sets[] = $key.'='.$val;
            }
        }
    }
  }

  $s = '?';
  if(count($sets))
  {
    $url .= '?'.implode('&',$sets);
    $s = '&';
  }
 
  // Only output if we have more than one page to show

  if($total > $limit)
  {
    $nav = & new JxNavigate($start,$limit,$total,$pageTotal);

    $pages = $nav->getPageList();
    $next  = $nav->getNextPage();
    $prev  = $nav->getPrevPage();
    $begin = $nav->getBeginning();
    $end   = $nav->getEnd();

    echo '<div id="navigate">'."\n";
    echo '<p>'."\n";
    echo '<table border="0"><tr><td>'."\n";

    if (($start + $limit) > $total) {
        $stop = $total;
    } else {
        $stop = ($start + $limit);
    }

    echo ' Showing '.($start + 1).'-'.$stop.' of '.$total."\n";

    echo '[ ';
    if($start > 0) {
      echo '<a href="'.$url.$s.'start='.$begin.'">&laquo;</a> | '."\n";
      echo '<a href="'.$url.$s.'start='.$prev.'">Prev '.$limit.'</a> | '."\n"; 
    }

    $pg = array();
    foreach($pages as $key => $val) {
      if($val == $start) {
        $pg[] = '<span class="navcurrent">'.$key.'</span>';
      } else {
        $pg[] = '<a href="'.$url.$s.'start='.$val.'">'.$key.'</a>';
      }
    }

    echo implode('&nbsp;&nbsp;'."\n",$pg);

    if($next) {
      echo ' | <a href="'.$url.$s.'start='.$next.'">Next '.$limit.'</a> '."\n"; 
    }

    if($start < $end) {
      echo ' | <a href="'.$url.$s.'start='.$end.'">&raquo;</a> '."\n";
    }

    echo ' ] ';

    echo '</td>'."\n";
/*
    echo '<form method="get" action="'.$url.'">'."\n";
    echo '<td>'."\n";
    echo 'Go to Page: '."\n";
    echo '</td>'."\n";
    echo '<td>'."\n";

    echo '<select name="start">'."\n";
    foreach($pages as $key => $val)
    {
      echo "\t".'<option value="'.$val.'"';
      if($val == $start)
      {
        echo ' selected';
      }
      echo '>'.$key.'</option>'."\n"; 
    }

  
    echo '</select>'."\n";
    echo '<input type="submit" value="GO" />'."\n";
    echo '<td>'."\n";
    echo '</form>'."\n";
*/
    echo '</tr></table>'."\n";

    echo '</p>'."\n";
    echo '</div>'."\n";
  }
}

/* vim: set expandtab: */

?>
