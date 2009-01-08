<?php

/**
 * JxObjectDb File
 * 
 * @author Joe Stump <joe@joestump.net>
 * @package JAX
 * @subpackage Objects
 * @filesource
 */

require_once('DB.php');

/**
 * JxObjectDb Class
 * 
 * The JxObjectDb class is for classes that need an actual database connection
 * for its various methods. If your class does not require a database 
 * connection it is recommended you use JxObject for your class's parent.
 * Don't worry only one connection is created for each page. The JxObjectDb
 * class creates a reference in the $GLOBALS variable to a single instance
 * of the PEAR DB object. That reference is then copied to JxObjectDb::$db.
 *
 * @author Joe Stump <joe@joestump.net> 
 * @package JAX
 * @subpackage Objects
 */
class JxObjectDb extends JxObject
{
  
    /**
     * $db
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @see DB, JxSingleton_db, JxSingleton_db_common
     */
    var $db = null;

    // {{{ __construct() 
    function __construct()
    {
        parent::__construct();
        $this->db = & JxSingleton::factory('db');
    }
    // }}} 
    // {{{ JxObjectDb()
    /**
     * JxObjectDb
     *
     * The JxObjectDb constructor. If an instance the PEAR DB does not exist
     * it will be created and placed in $GLOBALS['jax_db'] and referenced in
     * other JxObjectDb based objects.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     * @see JxObject::JxObject()
     */
    function JxObjectDb()
    {
        $this->__construct();
    }
    // }}} 
    // {{{ assign()
    /**
     * assign
     *
     * A simple function that takes an array and assigns $val to $this->$key,
     * which facilitates doing queries and then assigning the results to the
     * class's members. 
     *
     * <code>
     * class foo extends JxObjectDb
     * {
     *     function foo($userID)
     *     {
     *         $this->JxObjectDb();
     *         $sql = "SELECT * FROM users WHERE userID='$userID'";
     *         $result = $this->db->query();
     *         if (!DB::isError($result) && $result->numRows()) {
     *             $this->assign($result->fetchRow());
     *         }
     *     }
     *  }
     * </code>
     *
     * @author Joe Stump <joe@joestump.net>
     * @param mixed $arr
     * @return void
     */
    function assign($arr)
    {
        if (is_array($arr) && count($arr)) {
            while (list($key,$val) = each($arr)) {
                $this->$key = $val;
            }
        }
    }
    // }}} 
    // {{{ __destruct()
    /**
     * __destruct
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
        if (!DB::isError($this->db) && $this->db !== null) {
            $this->db->disconnect();
            $this->db = null;
        }
    }
    // }}}
    // {{{ _JxObjectDb() 
    /**
     * _JxObjectDb
     *
     * PEAR/PHP 4.x destructor
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function _JxObjectDb()
    {
        $this->__destruct();
    }
    // }}}
}

?>
