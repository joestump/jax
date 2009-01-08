<?php

/**
 * JxAuthNo
 *
 * @author Joe Stump <joe@joestump.net>
 * @copyright Joe Stump <joe@joestump.net>
 * @filesource
 * @link http://www.jcssolutions.com
 * @package JAX
 * @subpackage Auth
 */

/**
 * JxAuthNo
 *
 * A holder class for modules that do not require any authentication. If your
 * module extends from this no authentication will be performed.
 *
 * @author Joe Stump <joe@joestump.net>
 * @package JAX
 * @subpackage Auth
 */
class JxAuthNo extends JxAuth
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
     * JxAuthNo
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function JxAuthNo()
    {
        $this->__construct();
    }

    /**
     * authenticate
     *
     * Always returns true.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return bool
     */
    function authenticate()
    {
        return true;
    }

    /**
     * __destruct
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return bool
     */
    function __destruct()
    {
        parent::__destruct();
    }

    /**
     * _JxAuthNo
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return bool
     */
    function _JxAuthNo()
    {
        $this->__destruct();
    }
}

?>
