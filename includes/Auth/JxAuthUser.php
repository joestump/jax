<?php

/**
 * JxAuthUser
 *
 * @author Joe Stump <joe@joestump.net> 
 * @copyright Joe Stump <joe@joestump.net> 
 * @package JAX
 * @subpackage Auth
 * @filesource
 */


/**
 * JxAuthUser
 *
 * @author Joe Stump <joe@joestump.net> 
 * @package JAX
 * @subpackage Auth
 */
class JxAuthUser extends JxAuth
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
     * JxAuthUser
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function JxAuthUser()
    {
        $this->__construct();
    }

    /**
     * JxAuthUser
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     * @see JxSession, JxUser
     */
    function authenticate()
    {
        return JxSession::isValid();
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
     * _JxAuthUser
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function _JxAuthUser()
    {
        $this->__destruct();
    }
}  

?>
