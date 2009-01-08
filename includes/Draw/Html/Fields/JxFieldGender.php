<?php


  /**
  * JxFieldGender
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  */
  class JxFieldGender extends JxFieldRadio
  {
    function JxFieldGender($name,$value='',$list=array())
    {
      if(!count($list))
      {
        $list = array('m' => 'Male',
                      'f' => 'Female');
      }

      $this->JxFieldRadio($name,$list,$value);
    }

    function _JxFieldGender()
    {
      $this->_JxFieldRadio();
    }
  }

?>
