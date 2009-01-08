<?

  $JX_STATES['AL'] = 'Alabama';
  $JX_STATES['AK'] = 'Alaska';
  $JX_STATES['AZ'] = 'Arizona';
  $JX_STATES['AR'] = 'Arkansas';
  $JX_STATES['CA'] = 'California';
  $JX_STATES['CO'] = 'Colorado';
  $JX_STATES['CT'] = 'Connecticut';
  $JX_STATES['DE'] = 'Delaware';
  $JX_STATES['FL'] = 'Florida';
  $JX_STATES['GA'] = 'Georgia';
  $JX_STATES['HI'] = 'Hawaii';
  $JX_STATES['ID'] = 'Idaho';
  $JX_STATES['IL'] = 'Illinois';
  $JX_STATES['IN'] = 'Indiana';
  $JX_STATES['IA'] = 'Iowa';
  $JX_STATES['KS'] = 'Kansas';
  $JX_STATES['KY'] = 'Kentucky';
  $JX_STATES['LA'] = 'Louisiana';
  $JX_STATES['ME'] = 'Maine';
  $JX_STATES['MD'] = 'Maryland';
  $JX_STATES['MA'] = 'Massachusetts';
  $JX_STATES['MI'] = 'Michigan';
  $JX_STATES['MN'] = 'Minnesota';
  $JX_STATES['MS'] = 'Mississippi';
  $JX_STATES['MO'] = 'Missouri';
  $JX_STATES['MT'] = 'Montana';
  $JX_STATES['NE'] = 'Nebraska';
  $JX_STATES['NV'] = 'Nevada';
  $JX_STATES['NH'] = 'New Hampshire';
  $JX_STATES['NJ'] = 'New Jersey';
  $JX_STATES['NM'] = 'New Mexico';
  $JX_STATES['NY'] = 'New York';
  $JX_STATES['NC'] = 'North Carolina';
  $JX_STATES['ND'] = 'North Dakota';
  $JX_STATES['OH'] = 'Ohio';
  $JX_STATES['OK'] = 'Oklahoma';
  $JX_STATES['OR'] = 'Oregon';
  $JX_STATES['PA'] = 'Pennsylvania';
  $JX_STATES['RI'] = 'Rhode Island';
  $JX_STATES['SC'] = 'South Carolina';
  $JX_STATES['SD'] = 'South Dakota';
  $JX_STATES['TN'] = 'Tennessee';
  $JX_STATES['TX'] = 'Texas';
  $JX_STATES['UT'] = 'Utah';
  $JX_STATES['VT'] = 'Vermont';
  $JX_STATES['VA'] = 'Virginia';
  $JX_STATES['WA'] = 'Washington';
  $JX_STATES['WV'] = 'West Virginia';
  $JX_STATES['WI'] = 'Wisconsin';
  $JX_STATES['WY'] = 'Wyoming';

  /**
  * JxFieldState
  *
  * @author Joe Stump <joe@joestump.net>
  * @package FormFields
  * @see JxField
  */
  class JxFieldState extends JxFieldSelect
  {
    function JxFieldState($name,$value='',$size=1,$multiple=0)
    {
      global $JX_STATES;

      $this->JxFieldSelect($name,$JX_STATES,$value,$size,$multiple);
    }
  } 
  
?>
