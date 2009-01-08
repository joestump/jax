<?

  $JX_STATES_PROVINCES['AL'] = 'Alabama';
  $JX_STATES_PROVINCES['AK'] = 'Alaska';
  $JX_STATES_PROVINCES['AB'] = "Alberta";
  $JX_STATES_PROVINCES['AZ'] = 'Arizona';
  $JX_STATES_PROVINCES['AR'] = 'Arkansas';
  $JX_STATES_PROVINCES['CA'] = 'California';
  $JX_STATES_PROVINCES['CO'] = 'Colorado';
  $JX_STATES_PROVINCES['CT'] = 'Connecticut';
  $JX_STATES_PROVINCES['BC'] = "British Columbia";
  $JX_STATES_PROVINCES['DE'] = 'Delaware';
  $JX_STATES_PROVINCES['FL'] = 'Florida';
  $JX_STATES_PROVINCES['GA'] = 'Georgia';
  $JX_STATES_PROVINCES['HI'] = 'Hawaii';
  $JX_STATES_PROVINCES['ID'] = 'Idaho';
  $JX_STATES_PROVINCES['IL'] = 'Illinois';
  $JX_STATES_PROVINCES['IN'] = 'Indiana';
  $JX_STATES_PROVINCES['IA'] = 'Iowa';
  $JX_STATES_PROVINCES['KS'] = 'Kansas';
  $JX_STATES_PROVINCES['KY'] = 'Kentucky';
  $JX_STATES_PROVINCES['LA'] = 'Louisiana';
  $JX_STATES_PROVINCES['ME'] = 'Maine';
  $JX_STATES_PROVINCES['MB'] = "Manitoba";
  $JX_STATES_PROVINCES['MD'] = 'Maryland';
  $JX_STATES_PROVINCES['MA'] = 'Massachusetts';
  $JX_STATES_PROVINCES['MI'] = 'Michigan';
  $JX_STATES_PROVINCES['MN'] = 'Minnesota';
  $JX_STATES_PROVINCES['MS'] = 'Mississippi';
  $JX_STATES_PROVINCES['MO'] = 'Missouri';
  $JX_STATES_PROVINCES['MT'] = 'Montana';
  $JX_STATES_PROVINCES['NE'] = 'Nebraska';
  $JX_STATES_PROVINCES['NV'] = 'Nevada';
  $JX_STATES_PROVINCES['NF'] = "Newfoundland";
  $JX_STATES_PROVINCES['NB'] = "New Brunswick";
  $JX_STATES_PROVINCES['NH'] = 'New Hampshire';
  $JX_STATES_PROVINCES['NJ'] = 'New Jersey';
  $JX_STATES_PROVINCES['NM'] = 'New Mexico';
  $JX_STATES_PROVINCES['NY'] = 'New York';
  $JX_STATES_PROVINCES['NC'] = 'North Carolina';
  $JX_STATES_PROVINCES['ND'] = 'North Dakota';
  $JX_STATES_PROVINCES['NT'] = "Northwest Territory";
  $JX_STATES_PROVINCES['NS'] = "Nova Scotia";
  $JX_STATES_PROVINCES['NU'] = "Nunavut";
  $JX_STATES_PROVINCES['OH'] = 'Ohio';
  $JX_STATES_PROVINCES['OK'] = 'Oklahoma';
  $JX_STATES_PROVINCES['ON'] = "Ontario";
  $JX_STATES_PROVINCES['OR'] = 'Oregon';
  $JX_STATES_PROVINCES['PA'] = 'Pennsylvania';
  $JX_STATES_PROVINCES['PE'] = "Prince Edward Islan";
  $JX_STATES_PROVINCES['QC'] = "Quebec";
  $JX_STATES_PROVINCES['RI'] = 'Rhode Island';
  $JX_STATES_PROVINCES['SK'] = "Saskatchewan";
  $JX_STATES_PROVINCES['SC'] = 'South Carolina';
  $JX_STATES_PROVINCES['SD'] = 'South Dakota';
  $JX_STATES_PROVINCES['TN'] = 'Tennessee';
  $JX_STATES_PROVINCES['TX'] = 'Texas';
  $JX_STATES_PROVINCES['UT'] = 'Utah';
  $JX_STATES_PROVINCES['VT'] = 'Vermont';
  $JX_STATES_PROVINCES['VA'] = 'Virginia';
  $JX_STATES_PROVINCES['WA'] = 'Washington';
  $JX_STATES_PROVINCES['WV'] = 'West Virginia';
  $JX_STATES_PROVINCES['WI'] = 'Wisconsin';
  $JX_STATES_PROVINCES['WY'] = 'Wyoming';
  $JX_STATES_PROVINCES['YT'] = 'Yukon';

  class JxFieldStateProvince extends JxFieldSelect
  {
      function JxFieldStateProvince($name,$value='',$size=1,$multiple=0)
      {
          global $JX_STATES_PROVINCES;

          $this->JxFieldSelect($name,$JX_STATES_PROVINCES,$value,
                               $size,$multiple);
      }
  } 
  
?>
