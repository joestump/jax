<?php

/**
 * JxSession 
 *
 * @author Joe Stump <joe@joestump.net>
 * @copyright Joe Stump <joe@joestump.net>
 * @link http://www.jcssolutions.com
 * @package JAX
 * @subpackage Auth
 * @filesource
 */

define('JX_SESS_KEY','%%^*$#*@');
define('JX_SESS_AUTH_NO',1);
define('JX_SESS_AUTH_USER',2);
define('JX_SESS_AUTH_GROUP',4);
define('JX_SESS_AUTH_ADMIN',8);

/**
 * JxSession 
 *
 * This is the base session class. It handles creating and destroying
 * sessions. This is not to be confused with PHP's sessions. This handles
 * inserts and updates to the users_sessions tables, which means that only
 * one person can use a username at a time. 
 *
 * For example if I log in on Computer A with username "joestump" and then
 * log in on Computer B with username "joestump" the session on Computer A
 * will be destroyed.
 *
 * @author Joe Stump <joe@joestump.net>
 * @package JAX
 * @subpackage Auth
 */
class JxSession extends JxObjectDb 
{
    // {{{ __construct()
    /**
     * __construct
     *
     * PHP 5.x constructor
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function __construct()
    {
        parent::__construct();
    }
    // }}}
    // {{{ JxSession()
    /**
     * JxSession
     *
     * PEAR/PHP 4.x constructor
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function JxSession()
    {
        $this->__construct();
    }
    // }}}
    // {{{ create()
    /**
     * create
     *
     * Create a session for the given $userID. This function sets the two
     * needed cookies for sessions as well as updating the database.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @param int $userID See users table.userID 
     * @return void
     */
    function create($userID)
    {
        $user = & new JxUser($userID);
        if ($user->userID > 0) {
            $sessionID = md5(uniqid(JX_SESS_KEY.$user->password));  
  
            $sql = "INSERT 
                    INTO users_sessions
                    SET userID='".$user->userID."',
                        sessionID='$sessionID',
                        posted='".time()."'";
  
            $result = $this->db->query($sql); 
            if (!DB::isError($result)) {
                JxHttp::setCookie('jax_sessionID',$sessionID);
                JxHttp::setCookie('jax_userID',$user->userID);
            }
        } 
    }
    // }}}
    // {{{ destroy()
    /**
     * destroy
     *
     * Kills session cookies 
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function destroy()
    {
        session_unset();
        session_destroy();
    }
    // }}}
    // {{{ isValid()
    /**
     * isValid
     *
     * Validates the user's session cookies against the latest session on
     * file in the sessions table.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return bool
     * @static
     */
    function isValid()
    {
        $db = & JxSingleton::factory('db');
        if ((strlen($_SESSION['jax_sessionID']) == 32)) {
            $sql = "SELECT sessionID
                    FROM users_sessions
                    WHERE userID='".$_SESSION['jax_userID']."' 
                    ORDER BY posted DESC 
                    LIMIT 1";
  
            $sessionID = $db->getOne($sql);
            if (!PEAR::isError($sessionID) && 
                ($sessionID == $_SESSION['jax_sessionID'])) {
                return true;
            }
        }
  
        return false;
    }
    // }}}
    // {{{ __get()
    /**
     * __get
     *
     * @author Joe Stump <joe@joestump.net>
     * @param string $var
     * @return mixed
     */
    function __get($var) 
    {
        return $_SESSION[$var];
    }
    // }}}
    // {{{ __set()
    /**
     * __set
     *
     * @author Joe Stump <joe@joestump.net>
     * @param string $var
     * @param mixed $val
     * @return void
     */
    function __set($var, $val) 
    {
        $_SESSION[$var] = $val;
    }
    // }}}
    /**
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function __destruct()
    {
        parent::__destruct();
    }
  
    /**
     * _JxSession
     *
     * @author Joe Stump <joe@joestump.net>
     * @access protected
     * @return void
     */
    function _JxSession()
    {
        $this->__destruct();
    }
}

?>
