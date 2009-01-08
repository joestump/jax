<?php

  class JxFieldAddress extends JxField
  {
    var $address1;
    var $address2;
    var $city;
    var $state;
    var $zip;

    function JxFieldAddress($name,$value=null)
    {
      if($value == null)
      {
        $value = $_POST[$name];
      }

      $this->JxField($name,$value);

      $this->address1 = trim($value['address1']);
      $this->address2 = trim($value['address2']);
      $this->city     = trim($value['city']);
      $this->state    = trim($value['state']);
      $this->zip      = trim($value['zip']);
    }

    function render()
    {
      $vbox = & new JxVBox();

      $field = & new JxFieldText($this->name.'[address1]',$this->address1);
      $field->label = 'Address 1';
      $field->required = $this->required;
      $vbox->addComponent($field);

      $field = & new JxFieldText($this->name.'[address2]',$this->address2);
      $field->label = 'Address 2';
      $field->required = false;
      $vbox->addComponent($field);

      $field = & new JxFieldText($this->name.'[city]',$this->city);
      $field->label = 'City';
      $field->required = $this->required;
      $vbox->addComponent($field);

      $field = & new JxFieldState($this->name.'[state]',$this->state);
      $field->label = 'State';
      $field->required = $this->required;
      $vbox->addComponent($field);

      $field = & new JxFieldText($this->name.'[zip]',$this->zip,10,10);
      $field->label = 'Zip/Postal Code';
      $field->required = $this->required;
      $vbox->addComponent($field);

      return $vbox->render();
    }

    function isValid()
    {
      if(strlen($this->address1) && strlen($this->city) &&
              strlen($this->state) && strlen($this->zip))
      {
        return true;
      }

      $this->errors[] = 'The address you entered appears to be invalid';

      return false;
    }

    function _JxFieldAddress()
    {
      $this->_JxField();
    }
  }

?>
