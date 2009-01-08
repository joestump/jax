<?php

/**
 * JxAuth
 *
 * @author Joe Stump <joe@joestump.net>
 * @copyright Joe Stump <joe@joestump.net>
 * @filesource 
 * @link http://www.jcssolutions.com
 * @package JAX
 * @subpackage Auth
 */

/**
 * JxAuth 
 *
 * This is the base module for the entire authentication system of JAX. It
 * is here mainly for looks and to base other Auth modules off of. If your
 * module is based from this package it will return false under all 
 * circumstances and authentcation for your module will be broken.
 *
 * The Auth in JAX works much like PAM does, with different modules 
 * authenticating for different things. Currently there are JxAuthNo,
 * JxAuthUser, and JxAuthAdmin. You could create another module, for instance,
 * that authenticated against other criteria (ie. JxAuthPremier for paid
 * members).
 *
 * @author Joe Stump <joe@joestump.net>
 * @package JAX
 * @subpackage Auth
 */
class JxAuth extends JxModule
{
    // {{{ properties
    /**
    * $canWrite
    *
    * This will be set to true if the current $user is in a group (any group)
    * that has write priveleges at the module level.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @var bool $canWrite
    */
    var $canWrite = 0;
                                                                                
    /**
    * $canRead
    *
    * Since JxModule automatically bounces people who do not have read
    * permissions on your module this flag is most likely useless.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @var bool $canRead
    */
    var $canRead = 0;
  
    /**
    * $canExec
    *
    * This is set to true if a person has been given "post" permissions to
    * your module. If your module ignores $canExec then the "post" permissions
    * bit is ignored and pretty much useless. This is useful if you want to
    * allow only certain users to be able to post comments or other things
    * via a form.
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @var bool $canExec
    */
    var $canExec = 0;
    // }}}

    function __construct()
    {
        parent::__construct();
        $sql = "SELECT M.name,M.title,
                    (CONV(R.permissions,8,10) & CONV(".JX_USER_R.",8,2)) AS r,
                    (CONV(R.permissions,8,10) & CONV(".JX_USER_W.",8,2)) AS w,
                    (CONV(R.permissions,8,10) & CONV(".JX_USER_X.",8,2)) AS x
                FROM modules AS M, modules_groups AS R
                WHERE M.moduleID=R.moduleID AND
                      R.groupID IN (".implode(',',$this->user->groupIds).") AND
                      M.name='".$this->name."' AND
                      ((CONV(R.permissions,8,10) & CONV(".JX_USER_R.",8,2)) > 0)";
                                                                                
        $result = $this->db->query($sql);
        if (!PEAR::isError($result) && $result->numRows()) {
            while ($row = $result->fetchRow()) {
                if ($row['r']) {
                    $this->canRead  = ($row['r']) ? true : false;
                }
                                                                                
                if ($row['w']) {
                    $this->canWrite = ($row['w']) ? true : false;
                }
                                                                                
                if ($row['x']) {
                    $this->canExec  = ($row['x']) ? true : false;
                }
            }
        }
    }
    // {{{ JxAuth()
    /**
     * JxAuth
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function JxAuth()
    {
        $this->__construct();
    }
    // }}}
    // {{{ authenticate()
    /**
     * authenticate
     *
     * Override this function in your authentication modules. This function
     * should check for the criteria of your authentication and return true
     * or false based on the results. 
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return bool
     * @see JxAuthNo, JxAuthUser, JxAuthAdmin
     */
    function authenticate()
    {
        return false;
    }
    // }}}
    // {{{ __destruct()
    /**
     * _JxAuth
     *
     * PHP 5.x destructor
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function __destruct()
    {
        parent::__destruct();
    }
    // }}}
    // {{{ _JxAuth()
    /**
     * _JxAuth
     *
     * PEAR/PHP 4.x destructor
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function _JxAuth()
    {
        $this->__destruct();
    }
    // }}}
}

?>
