<?php

  class JxAdminLog extends JxObjectDb
  {
    function JxAdminLog()
    {
      $this->JxObjectDb();
    }


    function render()
    {
      $ret = '<pre>'."\n";

      $file  = file(JX_BASE_LOG);
      $lines = count($file);
      if($lines)
      {
        $start = ($lines - 100);
        for($i = $start ; $i < $lines ; ++$i)
        {
          $ret .= $file[$i];
        }
      }

      $ret .= '</pre>'."\n";

      return $ret;
    }

    function _JxAdminLog()
    {
      $this->_JxObjectDb();
    }

  }


?>
