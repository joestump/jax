<?php

  /**
  * JxPref File
  *
  * Holds the JxPref class, which handles user/module level preferences.
  *
  * @link http://www.jcssolutions.com
  * @author Joe Stump <joe@joestump.net>
  * @copyright Joe Stump <joe@joestump.net>
  * @filesource
  * @package JAX
  */

  /**
  * JxPref Class
  *
  * @author Joe Stump <joe@joestump.net>
  * @package App
  * @todo Add the ability to store arrays in value field
  */
  class JxPref extends JxObjectDb
  {
    function JxPref()
    {
      $this->JxObjectDb();
    }

    /**
    * getModulePrefs
    *
    * Get user specific preferences for a given userID. This function is 
    * call statically.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param string $module 
    * @param int $userID
    * @return mixed
    */
    function getModulePrefs($module,$userID=0)
    {
      $db = & JxSingleton::factory('db');

      if(!$userID)
      {
        $user = & JxSingleton::factory('user');
        $userID = $user->userID;
      }

      $ret  = array();

      if(!DB::isError($db))
      {
        $sql = "SELECT *
                FROM preferences
                WHERE module='$module' AND
                      userID='".$userID."'";

        $result = $db->query($sql);
        if(!DB::isError($result) && $result->numRows($sql))
        {
          while($row = $result->fetchRow())
          {
            $ret[$row['var']] = $row['value'];
          }
        }
  
      }

      return $ret;
    }

    /**
    * setModulePref
    *
    * Set a user/module specific preference. This function should be called
    * statically. 
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param string $module
    * @param string $var
    * @param string $value
    * @param int $userID
    * @return bool
    */
    function setModulePref($module,$var,$value,$userID=0)
    {
      $db   = & JxSingleton::factory('db');

      if(!$userID)
      {
        $user = & JxSingleton::factory('user');
        $userID = $user->userID;
      }

      if(!DB::isError($db))
      {

        $sql = "REPLACE INTO preferences
                SET userID='".$userID."',
                    module='$module',
                    var='$var',
                    value='$value'";
      
        $result = $db->query($sql);
  
        return (!DB::isError($result));
      }
    }

    /**
    * setDefaultPrefs
    *
    * Set the user's preferences for this module to the default preferences
    * as defined by the $prefs array. The $prefs array is a simple array keyed
    * by the variable name (var).
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param string $module
    * @param mixed $prefs
    * @return void
    * @see JxPref::setModulePref()
    */
    function setDefaultPrefs($module,$prefs)
    {
      if(is_array($prefs) && count($prefs))
      {
        while(list($var,$value) = each($prefs))
        {
          JxPref::setModulePref($module,$var,$value);
        }
      }
    }

    function _JxPref()
    {
      $this->_JxObjectDb();
    }
  }

?>
