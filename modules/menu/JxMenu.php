<?php

  class JxMenu extends JxObjectDb
  {
    var $template;
    var $templateFile;

    function JxMenu()
    {
      $this->JxObjectDb();

      $this->template     = null;
      $this->templateFile = null;
    }

    function getMenuArray()
    {
        $cats = & new JxContent('menu_categories');
        if ($cats->find()) {
            $ret = array();
            while ($cats->fetch()) {
                $links = & new JxContent('menu_links');
                $links->whereAdd('menu_links.categoryID='.$cats->contentID);
                $category = $cats->toArray();
                if($links->find()) {
                    $linksArray = array(); 
                    while ($links->fetch()) {
                        $link = $links->toArray();  
                        $linksArray[] = $link;
                    }
 
                    $category['links'] = $linksArray;
                }

                $ret[] = $category;
            }
        }

        return $ret;
    }

    function getMenu($type='standard')
    {
        $this->template = & new JxTemplate(JX_HOSTED_PATH.'/modules/menu/tpl');
        if (!PEAR::isError($this->template)) { 
            $this->templateFile = $type.'.tpl'; 
            $menuArray = $this->getMenuArray();
            $this->template->assign('menu',$menuArray);
        
            return $this->template->fetch($this->templateFile);
        } else {
            return $this->template->getMessage();
        }
    }

    function factory($type)
    {
      $class = 'JxMenu_'.$type;
      if(class_exists($class))
      {
        return new $class();
      }
    }

    function _JxMenu()
    {
      $this->_JxObjectDb();
    }
  }

?>
