<?php


  /**
  * JxUPS_rate
  *
  *
  * 
  * @author Joe Stump <joe@joestump.net>
  * @package XML
  */
  class JxUPS_rate extends JxUPS 
  {
    var $_accessURL = 'https://www.ups.com/ups.app/xml/Rate';

    var $shipper;
    var $shipTo;
    var $weight;

    /**
    * $pickupType
    *
    * 01 - Daily Pickup
    * 03 - Customer Counter
    * 06 - One Time Pickup
    * 07 - On Call Air
    * 11 - Suggested Retail Rates
    * 19 - Letter Center
    * 20 - Air Service Center
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @var string $pickupType
    */
    var $pickupType  = '01';

    /**
    * $packageType
    *
    * 00 - Unknown
    * 01 - UPS letter
    * 02 - Package
    * 03 - UPS Tube
    * 04 - UPS Pak
    * 21 - UPS Express Box
    * 24 - UPS 25Kg Box (r)
    * 25 - UPS 10Kg Box (r)
    */ 
    var $packageType = '02';

    /**
    * $residential
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    * @var string $residential
    */
    var $residential = '0'; 

    /**
    * $serviceCode
    *
    * 01 - UPS Next Day Air
    * 02 - UPS 2nd Day Air
    * 03 - UPS Ground
    * 07 - UPS Worldwide Express
    * 09 - UPS Worldwide Expedited
    * 11 - n/a
    * 12 - n/a
    * 13 - n/a
    * 14 - UPS Next Day Air Early AM
    * 54 - UPS Worldwide Express Plus
    * 59 - n/a
    * 64 - n/a
    * 65 - n/a
    *
    * @author Joe Stump <joe@joestump.net>
    * @access public
    */
    var $serviceCode = null;

    function JxUPS_rate()
    {
      $this->JxUPS();

      $this->shipper = array();
      $this->shipTo  = array();
    }

    function _doResponse($response)
    {
      $xml = & new JxUPS_rate_XML_Parser();
      $xml->parseString($response);
      
      if($xml->statusCode == 0)
      {
        return new PEAR_Error($xml->errorDescription,$xml->errorCode);
      }

      return $xml;
    }

    function setShipper($state,$zip,$country='US')
    {
      $this->shipper = array('state'   => $state,
                             'zip'     => $zip,
                             'country' => $country);
    }

    function setShipTo($state,$zip,$country='US')
    {
      $this->shipTo = array('state'   => $state,
                            'zip'     => $zip,
                            'country' => $country);
    }


    function _doRequest()
    {
      if($this->serviceCode == null)
      {
        $request = 'shop';
      }
      else
      {
        $request = 'rate';
      }

      return "
<?xml version=\"1.0\"?>
<AccessRequest xml:lang=\"en-US\">
   <AccessLicenseNumber>{$this->_accessKey}</AccessLicenseNumber>
   <UserId>{$this->_username}</UserId>
   <Password>{$this->_password}</Password>
</AccessRequest>
<?xml version=\"1.0\"?>
<RatingServiceSelectionRequest xml:lang=\"en-US\">
  <Request>
    <TransactionReference>
      <CustomerContext>Rating and Service</CustomerContext>
      <XpciVersion>1.0001</XpciVersion>
    </TransactionReference>
    <RequestAction>Rate</RequestAction>
    <RequestOption>{$request}</RequestOption>
  </Request>
  <PickupType>
    <Code>{$this->pickupType}</Code>
  </PickupType>
  <Shipment>
    <Shipper>
      <Address>
        <StateProvinceCode>{$this->shipper['state']}</StateProvinceCode>
        <PostalCode>{$this->shipper['zip']}</PostalCode>
        <CountryCode>{$this->shipper['country']}</CountryCode>
      </Address>
    </Shipper>
    <ShipTo>
      <Address>
        <StateProvinceCode>{$this->shipTo['state']}</StateProvinceCode>
        <PostalCode>{$this->shipTo['zip']}</PostalCode>
        <CountryCode>{$this->shipTo['country']}</CountryCode>
        <ResidentialAddressIndicator>
          {$this->residential}
        </ResidentialAddressIndicator>
      </Address>
    </ShipTo>
    <Service>
      <Code>{$this->serviceCode}</Code>
    </Service>
    <Package>
      <PackagingType>
        <Code>{$this->packageType}</Code>
        <Description>Package</Description>
      </PackagingType>
      <Description>Rate Shopping</Description>
      <PackageWeight>
        <Weight>{$this->weight}</Weight>
      </PackageWeight>
    </Package>
    <ShipmentServiceOptions/>
  </Shipment>
</RatingServiceSelectionRequest>
";
    }

    function _JxUPS_rate()
    {
      $this->_JxUPS();
    }
  }

  class JxUPS_rate_XML_Parser extends JxUPS_XML_Parser
  {
    var $services = array();

    function JxUPS_rate_XML_Parser()
    {
      $this->JxUPS_XML_Parser();
    }  

    function startHandler($xp,$elem,$attribs)
    {
      $this->open[$elem] = true;
    }

    function endHandler($xp,$elem)
    {
      $this->funcEndHandler($xp,$elem);

      switch($elem)
      {
        case 'CODE':
          if($this->open['SERVICE'] == true)
          {
            $this->currentService = $this->_data;
            $this->services[$this->_data] = array();
          }
          break;
        case 'MONETARYVALUE':
          if($this->open['TOTALCHARGES'])
          {
            $this->services[$this->currentService] = $this->_data;
          }
          break;  
      }
 
      $this->open[$elem] = false;
    }

    function _JxUPS_rate_XML_Parser() { } 
  }

?>
