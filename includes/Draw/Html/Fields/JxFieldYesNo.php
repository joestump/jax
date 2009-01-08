<?

  /**
  * JxFieldYesNo
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  * @see JxField
  */
  class JxFieldYesNo extends JxFieldSelect
  {
    function JxFieldYesNo($name,$value='')
    {
      $list = array('0' => 'No','1' => 'Yes');
      $this->JxFieldSelect($name,$list,$value,$size,$multiple);
    }
  } 
  
?>
