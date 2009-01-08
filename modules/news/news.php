<?php 

  class news extends JxAuthNo 
  {
    function news()
    {
        $this->JxAuthNo();
    }

    function __default()
    {
        $sql = "SELECT C.userID,C.posted,C.available,N.*
                FROM content AS C, news AS N
                WHERE N.contentID=C.contentID AND
                      C.available > 0
                ORDER BY C.posted DESC 
                LIMIT 0,10";

        $result = $this->db->query($sql);
        if (!PEAR::isError($result) && $result->numRows()) {
            $entries = array();
            while ($row = $result->fetchRow()) {
                $entries[] = $row;
            }
        } 

        $this->setData('entries',$entries);
/*
        if (strlen($_GET['username'])) {
            $userID = JxUser::getUserId($_GET['username']);
            if ((int)$userID > 0) {
                $user = & new JxUser((int)$userID);

                $content = & new JxContent('news_categories');
                $content->table = 'news_categories';
         
                $where = array(" AND C.userID='$userID'");
                $cats = $content->getRecordSet($where);

                $final = array();
                while (list(,$cat) = each($cats)) {
                    $final[] = $cat['contentID'];
                }

          $content->table = 'news';
          $where = array(" AND T.categoryID IN ('".implode("','",$final)."')");

          $entries = $content->getRecordSet($where);
          if(count($entries))
          {
            $this->setData('entries',$entries);
            $this->setData('author',$user->toArray());
          }
        }
      }
*/
    } 


    function view()
    {
        if ((int)$_GET['contentID']) {
            $content = & new JxContent('news');
            $content->contentID = $_GET['contentID'];
            if ($content->find(true)) {
                $user = & new JxUser((int)$content->userID);
                $this->templateFile = 'viewEntry.tpl';
                $this->setData('entry',$content->toArray());
                $this->setData('author',$user->toArray());
            } else {
                $this->templateFile = 'noEntry.tpl';
            }
        }
    }

    function _news()
    {
      $this->_JxAuthNo();
    }
  }


?>
