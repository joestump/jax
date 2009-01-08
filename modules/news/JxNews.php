<?php

  class JxNews extends JxObjectDb
  {
    function JxNews()
    {
      $this->JxObjectDb();
    }

    function getNews($username,$start=0,$limit=10)
    {
      $entries = array();

      if(is_array($username) && count($username))
      {
        $userIDs = array();
        for($i = 0 ; $i < count($username) ; ++$i)
        {
          $userIDs[] = JxUser::getUserId($username[$i]);
        }

        $where = ' AND C.userID IN ('.implode(',',$userIDs).')';
      }
      else
      {
        $userID = JxUser::getUserId($username);
        $where = ' AND C.userID='.$userID;
      }

      $content = & new JxContent();
      $content->table = 'news';
      $entries = $content->getRecordSet(array($where),
                                        array('C.posted DESC'),
                                        $start,
                                        $limit);

      return $entries;
    }

    function getEntry($contentID)
    {
      return array();
    }

    function _JxNews()
    {
      $this->_JxObjectDb();
    }
  }

?>
