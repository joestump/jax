<?php

/**
 * JxAuthAdmin
 * 
 * @author Joe Stump <joe@joestump.net>
 * @copyright Joe Stump <joe@joestump.net>
 * @filesource
 * @link http://www.jcssolutions.com
 * @package JAX
 * @subpackage Auth
 */

/**
 * JxAuthAdmin
 *
 * Use this as your authentication module if your module requires that the
 * person accessing the page is either a site admin or in the Administrators
 * group.
 * 
 * @author Joe Stump <joe@joestump.net>
 * @package JAX
 * @subpackage Auth
 */
class JxAuthAdmin extends JxAuth
{
    /**
     * __construct
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * JxAuthAdmin
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function JxAuthAdmin()
    {
        $this->__construct();
    }

    /**
     * authenticatte
     *
     * Returns true if users.admin is set to 1 or if the user is in the 
     * JX_GRP_ADMIN group. 
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return bool
     * @see JxUser::isAdmin()
     */
    function authenticate()
    {
        return $this->user->isAdmin();
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
     * _JxAuthAdmin
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function _JxAuthAdmin()
    {
        $this->__destruct();
    }

}


?>
