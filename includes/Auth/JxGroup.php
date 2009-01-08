<?php

/**
 * JxGroup 
 *
 * @link http://www.jcssolutions.com
 * @author Joe Stump <joe@joestump.net>
 * @copyright Joe Stump <joe@joestump.net> 
 * @package JAX
 * @subpackage Auth
 * @filesource
 */

define('JX_GRP_ADMIN',1);
define('JX_GRP_REG',2);
define('JX_GRP_ANON',3);

/**
 * JxGroup
 *
 * The basic group class. Used for fetching group information and verifying
 * whehter a user is actually in a group or not.
 *
 * @author Joe Stump <joe@joestump.net>
 * @package JAX
 * @subpackage Auth
 */
class JxGroup extends JxObjectDb
{
    /**
     * $groupID
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @var int $groupID
     */
    var $groupID;

    /**
     * $name
     * 
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @var string $name Name of the group (ie. 'Administrators')
     */
    var $name = '';

    /**
     * JxGroup
     *
     * You can pass the JxGroup constructor either a groupID or a valid group
     * array in the format of array('groupID' => '1234567879', 'name' => 'Foo').
     * If no group is specified then $groupID and $name are set to null.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @param mixed $groupID_or_array
     * @return void
     */
    function __construct($groupID_or_array=null)
    {
        if (is_array($groupID_or_array) && count($groupID_or_array)) {
            // DANGEROUS: JxGroup assumes the array is VALID!
            $this->assign($groupID_or_array); 
        } elseif($groupID_or_array !== null) {
            $sql = "SELECT *
                    FROM groups
                    WHERE groupID='$groupID_or_array'";
  
            $result = $this->db->query($sql);
            if (!PEAR::isError($result) && $result->numRows()) {
                $this->assign($result->fetchRow());
            } else {
                $this->groupID = null;
                $this->name    = null;
            }
        } else {
            $this->groupID = null;
            $this->name    = null;
        }
    }

    /**
     * JxGroup
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function JxGroup($groupID_or_array=null)
    {
        $this->__construct($groupID_or_array);
    }

    /**
     * isMember
     *
     * A static function that can be called both statically or regular. If no
     * groupID is supplied (as in the satic way) then we attempt to use the
     * member variable. The following are two examples of how to use this
     * function.
     * <code>
     * if (JxGroup::isMember($userID,$groupID) {
     *     echo "I'm a member!";
     * }
     * </code>
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @param int $userID
     * @param int $groupID
     * @return bool 
     * @static
     * @see JxSingleton, JxUser
     */
    function isMember($userID,$groupID=null)
    {
        $db = & JxSingleton::factory('db');
      
        $groupID = ($groupID !== null) ? $groupID : $this->groupID;
 
        $sql = "SELECT *
                FROM groups_users
                WHERE groupID='$groupID' AND
                      userID='$userID'";

        $result = $db->query($sql);
        if (!PEAR::isError($result) && $result->numRows()) {
            return true;
        }
    
        return false;
    }

    /**
     * addMember
     *
     * Static method to add a userID to a particular group
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @param int $groupID
     * @param int $userID
     * @return bool
     * @static
     */
    function addMember($groupID,$userID)
    {
        $db = & JxSingleton::factory('db');

        $sql = "INSERT INTO groups_users
                SET groupID='$groupID',
                    userID='$userID'";

        $result = $db->query($sql);
        if (!PEAR::isError($result)) {
            return true;
        }

        return false;
    }

    /**
     * getGroups
     *
     * Static method to get the system groups ordered by name and keyed by
     * groupID.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return mixed
     */
    function getGroups() 
    {
        $db     = & JxSingleton::factory('db');

        static $groups = array();
        if (!count($groups)) {
            $sql = "SELECT *
                    FROM groups
                    ORDER BY name";

            $result = $db->query($sql);
            if (!PEAR::isError($result) && $result->numRows()) {
                while ($row = $result->fetchRow()) {
                    $groups[$row['groupID']] = $row['name'];
                }  
            }
        }

        return $groups;
    }

    /**
     * __destruct
     *
     * @author Joe Stump <joe@joestump.net>
     * @access protected
     * @return void
     */
    function __destruct()
    {
        parent::__destruct();
    }

    /**
     * _JxGroup
     *
     * @author Joe Stump <joe@joestump.net>
     * @access protected
     * @return void
     */
    function _JxGroup()
    {
        $this->__destruct();
    }
}

?>
