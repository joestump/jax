<?php 

  class faq extends JxAuthNo 
  {
    function faq()
    {
        $this->JxAuthNo();
        $this->page->title = 'Frequently Asked Questions';
        if(!strlen(JxUri::getHandler())) {
            $this->getFaqList();
        }
    }

    function getFaqList()
    {
      $this->templateFile = 'faq.tpl';

      $content = & new JxContent('faq_categories');
      $content->orderBy('name');
      if(!PEAR::isError($content))
      {
        if($content->find())
        {
          $final = array();
          while($content->fetch())
          {
            $cat = $content->toArray();
            $faq = & new JxContent('faq');
            if(!PEAR::isError($faq))
            {
              $q = array();
              $faq->whereAdd('faq.categoryID='.$cat['contentID']);
              if($faq->find())
              {
                while($faq->fetch())
                {
                  $q[] = $faq->toArray();       
                }
              }

              $cat['questions'] = $q;
            }

            $final[] = $cat;
          }
        }
      }

      $this->setData('cats',$final);
    }

    function view()
    {
      $this->templateFile = 'viewFAQ.tpl';
      if(strlen($_GET['faqID']))
      {
        $faq = & new JxContent('faq');
        if(!PEAR::isError($faq))
        {
          $faq->whereAdd('faq.contentID='.$_GET['faqID']);
          if($faq->find(true))
          {
            $this->setData('faq',$faq->toArray());
            
            $sql = "UPDATE faq
                    SET hits=(hits+1)
                    WHERE contentID='".$faq->contentID."'";
 
            $this->db->query($sql);
          }
        }
      }
    }

    function _faq()
    {
      $this->_JxAuthNo();
    }
  }

?>
