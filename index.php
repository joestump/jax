<?php

  /**
  * index.php
  *
  * This is the main controller file. It handles the invocation of the various
  * modules, plugin initialization and template rendering. It also loads the
  * config file, etc.
  *
  * @author Joe Stump <joe@joestump.net>
  * @copyright Joe Stump <joe@joestump.net>
  * @filesource
  * @link http://www.jcssolutions.com
  * @link http://www.jerum.com
  * @package JAX
  */

  session_start();

  $_COOKIE['jax_userID']    = $_SESSION['jax_userID'];
  $_COOKIE['jax_sessionID'] = $_SESSION['jax_sessionID'];

  require_once('./JxConfig.php');

  $initialized = array(); // keep track of modules we have initalized
  if (JX_PATH_MODE === JX_PATH_MODE_HOSTED &&
      is_dir(JX_HOSTED_PATH.'/modules')) {
      $dir = dir(JX_HOSTED_PATH.'/modules');
       while (false !== ($entry = $dir->read())) {
          $module = JX_HOSTED_PATH.'/modules/'.$entry;
          if (is_dir($module) && !in_array($entry,array('.','..','CVS'))) {
              if (file_exists($module.'/init.php') && 
                  file_exists($module.'/'.$entry.'.php')) {
                  include($module.'/init.php');
                  $initialized[] = $entry;
              } 
          }
      }
      $dir->close();
  }

  $dir = dir(JX_CORE_PATH.'/modules');
  while (false !== ($entry = $dir->read())) {
      $module = JX_CORE_PATH.'/modules/'.$entry;
      if (!in_array($entry,$initialized) && 
          is_dir($module) && !in_array($entry,array('.','..','CVS'))) {

          if (file_exists($module.'/init.php')) {
              include($module.'/init.php');
          } 

      }
  }
  $dir->close();

  JxUri::parseURI();
  $jaxHandler = JxUri::getHandler();
  $jaxModule = JxUri::getModule();

  $null = null;
  if (strlen($jaxModule)) {   

      if (JX_PATH_MODE === JX_PATH_MODE_DEFAULT) {
          $jaxModulePath = JX_CORE_PATH.'/modules';
          define('JX_CONTENT_PATH',JX_CORE_PATH.'/content');
          define('JX_SECURE_CONTENT_PATH',JX_CORE_PATH.'/../secure');
          define('JX_BASE_PATH',JX_CORE_PATH);
      } else {
          define('JX_CONTENT_PATH',JX_HOSTED_PATH.'/content');
          define('JX_SECURE_CONTENT_PATH',JX_CORE_PATH.'/../secure');
          if (in_array($jaxModule,$initialized)) {
              define('JX_BASE_PATH',JX_HOSTED_PATH);
          } else {
              define('JX_BASE_PATH',JX_CORE_PATH);
          }

          $jaxModulePath = JX_BASE_PATH.'/modules';
      }

      define('JX_BASE_LOG',JX_BASE_PATH.'/jax.log');
      $log = & JxSingleton::factory('log');

      JxPlugin::initializePlugins();
      JxPlugin::doHook('indexTop',$null);

      // Decide if we are running a default module or a sub-module
      $jaxClass = JxUri::getClass();
      if (file_exists($jaxModulePath.'/'.$jaxModule.'/'.$jaxClass.'.php')) {
          $jaxModuleFile = $jaxClass; // we are running a sub-module
      } else {
          $jaxModuleFile = $jaxModule;
      }

      if(JxModule::isValid($jaxModule)) {
          require_once($jaxModulePath.'/'.$jaxModule.'/config.php');
          require_once($jaxModulePath.'/'.$jaxModule.'/'.$jaxModuleFile.'.php');

          $module = & new $jaxModuleFile();

          // Possibly not used ... grep came up negative
          // $GLOBALS['jax_user'] = & new JxUser($_COOKIE['jax_userID']);

          if (!JxModule::isError($module)) {
              // They don't have proper perms to access this module
              if (!$module->authenticate()) {
                  if (defined('JX_LOGIN_URL')) {
                      $go  = JX_LOGIN_URL;
                  } else {
                      $go  = $_SERVER['SCRIPT_NAME'].'/users/login';
                  }

                  $go .= '?pg='.urldecode($_SERVER['REQUEST_URI']);

                  JxHttp::redirect($go);
              } else {
                  // If the module *must* be ran via SSL (ie. checkout) and 
                  // we are being requested at port 80 we need to redirect.
                  if ($module->forceSSL && JX_HTTP_PROTOCOL != 'https') {
                      $go = 'https://'.$_SERVER['SERVER_NAME'].
                            $_SERVER['REQUEST_URI']; 

                      JxHttp::redirect($go);
                  } elseif (!$module->forceSSL && JX_HTTP_PROTOCOL == 'https') {
                      $go = 'http://'.$_SERVER['SERVER_NAME'].
                            $_SERVER['REQUEST_URI'];

                      JxHttp::redirect($go);
                  }
  
                  $result = null;
                  if (strlen($jaxHandler) && 
                      method_exists($module,$jaxHandler)) {
                      $result = $module->$jaxHandler();
                  } elseif (method_exists($module,'__default')) {
                      $result = $module->__default();
                  }  

                  if (PEAR::isError($result)) {
                      $errorTemplatePath = JX_BASE_PATH.'/tpl/'.JX_TEMPLATE;
                      $template = & new JxTemplate($errorTemplatePath);
                      $module->template = $template;
                      $module->template->assign('msg',$result->getMessage());
                      $module->templateFile = 'error.tpl';
                  }

                  if ($module->user->track) {
                      ob_start();
                  }

                  $module->render();

                  if ($module->user->track) {
                      $contents = ob_get_contents();
                      ob_end_clean();

                  }
              }
          }
      } else {
          // we have an invalid module 
          die("The requested module does not exist or is in a state of error!");
      }

      JxPlugin::doHook('indexBottom',$null);
  } else {
      if(strlen(JX_DEFAULT_MODULE)) {
          $go = JX_APP_PATH.'/'.JX_DEFAULT_MODULE;
  
          if(strlen(JX_DEFAULT_HANDLER)) {
              $go .= '/eventHandler='.JX_DEFAULT_HANDLER;
          }
      } elseif(strlen(trim(JX_DEFAULT_URI))) {
          $go = JX_DEFAULT_URI;
      } else {
          die("JAX Error: No default module defined!");
      }
  
      JxHttp::redirect($go);
  } 

  session_write_close();

?>
