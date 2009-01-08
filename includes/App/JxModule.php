<?php

/**
 * JxModule 
 *
 * @link http://www.jcssolutions.com
 * @author Joe Stump <joe@joestump.net>
 * @copyright
 * @package JAX
 * @subpackage App
 * @filesource
 */

/**
 * JxModule 
 *
 * JxModule is the heart of JAX. All modules <b>must</b> be based from this
 * class. This class enables user permissions for your module (row level
 * permissions are handled by JxContent), initializes a database connection,
 * initiates an instance of JxUser, sets up an instance of JxTemplate as
 * well as rendering your module within the page template.
 *
 * @author Joe Stump <joe@joestump.net>
 * @package JAX
 * @subpackage App
 */
class JxModule extends JxObjectDb
{
    // {{{ properties
    /**
     * $user
     *
     * An instance of the JxUser class, which can be referenced directly from
     * your module. 
     * 
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @var string $user
     * @see JxUser
     * @see JxSingleton, JxSingleton::factory, JxSingletonUser
     * @see JxModule::JxModule()
     */
    var $user = null;

    /**
     * $path
     *
     * The path to your module. Use this if you need to include files from
     * any of your methods.
     * 
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @var string $path
     */
    var $path = '';

    /**
     * $data
     *
     * A central variable that stores all data until the render() method is
     * called (at which point this array is passed to Smarty). Plugins may
     * or may not access this variable.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @var array $data
     */
    var $data = array();

    /**
     * $template
     *
     * An instance of the JxTemplate class. 
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @var mixed $template
     * @see JxTemplate
     */
    var $template = null;

    /**
     * $templateFile
     *
     * The template file you wish Smarty to render. Currently defaults to 
     * $this->name.'.tpl' in your modules/$this->name/tpl/templates directory.
     * This can be changed anytime before JxModule::render() is called.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @var string $templateFile
     */
    var $templateFile = '';

    /**
     * $displayPage
     *
     * By default JAX wraps your module in an outer template. If your module
     * doesn't want to be warm and fuzzy wrapped up in a nice page template
     * then set this to false.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @var bool $displayPage
     * @deprecated JAX v. 1.6
     */
    var $displayPage = true;

    /**
     * $page
     *
     * Reference to the page singleton.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @var mixed $page
     */
    var $page = null;

    /**
     * $pref
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @var mixed $pref
     */
    var $pref = array();

    /**
     * $forceSSL
     *
     * Set this to true if your application must be ran over SSL
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @var bool $forceSSl
     */
    var $forceSSL = false;

    /**
     * $module
     *
     * @author Joe Stump <joe@joestump.net>
     * @access protected
     * @var mixed $module
     */
    var $module = null;

    /**
     * $presenter
     *
     * @author Joe Stump <joe@joestump.net> 
     * @access protected
     * @var string $presenter
     * @see JxPresenter
     */
    var $presenter = 'smarty';
    // }}}
    // {{{ __construct()
    /**
     *
     * JxModule constructor. This class initializes most of the core variables
     * for all modules (such as the db connection, the template files, etc.)
     * as well as authorizing the user's permissions for the given module. MAKE
     * SURE YOUR MODULE EXISTS IN THE DB WITH PERMISSIONS SET. To create a 
     * module for JAX follow these instructions:
     *
     * <code>
     * <?php
     *
     * // in modulename/modulename.php
     * class modulename extends JxModule
     * {
     *     function __construct()
     *     {
     *         parent::__construct();
     *     }
     *
     *     function modulename()
     *     {
     *         $this->__construct();
     *     }
     *
     *     function __default()
     *     {
     *         // run some code here
     *     }
     * }
     *
     * ?>
     * </code>
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     * @see JxUri::getModule(), JxObjectDb, JX_BASE_PATH, JxTemplate
     * @see JxUser, JxSingleton
     */
    function __construct() {
        parent::__construct();

        $this->name = get_class($this);
        if ($this->name != 'JxModule') {
            $this->path         = JX_BASE_PATH.'/modules/'.JxUri::getModule();
            if (JX_PATH_MODE == JX_PATH_MODE_DEFAULT) {
                $tplPath = $this->path.'/tpl';
            } else {
                $tplPath = JX_HOSTED_PATH.'/modules/'.JxUri::getModule().'/tpl';
            }
            $this->template     = & new JxTemplate($tplPath);
            $this->templateFile = get_class($this).'.tpl';
            $this->page         = & JxSingleton::factory('page');
            $this->user         = & JxSingleton::factory('user');
        } 
    }
    // }}}
    // {{{ JxModule()    
    /**
     * JxModule
     *
     * PEAR/PHP 4.x constructor
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function JxModule()
    {
        $this->__construct();
    }
    // }}}
    // {{{ getModule()
    /**
    * getModule
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @param string $moduleName
    * @return mixed
    */
    function getModule($moduleName)
    {
        $db = & JxSingleton::factory('db');
        $sql = "SELECT * 
                FROM modules
                WHERE name='$moduleName'";
        
        $result = $db->query($sql);
        $module = array();
        if (!PEAR::isError($result) && $result->numRows()) {
            $module = $result->fetchRow();
            $result->free();
        }

        return $module;
    }    
    // }}}
    // {{{ isValid()
    /**
     * isValid
     *
     * Static function to check whether a module is in good enough form to
     * attempt to initialize. It not only checks the modules table, but also
     * makes sure the module's directory structure is sane and that we can
     * at least write to the templates_c directory to compile templates. If
     * ANY of the tests return false then the module is deemed non-functional.
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @param string $moduleName
     * @return bool
     */
    function isValid($moduleName)
    {
        $log = & JxSingleton::factory('log');
        $modules = & DB_DataObject::factory('modules');
        if (!PEAR::isError($modules)) {
            $modules->moduleName = $moduleName;
            if($modules->find()) {
                $modulePath = JX_CORE_PATH.'/modules/'.$moduleName;
                if (JX_PATH_MODE !== JX_PATH_MODE_DEFAULT) {
                    $moduleFile = JX_HOSTED_PATH.'/modules/'.$moduleName.
                                  '/'.$moduleName.'.php';

                    if (file_exists($moduleFile)) {
                        $modulePath = JX_HOSTED_PATH.'/modules/'.$moduleName;
                    }
                }
 
                if(is_dir($modulePath)) {
                    if(file_exists($modulePath.'/'.$moduleName.'.php')) {
                        if(file_exists($modulePath.'/config.php')) {
                            if(is_writable($modulePath.'/tpl/templates_c') &&
                               is_writable($modulePath.'/tpl/cache')) {
                                return true;
                            } else {
                                $log->log('Cannot write template dir: '.
                                          $moduleName);
                            }
                        } else {
                            $log->log('Invalid config file: '.$modulePath);
                        }
                    } else {
                        $log->log('Invalid module file: '.$moduleName);
                    }
                } else {
                    $log->log('Invalid module path: '.$modulePath);
                }
            } else {
                $log->log('Module does not exist in DB: '.$moduleName);
            }
        }
  
        return false;
    }
    // }}}
    // {{{ setData()
    /**
     * setData
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @param string $name
     * @param mixed $data
     * @return void
     */
    function setData($name,$data)
    {
        $this->data[$name] = $data;
    }
    // }}}
    // {{{ authenticate() 
    /**
     * authenticate
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return bool
     * @see JxAuth
     */
    function authenticate()
    {
        return true;
    }
    // }}}
    // {{{ render()
    /**
     * render
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     * @see JxPresenter, JxTemplate, JxUri
     */
    function render()
    {
        if (PEAR::isError($this->template)) {
            die($this->template->getMessage());
        }

        $this->template->assign(JxUri::getModule(),$this->data);

        $present = & JxPresenter::factory($this->presenter);
        if (!JxPresenter::isError($present)) {
            $present->render(&$this);
        } else {
            die($present->getMessage());
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
    // {{{ _JxModule()
    /**
     * _JxModule
     *
     * PEAR/PHP 4.x destructor
     *
     * @author Joe Stump <joe@joestump.net>
     * @access public
     * @return void
     */
    function _JxModule()
    {
        $this->__destruct();
    }
    // }}}
}

?>
