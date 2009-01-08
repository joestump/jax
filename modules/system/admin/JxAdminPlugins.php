<?php

  class JxAdminPlugins extends JxObjectDb
  {
    function JxAdminPlugins()
    {
      $this->JxObjectDb();
    }

    function render() 
    {
      $template = & new JxTemplate(JX_BASE_PATH.'/modules/system/tpl');
      $templateFile = 'JxAdminPlugins.tpl';

      if (isset($_GET['pluginName']) && isset($_GET['enable'])) {
          $sql = "UPDATE plugins
                  SET available = ".$_GET['enable']."
                  WHERE name='".$_GET['pluginName']."'";       

          $result = $this->db->query($sql);
          if (DB::isError($result)) {
              echo $result->getMessage();
          }
      }

      $pluginDirs = array(JX_CORE_PATH,JX_HOSTED_PATH);
      foreach($pluginDirs as $path) {
          $dir = dir($path.'/modules');
          while(false !== ($entry = $dir->read()))
          {
            if(!in_array($entry,array('.','..')) &&
               is_dir($path.'/modules/'.$entry))
            {
              $plugins = $path.'/modules/'.$entry.'/plugins';
              if(file_exists($plugins) && is_dir($plugins))
              {
                $pdir = dir($plugins);
                while(false !== ($pentry = $pdir->read()))
                {
                  if(!in_array($pentry,array('.','..')) &&
                     eregi('^[a-z]',$pentry) &&
                     is_file($plugins.'/'.$pentry))
                  {
                    list($pluginName,) = explode('.',$pentry);
                    if(!class_exists($pluginName))
                    {
                      include_once($plugins.'/'.$pentry);
                    }
    
                    $sql = "SELECT COUNT(*) AS total
                            FROM plugins
                            WHERE name='$pluginName'";

                    $total = $this->db->getOne($sql);
                    if (!DB::isError($total) && $total == 0) {
                        $class = & new $pluginName();

                        $sql = "INSERT INTO plugins
                                SET name='$pluginName', 
                                    available=0,
                                    module='$entry',
                                    title='".$class->title."'";

                        $insert = $this->db->query($sql);
                        if (DB::isError($insert)) {
                            echo $insert->getMessage().'<br />';
                        }
                    } elseif (DB::isError($total)) {
                        echo $total->getMessage().'<br />';
                    }
                  }
                }
                $pdir->close();
              }
            }
          }
          $dir->close();
      } 

      $plugins = array();
      $plugin = & DB_DataObject::factory('plugins');
      if(!PEAR::isError($plugin))
      {
        if($plugin->find())
        {
          while($plugin->fetch())
          {
            $plugins[] = $plugin->toArray();
          }
        } 
      } 

      $template->assign('plugins',$plugins);

      return $template->fetch($templateFile);
    }

      function _JxAdminPlugins()
      {
          $this->_JxObjectDb();
      }
  }

?>
