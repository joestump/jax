<?php 

  class html extends JxAuthNo 
  {
    function html()
    {
      $this->JxAuthNo();

      $parts = explode('/',$_SERVER['PATH_INFO']);
      $name = $parts[(count($parts) - 1)];
 
      if(strlen($name))
      {
        $sql = "SELECT *
                FROM html
                WHERE name='$name'";

        $result = $this->db->getRow($sql);
        if(!DB::isError($result))
        {
          $html = & new JxContent('html');
          if(!PEAR::isError($html))
          {
            $html->whereAdd('html.contentID='.$result['contentID']);
            if ($html->find(true)) {
                $pg = $html->toArray();
                $this->page->title = $pg['title'];
                $this->setData('pg',$pg);
            } else {
                $this->templateFile = 'noperms.tpl';
            }
          }
        }
        else
        {
          $this->templateFile = '404.tpl';
        }
      }
    }

    function _html()
    {
      $this->_JxAuthNo();
    }
  }

?>
