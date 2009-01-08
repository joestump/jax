<?php


  $JX_PROVINCES['AB'] = "Alberta";
  $JX_PROVINCES['BC'] = "British Columbia";
  $JX_PROVINCES['MB'] = "Manitoba";
  $JX_PROVINCES['NB'] = "New Brunswick";
  $JX_PROVINCES['NF'] = "Newfoundland";
  $JX_PROVINCES['NT'] = "Northwest Territory";
  $JX_PROVINCES['NS'] = "Nova Scotia";
  $JX_PROVINCES['NU'] = "Nunavut";
  $JX_PROVINCES['ON'] = "Ontario";
  $JX_PROVINCES['PE'] = "Prince Edward Islan";
  $JX_PROVINCES['QC'] = "Quebec";
  $JX_PROVINCES['SK'] = "Saskatchewan";
  $JX_PROVINCES['YT'] = "Yukon";

  /**
  * JxFieldProvince
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  * @see JxField
  */
  class JxFieldProvince extends JxFieldSelect
  {
    function JxFieldProvince($name,$value='',$size=1,$multiple=0)
    {
      global $JX_PROVINCES;

      $this->JxFieldSelect($name,$JX_PROVINCES,$value,$size,$multiple);
    }

    function _JxFieldProvince()
    {
      $this->_JxFieldSelect();
    }
  }


?>
