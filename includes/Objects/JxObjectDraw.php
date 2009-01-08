<?php

/**
 * JxObjectDraw File
 * 
 * @author Joe Stump <joe@joestump.net>
 * @package JAX
 * @subpackage Objects
 * @filesource
 */


/**
 * JxObjectDraw Class
 *
 * This class is the base class for the JxForm and JxField classes. It enables
 * basic component manipulations among other things. As long as components
 * have functions isValid() and render() they should work fine with this
 * class. You should be able to add components into components infinitely.
 *
 * @author Joe Stump <joe@joestump.net>
 * @package JAX
 * @subpackage Objects
 */
class JxObjectDraw extends JxObject
{
    /**
     * $components
     *
     * An array of classes which are also based on JxObjectDraw. You could then
     * recursively render the class (as long as all classes have the function
     * render()).
     *
     * @author Joe Stump <joe@joestump.net>
     * @access private
     */
    var $components = array();

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
    function __construct(){
        parent::__construct();
    }
    // }}}
    // {{{ JxObjectDraw() 
    /**
     * JxObjectDraw
     *
     * PEAR/PHP 4.x constructor
     * 
     * @author Joe Stump <joe@joestump.net>
     * @return void
     * @see JxObject::JxObject(), JxObjectDraw::$components
     */
    function JxObjectDraw()
    {
        $this->__construct();
    }
    // }}}
    // {{{ render() 
    /**
     * render
     *
     * Call all of $this->components render() functions.
     *
     * @author Joe Stump <joe@joestump.net>
     * @return void
     */
    function render()
    {
        if (is_array($this->components) && count($this->components)) {
            for ($i = 0 ; $i < count($this->components) ; ++$i) {
                if (method_exists($this->components,'render')) {
                    $this->components[$i]->render();
                }
            }
        }
    }
    // }}} 
    // {{{ addComponent(&$component)
    /**
     * addComponent
     *
     * Add a component to the components array.
     * 
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @parameter $component 
     * @return void
     */
    function addComponent(&$component)
    {
        if (!PEAR::isError($component)) {
            $this->components[] = $component;
        }
    }
    // }}}
    // {{{ &getComponent($name,$components=array()) 
    /**
     * getComponent
     *
     * Get a reference to the component named $name. No need to pass any
     * components array - it is only used by this function for recursion.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @param string $name Name of component to get
     * @param mixed $components Used to recurse into containers
     */
    function &getComponent($name,$components=array())
    {
        if (!count($components)) {
            $components = $this->components;
        }
  
        for ($i = 0 ; $i < count($components) ; ++$i) {
            if ($components[$i]->name == $name) {
                return $components[$i];
            } else {
                if (is_array($components[$i]->components) &&
                    count($components[$i]->components)) {
                    if (!is_object($return)) {
                        $return = & $this->getComponent($name,$components[$i]->components);
                    }
                }
            }
        }
   
        return $return;
    }
    // }}}
    // {{{ validComponent($component) 
    /**
     * validComponent
     *
     * Does basic checking to make sure the component is valid based on the
     * requirements of a Draw component (ie. it has a render function at least).
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @param mixed $component
     * @return bool
     */
    function validComponent($component)
    {
        return (is_object($component) && 
                !PEAR::isError($component) &&
                method_exists($component,'render'));
    }
    // }}}
    // {{{ isValid() 
    /**
     * isValid
     *
     * Run valid components isValid() functions.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     * @todo Figure out if this function is used and how it is used
     * @todo Find out if this function is overridden
     */
    function isValid()
    {
        for ($i = 0 ; $i < count($this->components) ; ++$i) {
            if (JxObjectDraw::validComponent($this->components[$i])) {
                $this->components[$i]->isValid();
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
    }
    // }}} 
    // {{{ _JxObjectDraw
    /**
     * _JxObjectDraw
     *
     * PEAR/PHP 4.x destructor
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function _JxObjectDraw()
    {
        $this->__destruct();
    }
    // }}}
}

?>
