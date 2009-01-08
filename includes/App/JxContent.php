<?php

  require_once(JX_CORE_PATH.'/includes/DataObjects/Content.php');

  class JxContent extends DataObjects_Content
  {
    var $user = null;
    var $_child = null;
    var $_childTable;
    var $_groups = null;
    var $_users = null;

    function JxContent($table)
    {
      $this->_child = & DB_DataObject::factory($table);
      $this->_groups = & DB_DataObject::factory('content_groups');
      $this->_users = & DB_DataObject::factory('users');
      if(!PEAR::isError($this->_child))
      {
        $this->user = JxSingleton::factory('user');
        $this->_childTable = $table;
        $this->joinAdd($this->_child,'');
        $this->joinAdd($this->_groups,'');
        $this->joinAdd($this->_users,'');
        
        $this->selectAdd('SUM((CONV(content_groups.permissions,8,10) & 
                          CONV('.JX_USER_R.',8,2))) AS r');
        $this->selectAdd('SUM((CONV(content_groups.permissions,8,10) & 
                          CONV('.JX_USER_W.',8,2))) AS w');
        $this->selectAdd('SUM((CONV(content_groups.permissions,8,10) & 
                          CONV('.JX_USER_X.',8,2))) AS x');

        $this->whereAdd('content_groups.groupID IN ('.
                        implode(',',$this->user->groupIds).')');

        $this->whereAdd('(CONV(content_groups.permissions,8,10) &
                          CONV('.JX_USER_R.',8,2)) > 0');

        $this->whereAdd('((content.available > 0) OR 
                               (content.userID='.$this->user->userID.'))');

        $this->groupBy('content_groups.contentID');
      }
    }

    /**
    * create
    *
    * <b>IF YOU WANT PERMISSIONS TO WORK ON A ROW LEVEL YOU MUST USE THIS
    * FUNCTION!!!!!!</b> I can't stress this enough. This function will create
    * the content meta data and return a contentID for your child table's
    * record.
    *
    * @author Joe Stump <joe@joestump.net>
    * @param string $title
    * @param int $userID
    * @param int $postTime
    * @return int
    */
    function create($options)
    {
      if(is_array($options) && count($options))
      {
        $title     = $options['title'];
        $search    = $options['search'];
        $userID    = ($options['userID'] > 0) ? $options['userID'] : null;
        $postTime  = ($options['postTime'] > 0) ? $options['postTime'] : time();
        $module    = (strlen($options['module'])) ? $options['module'] : null;
        $available = ($options['available'] > 0) ? $options['available'] : 0;
      }
      else
      {
        return 0;
      }

      if(!strlen($title))
      {
        return 0;
      }

      $content = & DB_DataObject::factory('content');
      $content->contentID = JxCreateId('content','contentID');
      $content->userID = ($userID === null) ? $this->user->userID : $userID;
      $content->posted = $postTime;
      $content->lastUpdate = 0;
      $content->available = $available;
      $content->mime = (!strlen($this->mime)) ? $this->table : $this->mime;
      $content->title = $title;
      $content->search = $search;
      $content->module = ($module === null) ? $this->table : $module;
                                                                                
      if($content->insert())
      {
        // DEFAULT PERMISSIONS FOR EACH NEW CONTENT!
        $default_groups_perms = array(JX_GRP_ADMIN => 700,
                                      JX_GRP_REG => 500,
                                      JX_GRP_ANON => 400);
                                                                                
        while(list($gid,$perms) = each($default_groups_perms))
        {
          $groups = & DB_DataObject::factory('content_groups');
          if(!PEAR::isError($groups))
          {
            $groups->contentID = $content->contentID;
            $groups->groupID = $gid;
            $groups->permissions = $perms;     
            if(!$groups->insert())
            {
              return 0;
            }
          }
        }
                                                                                
        $this->log->log('JxContent: '.$content->contentID.' created by '.
                        $this->user->email);
                                                                                
        return $content->contentID; // everything went well
      }
                                                                                
      return 0;
    }

    /**
    * delete
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param int $contentID
    * @return bool
    */
    function delete($contentID)
    {
      $content = & DB_DataObject::factory('content');
      if(!PEAR::isError($content))
      {
        $content->contentID = $contentID;
        if($content->delete())
        {
          $groups = & DB_DataObject::factory('content_groups');
          if(!PEAR::isError($groups))
          {
            $groups->contentID = $contentID;
            if($content->delete())
            {
              $this->log->log('JxContent: '.$contentID.' deleted by '.
                              $this->user->email);
 
              return true;
            }
          }
        }
      }

      return false;
    }
                                                                                
    /**
    * update
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param int $contentID
    * @param int $available
    * @return bool
    */
    function update($contentID,$options)
    {

      if(is_array($options) && count($options))
      {
        $title = $options['title'];
        $available = ($options['available'] == 0) ? 0 : $options['available'];
        $search = $options['search']; 
        $lastUpdate = time();
      }

      $content = & DB_DataObject::factory('content');
      $content->contentID = $contentID;
      $content->title = $title;
      $content->available = $available;
      $content->search = $search;
      $content->lastUpdate = $lastUpdate;

      if($content->update())
      {
        $this->log->log('JxContent: '.$contentID.' changed by '.
                        $this->user->email);

        return true;
      }

      return false;

    }
  }

?>
