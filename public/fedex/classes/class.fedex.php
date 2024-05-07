<?php

/**
 * Mubashir Ali
 * saad_ali6@yahoo.com
 */
class fedexAPI
{
    protected $ship_account;
    protected $bill_account;
    protected $duty_account;
    protected $account_to_validate;
    protected $track_account;
    protected $account;
    
    protected $ServiceId;
    protected $Major;

    protected $meter;
    protected $key;
    protected $password;

    public $wsdl_root_path;
    public $wsdl_path;

    public function __construct($mode = "test")
    {
        if($mode == "test")
        {
            $this->ship_account       = "510087720";
            $this->bill_account       = "XXXXXXXXX";
            $this->duty_account       = "XXXXXXXXX";
            $this->account_to_validate= "XXXXXXXXX";
            $this->track_account      = "XXXXXXXXX";
            $this->account            = "510087720";

            $this->meter    = "119155313";
            $this->key      = "3sFONZBWMdN0CkJy";
            $this->password = "uJiTuDxQN1y7Z8MrmhFeBTLa3";
            
            $this->setWSDLRoot("wsdl-test/");
        }
        else
        {
            $this->ship_account       = "XXXXXXXXX";
            $this->bill_account       = "XXXXXXXXX";
            $this->duty_account       = "XXXXXXXXX";
            $this->account_to_validate= "XXXXXXXXX";
            $this->track_account      = "XXXXXXXXX";
            $this->account            = "XXXXXXXXX";    //FEDEX Account Number

            $this->meter    = "XXXXXXXXX";      //Production Meter Number
            $this->key      = "XXXXXXXXXXXXXXXX";   //Production Key
            $this->password = "XXXXXXXXXXXXXXXXXXXXXXXX";  //Production Password
            
            $this->setWSDLRoot("wsdl-live/");
        }
    }
    
    public function setWSDLRoot($root = "wsdl/")
    {
        $this->wsdl_root_path = $root;
    }
    
    public function requestError($exception, $client) 
    {
        $str = "";
        $str .= '<h2>Fault: </h2>';
        $str .= "<b>Code:</b>{$exception->faultcode}<br>\n";
        $str .= "<b>String:</b>{$exception->faultstring}<br>\n";
        return $str;
    }
    
    public function getAuthenticationDetail()
    {
        $aryAuthentication = array(
                'UserCredential' =>array(
                        'Key' => $this->key, 
                        'Password' => $this->password
                )
        ); 
        return $aryAuthentication;
    }
    
    public function getClientDetail()
    {
        $aryClient = array(
                'AccountNumber' => $this->ship_account, 
                'MeterNumber' => $this->meter
        );
        
        return $aryClient;
    }
    
    public function getServiceVersion()
    {
        $aryVersion = array(
                'ServiceId' => $this->ServiceId, 
                'Major' => $this->Major, 
                'Intermediate' => '0', 
                'Minor' => '0'
        );
        return $aryVersion;
    }
    
    function addShippingChargesPayment()
    {
        $shippingChargesPayment = array
        (
            'PaymentType' => 'SENDER', // valid values RECIPIENT, SENDER and THIRD_PARTY
            'Payor' => array
                (
                    'AccountNumber' => $this->bill_account,
                    'CountryCode' => 'US')
        );

        return $shippingChargesPayment;
    }
    
    function addSpecialServices() 
    {
        $specialServices = array(
            'SpecialServiceTypes' => array('COD'),
            'CodDetail' => array(
                'CodCollectionAmount' => array('Currency' => 'USD', 'Amount' => 150),
                'CollectionType' => 'ANY')// ANY, GUARANTEED_FUNDS
        );
        return $specialServices;
    }
    
    public function requestType($type)
    {
        switch($type)
        {
            case "address":
                $this->wsdl_path = "AddressValidationService_v2.wsdl";
                $this->Major = 10;
                break;
            case "package":
                $this->wsdl_path = "PackageMovementInformationService_v5.wsdl";
                $this->Major = 10;
                break;
            case "close":
                $this->wsdl_path = "CloseService_v2.wsdl";
                $this->Major = 10;
                break;
            case "locator":
                $this->wsdl_path = "LocatorService_v2.wsdl";
                $this->Major = 10;
                break;
            case "pickup":
                $this->wsdl_path = "PickupService_v3.wsdl";
                $this->ServiceId = "disp";
                $this->Major = 3;
                break;
            case "rate":
                $this->wsdl_path = "RateService_v10.wsdl";
                $this->ServiceId = "crs";
                $this->Major = 10;
                break;
            case "return":
                $this->wsdl_path = "ReturnTagService_v1.wsdl";
                $this->Major = 10;
                break;
            case "shipment":
                $this->wsdl_path = "ShipService_v10.wsdl";
                $this->ServiceId = "ship";
                $this->Major = 10;
                break;
            case "track":
                $this->wsdl_path = "TrackService_v5.wsdl";
                $this->ServiceId = "trck";
                $this->Major = 5;
                break;
            case "upload":
                $this->wsdl_path = "UploadDocumentService_v1.wsdl";
                $this->Major = 10;
                break;
            default:
                $this->wsdl_path = "";
                $this->Major = 10;
                break;
        }
    }
    
    function setEndpoint($var)
    {
        if($var == 'changeEndpoint') 
            return false;

        if($var == 'endpoint') 
            return '';
    }
    
        
    public function addShipper()
    {
        $shipper = array
        (
            'Contact' => array
                (
                    'PersonName' => 'Person Name',
                    'CompanyName' => 'Company Name',
                    'PhoneNumber' => '111-000-1111'
                ),
                'Address' => array
                (
                    'StreetLines' => array
                        (
                            '1202 Chalet Ln'
                            
                        ),
                    'City' => 'Harrison',
                    'StateOrProvinceCode' => 'AR',
                    'PostalCode' => '72601',
                    'CountryCode' => 'US'
                )
           );

        return $shipper;
    }
    
    public function showResponseMessage($response)
    {
        if(isset($response->Notifications->Message))
            return $response->Notifications->Message;
        else
            return $response->Notifications[0]->Message;
    }
    
    public function getServiceTypeName($service_type)
    {
        $s_type = "";
        if(trim($service_type) == "")
            return false;
        switch($service_type)
        {
            case "INTERNATIONAL_ECONOMY":
                $s_type = "International Economy";
                break;
            case "INTERNATIONAL_PRIORITY":
                $s_type = "International Priority";
                break;
            case "EUROPE_FIRST_INTERNATIONAL_PRIORITY":
                $s_type = "International Priority (Europe First)";
                break;
            case "INTERNATIONAL_FIRST":
                $s_type = "International First";
                break;
            default:
                $s_type = "";
        }
        return $s_type;
    }
    
}
?>