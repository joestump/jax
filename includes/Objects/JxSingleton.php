<?php

/**
 * JxSingleton 
 *
 * @link http://www.jcssolutions.com
 * @author Joe Stump <joe@joestump.net>
 * @copyright Joe Stump <joe@joestump.net>
 * @package JAX
 * @subpackage Singletons
 * @filesource
 */

require_once(JX_CORE_PATH.'/includes/Objects/Singletons/common.php');

/**
 * JxSingleton 
 *
 * This is JAX's Singleton factory, which allows JAX to utilize the singleton
 * concept despite PHP's lacking OOP support (to be substantially fixed come
 * PHP5). To create a singleton of a class simple create a simple singleton
 * wrapper class based from JxSingleton. Below is an example:
 *
 * <code>
 * class JxSingleton_foo extends JxSingleton_common
 * {
 *     function __construct()
 *     {
 *         parent::__construct();
 *     }
 *
 *     function JxSingleton_foo()
 *     {
 *         $this->__construct();
 *     }
 *
 *     function &singleton()
 *     {
 *         static $foo = null
 *         if (is_null($foo)) {
 *             $foo = & new SomeRandomClass();
 *         }
 *
 *         return $foo;
 *     }
 *
 *     function __destruct()
 *     {
 *         parent::__destruct();
 *     }
 * }
 * </code>
 *
 * Once your singleton wrapper has been created you can grab instances of your
 * singleton by doing the following:
 *
 * <code>
 * $foo = & JxSingleton::factory('foo');
 * </code>
 *
 * It's very important to remember the reference (= &). <b>IF YOU DO NOT USE
 * THE REFERENCE YOUR SINGLETON WILL NOT WORK!</b> The JxSingleton class makes
 * sure that only one class is created and, as long as you use references, it
 * should never create more than one (if it does submit a bug report).
 *
 * @author Joe Stump <joe@joestump.net> 
 * @package JAX
 * @subpackage Singletons
 */
class JxSingleton 
{
    // {{{ factory()
    /**
     * factory
     *
     * The factory function creates an instance of $object if one does not 
     * already exist. It returns a <b>reference</b> to that singleton. If you
     * do not use the reference in your calls to factory <b>YOUR SINGLETON WILL
     * NOT WORK!</b> This function is <b>always</b> called statically.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @param string $name Name of singleton
     * @return mixed
     */
    function &factory($name)
    {
        static $singletons = array();
        if (!isset($singletons[$name])) {
            $file = JX_CORE_PATH.'/includes/Objects/Singletons/'.$name.'.php';
            if (include_once($file)) {
                $class = strtolower('JxSingleton_'.$name);
                if (class_exists($class)) {
                    $instance = & new $class();
                    $singletons[$name] = & $instance->singleton();
                }                   
            }
        }

        return $singletons[$name];
    }
    // }}}
}

?>
