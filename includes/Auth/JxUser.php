<?php

/**
 * JxUser 
 *
 * @author Joe Stump <joe@joestump.net>
 * @copyright Joe Stump <joe@joestump.net> 
 * @package JAX
 * @subpackage Auth
 * @filesource 
 */

/**
 * JxUser Class
 *
 * The core User class built from the users table. Very little information
 * is actually housed in this class. It is more for authentication and 
 * reference purposes.
 *
 * @author Joe Stump <joe@joestump.net> 
 * @package JAX
 * @subpackage Auth
 */
class JxUser extends JxObjectDb
{
    /**
     * $userID
     *
     * @var int $userID
     */
    var $userID = 0;

    /**
     * $username
     *
     * @author Joe Stump <joe@joestump.net> 
     * @access public
     * @deprecated JAX v. 1.6
     */
    var $username;

    /**
     * $password
     *
     * @var string $password
     */
    var $password = '';

    /**
     * $fname
     *
     * @var string $fname User's first name
     */
    var $fname = '';

    /**
     * $lname
     *
     * @var string $lname User's last name
     */ 
    var $lname = '';

    /**
     * $email
     *
     * @var string $email Users' email address
     */ 
    var $email = '';

    /**
     * $admin
     *
     * @var int $admin 1 if the user is an admin, 0 if they are not
     */
    var $admin = 0;

    /**
     * $groups
     *
     * @var array $groups Array of JxGroup objects
     * @see JxGroup
     */
    var $groups = array();

    /**
     * $groupIds
     *
     * @var array $groupIds Array of groupID's
     * @see JxGroup
     */
    var $groupIds = array();

    /**
     * __construct
     *
     * The JxUser constructor. It will return a record based on either a 
     * userID *or* the username. It is important to note that the checks in 
     * the constructor require that $userID_or_username to be typecast as an
     * integer if you wish to pass a $userID. If your $userID comes from a 
     * database $row you should do the following:
     *
     * <code>
     * $user = & new JxUser($row['userID']); // BAD
     * $user = & new JxUser((int)$row['userID']); // GOOD
     * </code>
     *
     * @author Joe Stump <joe@joestump.net> 
     * @access public
     * @param $userID_or_username
     */
    function __construct($userID_or_email)
    {
        parent::__construct();

        if (is_numeric($userID_or_email)) {
            $sql = "SELECT *
                    FROM users
                    WHERE userID='$userID_or_email'";
        } elseif (eregi('\@',$userID_or_email)) {
            $sql = "SELECT *
                    FROM users
                    WHERE email='$userID_or_email'";
        } else {
            $sql = "SELECT *
                    FROM users
                    WHERE username='$userID_or_email'";
        }

        $result = $this->db->query($sql);
        if (!PEAR::isError($result) && $result->numRows()) {
            $this->assign($result->fetchRow()); 
            $this->getGroups();
        } else {
            // Looks like the person is an anonymous user
            $this->groups[] = new JxGroup(JX_GRP_ANON);
            $this->groupIds = array(JX_GRP_ANON);
        }
    }

    /**
     * JxUser
     *
     * @author Joe Stump <joe@joestump.net> 
     * @access public
     * @param $userID_or_username
     */
    function JxUser($userID_or_email)
    {
        $this->__construct($userID_or_email);
    }

    /**
     * getGroups
     *
     * @author Joe Stump <joe@joestump.net> 
     * @access public
     * @return mixed
     */
    function getGroups()
    {
        if (!count($this->groups)) {
            $sql = "SELECT G.* 
                    FROM groups AS G, groups_users AS U
                    WHERE G.groupID=U.groupID AND
                          U.userID='".$this->userID."'"; 

            $result = $this->db->query($sql);
            if (!PEAR::isError($result) && $result->numRows()) {
                while ($row = $result->fetchRow()) {
                    $group = & new JxGroup($row);
                    $this->groups[$group->groupID] = $group;
                    $this->groupIds[] = $group->groupID;
                }
            }
        }

        return $this->groupIds;
    }

    /**
     * isAdmin
     *
     * Returns the special "admin" bit which is set in the database. This makes
     * the user GOD. ANY AND ALL AUTHENTICATION WILL RETURN TRUE IF THIS BIT
     * IS SET TO 1!!!!
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return bool
     */
    function isAdmin()
    {
        return ($this->admin == 1 || in_array(JX_GRP_ADMIN,$this->groupIds));
    }

    /**
     * create
     *
     * Create a user in the database. It also sets up the default groups for
     * the user and should allow for plugins as well.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @param mixed $data
     * @return bool
     */
    function create($data)
    {
        if (is_array($data) && count($data)) {
            $data['userID'] = JxCreateID('users','userID');

            $sql = "INSERT INTO users
                    SET ";
  
            $sets = array();
            $fields = array('userID','username','fname','lname','email',
                            'password','available','posted','admin');

            while (list($key,$val) = each($data)) {
                if (in_array($key,$fields)) {
                    $sets[] = $key."='".$val."'";
                }
            }
       
            $sql .= implode(",\n",$sets);
        
            $result = $this->db->query($sql);
            if (!PEAR::isError($result)) {
                // Add user to the default groups
                if (JxGroup::addMember(JX_GRP_REG,$data['userID'])) {
                    return $data['userID'];
                }
            }
        }

        return false;
    }

    /**
     * delete
     *
     * DOES NOT DELETE! This function merely disables the account by setting
     * the available bit to 0. We can't delete users because they may own
     * content on the site, if they do it would break our JOIN's.
     * 
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @param int $userID
     * @param bool $are_you_sure
     * @return bool
     */
    function delete($userID,$are_you_sure=false)
    {
        if ($are_you_sure === true) {
            $sql = "UPDATE users
                    SET available=0
                    WHERE userID='$userID'";

            $result = $this->db->query($sql);
            if (!PEAR::isError($result)) {
                return true;
            }
        }

        return false;
    }

    /**
     * getUserId
     *
     * Returns the userID for a given $email. This function should be called
     * statically. Returns 0 (false) if the given email does not exist in
     * the database.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @param string $email
     * @return int
     */
    function getUserId($email)
    {
        $db = & JxSingleton::factory('db');
        if (!PEAR::isError($db)) {
            $sql = "SELECT userID
                    FROM users
                    WHERE email='$email'";

            $userID = $db->getOne($sql);
            if (!PEAR::isError($result) && is_numeric($userID)) {
                return $userID;
            }
        }

        return 0;
    }

    /**
     * __destruct
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function __destruct()
    {
        parent::__destruct();
    }

    /**
     * _JxUser
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function _JxUser()
    {
        $this->__destruct();
    }
  }

?>
