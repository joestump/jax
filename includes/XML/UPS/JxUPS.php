<?php

  require_once('XML/Parser.php');

  /**
  * JxUPS
  *
  * Provides an interface to query the UPS XML gateway in real time.
  *
  * @author Joe Stump <joe@joestump.net>
  * @package XML
  */
  class JxUPS extends JxObject
  {

    /**
    * $_username
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var string $_username
    */
    var $_username   = 'joestump98';

    /**
    * $_password
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var string $_password
    */
    var $_password   = 'miester98';

    /**
    * $_accessKey
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var string $_accessKey
    */
    var $_accessKey  = 'CBA541369301EC80';

    /**
    * $_accessURL
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var string $_accessURL
    */
    var $_accessURL  = null;

    /**
    * $_serviceMap
    *
    * @author Joe Stump <joe@joestump.net>
    * @access protected
    * @var string $_serviceMap
    */
    var $_serviceMap = array ('01' => 'UPS Next Day Air',
                              '02' => 'UPS 2nd Day Air',
                              '03' => 'UPS Ground',
                              '07' => 'UPS Worldwide Express',
                              '08' => 'UPS Worldwide Expedited',
                              '11' => 'UPS Standard',
                              '12' => 'UPS 3 Day Select',
                              '13' => 'UPS Next Day Air Saver',
                              '14' => 'UPS Next Day Air Early A.M.',
                              '54' => 'UPS Worldwide Express Plus',
                              '59' => 'UPS 2nd Day Air A.M.',
                              '64' => '',
                              '65' => 'UPS Express Saver');

    function JxUPS()
    {
      $this->JxObject();
    }

    function &factory($type)
    {
      $include = JX_CORE_PATH.'/includes/XML/UPS/Drivers/'.$type.'.php';
      $class   = 'JxUPS_'.$type;
      if(@include($include))
      {
        return new $class();  
      }
    }

    function _doRequest()
    {
      return null;
    }

    function _doResponse()
    {
      return null;
    }

    function process()
    {
      $curl = curl_init();
      $request = $this->_doRequest();

      curl_setopt($curl,CURLOPT_URL,$this->_accessURL);
      curl_setopt($curl,CURLOPT_HEADER,0);
      curl_setopt($curl,CURLOPT_POST,1);
      curl_setopt($curl,CURLOPT_POSTFIELDS,$request);
      curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
      curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
      $response = curl_exec($curl);
      curl_close($curl);

      return $this->_doResponse($response);
    }

    function _JxUPS()
    {
      $this->_JxObject();
    }
  }

  class JxUPS_XML_Parser extends XML_Parser
  {
    var $_data;

    var $statusCode        = null;
    var $statusDescription = null;
    var $errorSeverity     = null;
    var $errorCode         = 0;
    var $errorDescription  = null;

    function JxUPS_XML_Parser()
    {
//      $this->XML_Parser(null,'func');
      $this->XML_Parser();
    }

    function xmltag_responsestatuscode_($xp,$elem)
    {
      $this->statusCode = $this->_data;
    }

    function xmltag_responsestatusdescription_($xp,$elem)
    {
      $this->statusDescription = $this->_data;
    }

    function xmltag_errorseverity_($xp,$elem)
    {
      $this->errorSeverity = $this->_data;
    }

    function xmltag_errorcode_($xp,$elem)
    {
      $this->errorCode = $this->_data;
    }

    function xmltag_errordescription_($xp,$elem)
    {
      $this->errorDescription = $this->_data;
    }

    function defaultHandler($xp,$data)
    {
      $this->_data = $data;
    }

//    function endHandler($xp,$elem)
//    {
//      $this->funcEndHandler($xp,$elem);
//    }

    function _JxUPS_XML_Parser() { }
  }

?>
