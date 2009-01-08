<?php

/**
 * JxObject File
 *
 * Provides the basic JxObject class as well as defining the is_a() function,
 * which may or may not exist on the system we are using. Also includes the
 * required PEAR and Log classes. For math purposes PEAR and Smarty account
 * for 8725 lines of the total code.
 *
 * @link http://www.jcssolutions.com
 * @link http://www.jerum.com
 * @link http://www.joestump.net
 * @author Joe Stump <joe@joestump.net>
 * @package JAX
 * @subpackage Objects
 * @filesource
 * @version 1.0
 */

require_once('PEAR.php');
require_once('Log.php');

/**
 * JxObject Class
 *
 * The JxObject class is the master class of the entire JAX package. Every
 * class has this at its base. The class merely provides the most basic 
 * logging and error handling (thanks to PEAR). 
 *
 * @author Joe Stump <joe@joestump.net>
 * @package JAX
 * @subpackage Objects
 * @version 1.0
 * @link http://pear.php.net/manual/en/core.pear.php
 * @link http://pear.php.net/manual/en/package.logging.php
 */
class JxObject extends PEAR
{
    /**
     * $log
     *
     * Is merely a reference to the global PEAR Log class. Provides basic 
     * logging. A reference to the log singleton.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @var object $log Instance of PEAR's Log class
     * @link http://pear.php.net/package/Log
     */
    var $log = null;
    // {{{ __construct()
    /**
     * __construct
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     * @see PEAR, JxObject::JxObject()
     */
    function __construct()
    {
        $this->PEAR();
        $this->log = & JxSingleton::factory('log');
    }
    // }}}
    // {{{ JxObject()
    /**
     * JxObject
     *
     * Constructor for JxObject. If $GLOBALS['jax_log'] does not exist it 
     * creates an instance of PEAR Log and references it to $this->log. Also
     * runs the PEAR constructor. Class will error out if it is not used as
     * an abstracted class.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     * @see PEAR::PEAR(), JxObject::$log
     */
    function JxObject()
    {
        $this->__construct();
    }
    // }}}
    // {{{ toArray()
    /**
     * toArray
     *
     * Converts class into a workable associative array keyed by the class vars.
     * This function omits the db and log classes (since they would be copies
     * in the array and would not work properly). This class should recurse
     * if a member variable is an object and contains a method 'toArray'.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return mixed
     */
    function toArray()
    {
        $vars = get_object_vars($this);
        $ret  = array();
        if (is_array($vars) && count($vars)) {
            while (list($key,$val) = each($vars)) {
                if (!in_array($key,array('db','log')) && !ereg('^_',$key)) {
                    if (is_object($val) && method_exists($val,'toArray')) {
                        $ret[$key] = $val->toArray(); 
                    } else {
                        $ret[$key] = $val;
                    }
                }
            }
        }

        return $ret;
    }
    // }}} 
    // {{{ setFrom()
    /**
     * setFrom
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @param mixed $var
     * @return void
     */
    function setFrom($from)
    {
        $vars = array_keys(get_object_vars($this));
        if ((is_array($vars) && count($vars)) && 
            (is_array($from) || is_object($from))) {
            while (list($key,$val) = each($from)) {
                if (in_array($key,$vars)) {
                    $this->$key = $val;
                }
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
        if (!PEAR::isError($this->log) && method_exists($this->log,'close')) {
            $this->log->close();
        }

        $this->_PEAR();
    }
    // }}}
    // {{{ _JxObject()
    /**
     * _JxObject
     *
     * PEAR/PHP 4.x destructor
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void 
     */
    function _JxObject()
    {
        $this->__destruct();
    }
    // }}}
}

// {{{ is_a()
if (!function_exists('is_a')) {
    /**
     * is_a()
     *
     * Takes an instance of a class and then recursively traverses the class's
     * heirchy to see if the class is of type $match. This function should be
     * a part of the PHP4 installation, but may not be present, which is why
     * we reproduce it.
     *
     * @author Joe Stump <joe@joestump.net>
     * @package JAX
     * @subpackage Objects
     * @param mixed $class 
     * @param string $match
     * @return boolean
     * @link http://www.php.net/is_a
     */
    function is_a($class, $match)
    {
        if (empty($class)) {
            return false;
        }

        $class = is_object($class) ? get_class($class) : $class;
        if (strtolower($class) == strtolower($match)) {
            return true;
        }

        return is_a(get_parent_class($class), $match);
    }
}
// }}}
// {{{ error handling config
// PHP5 forward/backward compatability
if (!defined('E_STRICT')) {
    define('E_STRICT',2048);
}

// Initialize the error stack
$GLOBALS['jx_error_stack'] = array();

// Change error texts to something more useful
$GLOBALS['jx_error_text'] = array(E_USER_ERROR => 'Fatal User Error',
                                  E_ERROR => 'Fatal Error',
                                  E_PARSE => 'Fatal Parse Error',
                                  E_CORE_ERROR => 'Fatal Core Error',
                                  E_CORE_ERROR => 'Fatal Compile Error',
                                  E_USER_WARNING => 'User Warning',
                                  E_WARNING => 'Warning',
                                  E_USER_NOTICE => 'User Notice',
                                  E_CORE_WARNING => 'Core Warning',
                                  E_STRICT => 'Strict Warning',
                                  E_NOTICE => 'Notice',
                                  E_COMPILE_WARNING => 'Compile Warning');

// }}}
// {{{ JxErrorHandler
/**
 * JxErrorHandler
 *
 * The custom error handling function for JAX. It keeps track of all errors,
 * warnings and notices. It should handle them as PHP does. If you ever want
 * to see the error stack switch your module's presenter to "debug".
 *
 * @author Joe Stump <joe@joestump.net>
 * @package JAX
 * @param int $errno 
 * @param string $errstr
 * @param string $errfile
 * @param string $errline
 * @return void
 */
function JxErrorHandler($errno,$errstr,$errfile,$errline)
{
    if ($GLOBALS['jax']['JAX_Error_Handling']['level'] == 0) {
        return true;
    }

    $msg = $GLOBALS['jx_error_text'][$errno].': '.$errstr.' in '.$errfile.
           ' on line '.$errline;

    $logMessage = true;
    switch ($errno) {
    case E_USER_ERROR:
    case E_ERROR:
    case E_PARSE:
    case E_CORE_ERROR:
    case E_COMPILE_ERROR:
        // Fatal warnings
        die($msg);
        break;
    case E_USER_WARNING:
    case E_WARNING:
    case E_CORE_WARNING:
    case E_COMPILE_WARNING:
        // Echo out warnings, they usually need to be fixed
        $logMessage = JX_LOG_WARNINGS;
        if (JX_DISPLAY_WARNINGS == true) {
            echo '<br />'.$msg.'<br />'; 
        }

    case E_USER_NOTICE:
    case E_NOTICE:
        // PHP5 forward compatability
    case E_STRICT:
        // Non-Fatal warnings/notices
        $logMessage = JX_LOG_NOTICES;
        array_push($GLOBALS['jx_error_stack'],$msg);
        break;
    }

    if ($logMessage && class_exists('JxSingleton') && 
        class_exists('JxSingletonLog')) {
        $log = & JxSingleton::factory('log');
        if (!PEAR::isError($log) && JX_ERROR_LOGGING == true) {
            $log->log($msg);
        }
    }
}
// }}}

?>
