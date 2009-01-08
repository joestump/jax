<?php 

  class menu extends JxAuthNo 
  {
    function menu()
    {
      $this->JxAuthNo();
      $this->displayPage = false;

      $menu = & new JxMenu();
      $menuArray = $menu->getMenu();

      $this->setData('menu',$menuArray);

//      echo '<pre>'; print_r($menuArray); echo '</pre>';
    }

    function test()
    {
      $categories = & new JxContent('menu_categories');
      if(!PEAR::isError($categories))
      {
        if($categories->find())
        {
          while($categories->fetch())
          {
            $row = $categories->toArray();
            echo '<pre>'; print_r($row); echo '</pre>';
          }
        }
      }
    }

    function _menu()
    {
      $this->_JxAuthNo();
    }
  }

  class menuData extends JxContent
  {
    function menuData()
    {
      $this->JxContent();
      $this->table = 'menu_categories';
    }

    function _menuData()
    {
      $this->_JxContent();
    }
  }

?>
