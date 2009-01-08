<?php

  /**
  * HTTP Class
  *
  * @author Joe Stump <joe@joestump.net>
  * @package JAX
  * @filesource
  */

  /**
  * HTTP Class
  *
  * A basic class for setting cookies and redirecting URL's. It is highly 
  * suggested you use these functions instead of PHP's default. PLEASE NOTE
  * THESE FUNCTIONS ARE ONLY RAN STATICALLY!
  *
  * @author Joe Stump <joe@joestump.net>
  * @package Http
  */
  class JxHttp
  {
      /**
      * setCookie
      *
      * Simplifies setting cookies. Checks for default cookie parameters, which
      * are defined in Config.php.
      *
      * @author Joe Stump <joe@joestump.net>
      * @param string $name
      * @param string $value
      * @param int $timeout
      * @return void
      */
      function setCookie($name,$value,$timeout=0)
      {
          $_SESSION[$name] = $value;
      }
  
      /**
      * redirect
      *
      * Redirects the user to the given URL. If no URL is defined and you have
      * defined a pg value either via $_GET or $_POST the function will redirect
      * to the given pg. $_POST takes precedence over $_GET. PLEASE NOTE THAT IF
      * IT CANNOT FIND A SUITABLE REDIRECT IT REDIRECTS TO "/"!
      *
      * @author Joe Stump <joe@joestump.net>
      * @param string $go
      * @return void
      */
      function redirect($go='')
      {
          if (!strlen($go)) {
              if (strlen($_POST['pg'])) {
                  $go = $_POST['pg'];
              } else {
                  if (strlen($_GET['pg'])) {
                      $go = $_GET['pg'];
                  } else {
                      if (strlen(JX_URI_PATH)) {
                          $go = JX_URI_PATH; // If all else fails
                      } else {
                          $go = '/';
                      }
                  }
              }
          }
     
          header("Location: $go");
          exit();
      }
  }

?>
