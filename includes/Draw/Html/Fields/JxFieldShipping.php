<?php

  require_once(JX_CORE_PATH.'/includes/XML/UPS/JxUPS.php');

  /**
  * JxFieldShipping
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  */
  class JxFieldShipping extends JxField
  {
    var $ups;
    var $result;

    /**
    * JxFieldShipping
    *
    * <code>
    * $field = & new JxFieldShipping('shipping',$_POST['shipping']);
    * $field->required = true;
    * $field->ups->setShipper('MI','48197');
    * $field->ups->setShipTo('MI','49727');
    * $field->ups->weight = 25;
    * $field->label = 'Shipping Rates';
    * $container->addComponent($field);
    * </code>
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    */
    function JxFieldShipping($name,$value)
    {
      $this->JxField($name,$value);
      $this->ups = JxUPS::factory('rate');
    }

    function getElement()
    {
      $this->result = $this->ups->process();
      if(JxUPS::isError($result))
      {
        $log = & JxSingleton::factory('log');
        $log->log($this->result->getMessage());

        $msg = 'UPS XML Service Error: '.$this->result->getMessage().'. This
                error has been logged by the system';

        $class = & new JxFieldHtml($msg);
      }
      else
      {
        $list = array();
        if(is_array($this->result->services))
        {
          while(list($code,$rate) = each($this->result->services))
          {
            $list[$code] = $this->ups->_serviceMap[$code].' ($'.
                           number_format($rate,2).')';
          }
 
          $class = & new JxFieldRadio($this->name,$list,$this->value,1);
        }
        else
        {
          $html = <<< EOT

The UPS shipping calculator is currently down. This means we cannot correctly
calculate or estimate your shipping cost. Please enter the desired shipping
method into the notes field and we will contact you with shipping costs prior
to shipping.

EOT;
          $class = & new JxFieldHtml($html);
        }
      }
      
      return $class->getElement();
    }

    function getData()
    {
      return $this->result->services[$this->value];
    }

    function _JxFieldShipping()
    {
      $this->_JxField();
    }
  }

?>
