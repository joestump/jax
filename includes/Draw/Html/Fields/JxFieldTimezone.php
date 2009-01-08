<?php

  $JX_TIMEZONES['IDLW'] = '-1200 International Date Line West';
  $JX_TIMEZONES['NT']   = '-1100 Nome';
  $JX_TIMEZONES['HAST'] = '-1000 Hawaii-Aleutian';
  $JX_TIMEZONES['AKST'] = '-0900 Alaska';
  $JX_TIMEZONES['PST']  = '-0800 Pacific';
  $JX_TIMEZONES['MST']  = '-0700 Mountain';
  $JX_TIMEZONES['CST']  = '-0600 Central';
  $JX_TIMEZONES['EDT']  = '-0500 Eastern';
  $JX_TIMEZONES['AST']  = '-0400 Atlantic';
  $JX_TIMEZONES['NST']  = '-0330 Newfoundland';
  $JX_TIMEZONES['GST']  = '-0300 Greenland';
  $JX_TIMEZONES['AT']   = '-0200 Azores';
  $JX_TIMEZONES['WAT']  = '-0100 West Africa';
  $JX_TIMEZONES['UTC']  = '+0000 Universal Coordinated';
  $JX_TIMEZONES['WET']  = '+0000 Western European';
  $JX_TIMEZONES['GMT']  = '+0000 Greenwich Mean';
  $JX_TIMEZONES['CET']  = '+0100 Central European';
  $JX_TIMEZONES['EET']  = '+0200 Eastern European';
  $JX_TIMEZONES['BT']   = '+0300 Baghdad, USSR Zone 2';
  $JX_TIMEZONES['IT']   = '+0330 Iran';
  $JX_TIMEZONES['ZP4']  = '+0400 USSR Zone 3';
  $JX_TIMEZONES['ZP5']  = '+0500 USSR Zone 4';
  $JX_TIMEZONES['IST']  = '+0530 Indian';
  $JX_TIMEZONES['ZP6']  = '+0600 USSR Zone 5';
  $JX_TIMEZONES['ZP7']  = '+0700 USSR Zone 6';
  $JX_TIMEZONES['JT']   = '+0730 Java';
  $JX_TIMEZONES['AWST'] = '+0800 Western Australian';
  $JX_TIMEZONES['CCT']  = '+0800 China Coast, USSR Zone 7';
  $JX_TIMEZONES['KST']  = '+0900 Korean';
  $JX_TIMEZONES['JST']  = '+0900 Japan, USSR Zone 8';
  $JX_TIMEZONES['ACST'] = '+0930 Central Australian';
  $JX_TIMEZONES['AEST'] = '+1000 Eastern Australian';
  $JX_TIMEZONES['MAGS'] = '+1100 Magadan';
  $JX_TIMEZONES['IDLE'] = '+1200 International Date Line East';
  $JX_TIMEZONES['NZST'] = '+1200 New Zealand';

  class JxFieldTimezone extends JxFieldSelect
  {
      function JxFieldTimezone($name,$value) 
      {
          global $JX_TIMEZONES;

          if (!isset($_POST[$name]) && !isset($_GET[$name])) {
              $value = date("T"); 
          }

          $this->JxFieldSelect($name,$JX_TIMEZONES,$value);
      }

      function _JxFieldTimezone() 
      {
          $this->_JxFieldSelect();
      }
  }

?>
