<?php

  define('DB_DATAOBJECT_NO_OVERLOAD',true);
  define('JX_API_VERSION','1.6');

  // Set up our default path
  define('JX_CORE_PATH',dirname(__FILE__));
  define('SMARTY_DIR',JX_CORE_PATH.'/includes/Smarty/');
  define('IMAGE_TRANSFORM_LIB_PATH','/usr/bin/');

  // Default to using our local install of PEAR
  // $phpPath = ini_get('include_path');
  // ini_set('include_path',JX_CORE_PATH.'/includes/PEAR:'.$phpPath);

  require_once('PEAR.php');
  require_once('DB/DataObject.php');

  $GLOBALS['jax'] = parse_ini_file(JX_CORE_PATH.'/jax.ini.php',TRUE);

  if (isset($_SERVER['SERVER_NAME'])) {
      // Set up the web environment
      define('JX_PATH_MODE_DEFAULT',1); // Use default paths
      define('JX_PATH_MODE_HOSTED',2); // Check for hosted modules

      define('JX_COOKIE_DOMAIN',$_SERVER['SERVER_NAME']);
      define('JX_COOKIE_TIMEOUT',(60 * 60 * 24));
      define('JX_HTTP_URL',$_SERVER['SCRIPT_NAME']);

      $parts = explode('/',$_SERVER['SCRIPT_NAME']);
      define('JX_APP_NAME',$parts[(count($parts) - 1)]);
      if (isset($_SERVER['SCRIPT_NAME']) && strlen(JX_APP_NAME)) {
          list($URI_PATH,) = explode(JX_APP_NAME,$_SERVER['SCRIPT_NAME']);
      } else {
          $URI_PATH = '/';
      }
      define('JX_APP_PATH',$URI_PATH.JX_APP_NAME);
      define('JX_URI_PATH',ereg_replace('/$','',$URI_PATH));

      // Determine if we are running SSL or non-SSL
      if ($_SERVER['SERVER_PORT'] == '443') {
          define('JX_HTTP_PROTOCOL','https');
      } else {
          define('JX_HTTP_PROTOCOL','http');
      }
    
      // Since we set cookies by SERVER_NAME we need to redirect to that
      // if HTTP_HOST is different than SERVER_NAME
      if ($_SERVER['HTTP_HOST'] != $_SERVER['SERVER_NAME']) {
          $url = JX_HTTP_PROTOCOL.'://'.$_SERVER['SERVER_NAME'].
                 $_SERVER['REQUEST_URI'];
          header("Location: $url");
          exit();
      }

    

      $dsn = $GLOBALS['jax']['DB_DataObject']['database'];
      if (eregi('hostname$',$dsn)) {
          $host = ereg_replace('^www\.','',$_SERVER['SERVER_NAME']);
          $db = str_replace('.','_',$host);
          $dsn = eregi_replace('hostname$',$db,$dsn);
          define('JX_PATH_MODE',JX_PATH_MODE_HOSTED);

          $path = $GLOBALS['jax']['JAX_Config']['JX_HOSTED_PATH'];
          $path = sprintf($path,$host);
          define('JX_HOSTED_PATH',$path);
          define('JX_BASE_LOG',JX_HOSTED_PATH.'/../logs/jax.log');

          $GLOBALS['jax']['DB_DataObject']['schema_location'] = $path;

          if (file_exists(JX_HOSTED_PATH.'/local.php')) {
              include_once(JX_HOSTED_PATH.'/local.php');
          }
      } else {
          define('JX_PATH_MODE',JX_PATH_MODE_DEFAULT);
          define('JX_BASE_LOG','/tmp/jax.log');
      }

      // Define the major defines found in jax.ini.php
      if (is_array($GLOBALS['jax']['JAX'])) {
          foreach ($GLOBALS['jax']['JAX'] as $key => $val) {
              if (!defined($key)) {
                  define($key,$val);
              }
          }
      }

      // Check to see if the person has changed their default page template.
      // If they have this should be set in the cookie "jax_template". If you
      // want to you can override this by defining JX_TEMPLATE somewhere above
      // this block of code.
      if (!defined('JX_TEMPLATE') && !strlen($_COOKIES['jax_template'])) {
          define('JX_TEMPLATE','default');
      } else {
          define('JX_TEMPLATE',$_COOKIES['jax_template']);
      }

      // The URI path to the current JX_TEMPLATE directory.
      define('JX_PG_TPL_PATH',JX_URI_PATH.'/tpl/'.JX_TEMPLATE);

  } else {
      // Set up the shell environment
      require_once('Console/Getopt.php');

      $shortoptions = 'p::u:d:t:h:';
      $result = Console_Getopt::getopt($argv,$shortoptions);
      if (!PEAR::isError($result)) {
          $map = array('u' => 'username',
                       'p' => 'password',
                       'd' => 'database',
                       'h' => 'hostspec',
                       't' => 'phptype');

          $dsn = array();

          $dsn['phptype']  = 'mysql'; // default to MySQL 
          $dsn['username'] = 'root';  // default username is root
          $dsn['password'] = 'password';      // default password is nothing
          $dsn['database'] = false;   // default database is jax
          $dsn['hostspec'] = 'localhost'; // default host

          foreach($result[0] as $opt) {
              $dsn[$map[$opt[0]]] = $opt[1];
          }

          if ($dsn['database'] === false) {
              die("Usage: php -q script.php -d database\n");
          }

          $argv = $result[1];
          $argc = count($argv);

          $tmp = $dsn['phptype'].'://'.$dsn['username'];
          if (strlen($dsn['password'])) {
              $tmp .= ':'.$dsn['password'];
          }
          $tmp .= '@'.$dsn['hostspec'].'/'.$dsn['database'];
          unset($dsn);
          $dsn = $tmp;

          define('JX_BASE_LOG','/dev/null');
      } else {
          die($result->getMessage()."\n");
      }
  }

  $GLOBALS['jax']['DB_DataObject']['database'] = $dsn;

  $options = &PEAR::getStaticProperty('DB_DataObject','options');
  $options = $GLOBALS['jax']['DB_DataObject'];

  // if (is_array($GLOBALS['jax']['JAX_Paths'])) {
  //     $paths = $GLOBALS['jax']['JAX_Paths'];
  //     while (list($key,$val) = each($paths)) {
  //         define($key,JX_BASE_PATH.$val);
  //     }
  // }

  define('JX_USER_R','00400');
  define('JX_USER_W','00200');
  define('JX_USER_X','00100');

  define('JX_GROUP_R','02000');
  define('JX_GROUP_W','00040');
  define('JX_GROUP_X','00020');

  define('JX_OTHER_R','00004');
  define('JX_OTHER_W','00002');
  define('JX_OTHER_X','00001');

  define('JX_BASE_DSN',$dsn);

  require_once(JX_CORE_PATH.'/includes/Objects/JxObject.php');
  require_once(JX_CORE_PATH.'/includes/Objects/JxObjectDb.php');
  require_once(JX_CORE_PATH.'/includes/Objects/JxObjectDraw.php');
  require_once(JX_CORE_PATH.'/includes/Objects/JxSingleton.php');
  require_once(JX_CORE_PATH.'/includes/App/JxContent.php');
  require_once(JX_CORE_PATH.'/includes/App/JxModule.php');
  require_once(JX_CORE_PATH.'/includes/App/JxModuleConfig.php');
  require_once(JX_CORE_PATH.'/includes/App/JxPresenter.php');
  require_once(JX_CORE_PATH.'/includes/App/JxPlugin.php');
  require_once(JX_CORE_PATH.'/includes/App/JxPref.php');
  require_once(JX_CORE_PATH.'/includes/Auth/JxUser.php');
  require_once(JX_CORE_PATH.'/includes/Auth/JxGroup.php');
  require_once(JX_CORE_PATH.'/includes/Auth/JxSession.php');
  require_once(JX_CORE_PATH.'/includes/Auth/JxAuth.php');
  require_once(JX_CORE_PATH.'/includes/Auth/JxAuthNo.php');
  require_once(JX_CORE_PATH.'/includes/Auth/JxAuthUser.php');
  require_once(JX_CORE_PATH.'/includes/Auth/JxAuthAdmin.php');
  require_once(JX_CORE_PATH.'/includes/Draw/JxTemplate.php');
  require_once(JX_CORE_PATH.'/includes/Draw/JxPageTemplate.php');
  require_once(JX_CORE_PATH.'/includes/Draw/Html/JxHtmlForm.php');
  require_once(JX_CORE_PATH.'/includes/Draw/Html/JxHtmlFormContainer.php');
  require_once(JX_CORE_PATH.'/includes/Draw/Html/JxHbox.php');
  require_once(JX_CORE_PATH.'/includes/Draw/Html/JxVbox.php');
  require_once(JX_CORE_PATH.'/includes/Draw/Html/JxField.php');
  require_once(JX_CORE_PATH.'/includes/Util/JxDate.php');
  require_once(JX_CORE_PATH.'/includes/Util/JxFunctions.php');
  require_once(JX_CORE_PATH.'/includes/Util/JxNavigate.php');
  require_once(JX_CORE_PATH.'/includes/Util/Http/JxHttp.php');
  require_once(JX_CORE_PATH.'/includes/Util/Http/JxUri.php');

  if (is_array($GLOBALS['jax']['JAX_Error_Handling'])) {
      $errors = $GLOBALS['jax']['JAX_Error_Handling'];
      define('JX_DISPLAY_WARNINGS',$errors['warnings']);
      define('JX_ERROR_LOGGING',$errors['logging']);
      define('JX_LOG_WARNINGS',$errors['log_warnings']);
      define('JX_LOG_NOTICES',$errors['log_notices']);
      set_error_handler($errors['handler']);
      error_reporting((int)$errors['level']);
  }

?>
