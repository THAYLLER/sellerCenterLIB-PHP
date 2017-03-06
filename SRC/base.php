<?php
/**
* @author Thayller Vilela Cintra <thayller@pxw.com.br>
* @copyright Thayller Vilela Cintra © 2017
* @version 0.0.2
*
*/
namespace src;

require_once "config/config.php";
//require_once "config/error.php";

abstract class base
{
	protected $currentDate;
	protected $action;
	protected $parameters;
	protected $encoded;
	protected $idUser;
	protected $api_key;
	protected $api_url;
	protected $url;
	protected $ch;
	protected $data;
        protected $concatenated;
	protected $retorno;
	protected $status;

	function start() 
	{
   		$this->currentDate = date('h:i:s');
   		$this->action = '';
   		$this->status = ['pending', 'canceled', 'ready_to_ship', 'delivered', 'returned', 'shipped','failed'];
		$this->parameters = array('UserID' => '','Version' => '1.0','Action' => '','Format' => 'XML','Timestamp' => '');
   		$this->encoded = array();
   		$this->idUser = SC_API_USER;
        $this->api_key = SC_API_KEY; 
        $this->api_url = SC_API_URL; 
   		$this->url = '';
   		$this->ch = curl_init();
   		$this->data = array();
   		$this->concatenated = '';

   		//$errors = new error();
	}
    public function actionSet($action)
    {
        $this->action = $action;
    }
    public function actionGet()
    {
        return $this->action;
    }
    public function CreatedAfterSet($dt)
    {
        $this->parameters['CreatedAfter'] = $this->formatDate($dt);
    }
    public function CreatedBeforeSet($dt)
    {
        $this->parameters['CreatedBefore'] = $this->formatDate($dt);
    }
    public function OffsetSet($Offset)
    {
        $this->parameters['Offset'] = $Offset;
    }
    public function statusSet($i)
    {
        $this->parameters['Status'] = $this->status[$i];
    }
    public function limitsSet($i)
    {
        $this->parameters['Limit'] = $i;
    }
    public function OrderIdSet(array $OrderId)
    {
        $this->parameters['OrderId'] = (string)$OrderId;
    }
    public function OrderItemIdsdSet(array $OrderItemIds)
    {
        $this->parameters['OrderItemIds'] = $OrderItemIds;
    }
    public function ReasonSet($Reason)
    {
        $this->parameters['Reason'] = $Reason;
    }
    public function ReasonDetailSet($ReasonDetail)
    {
        $this->parameters['ReasonDetail'] = $ReasonDetail;
    }
    public function DeliveryTypeSet($DeliveryType)
    {
        $this->parameters['DeliveryType'] = $DeliveryType;
    }
    public function ShippingProviderSet($ShippingProvider)
    {
        $this->parameters['ShippingProvider'] = $ShippingProvider;
    }
    public function TrackingNumberSet($TrackingNumber)
    {
        $this->parameters['TrackingNumber'] = $TrackingNumber;
    }
    public function categorySet($category)
    {
        $this->parameters['PrimaryCategory'] = $category;
    }
     public function SerialNumberSet($SerialNumber)
    {
        $this->parameters['SerialNumber'] = $SerialNumber;
    }
     public function AccessKeySet($AccessKey)
    {
        $this->parameters['AccessKey'] = $AccessKey;
    }
    public function formatDate($dt = "Y-m-d H:i:s")
    {
         $this->currentDate = new \DateTime(date($dt)); 
         $this->currentDate = $this->currentDate->format(\DateTime::ISO8601);

         return $this->currentDate;
    }
    public function toChargeParameters()
    {
        $this->parameters['UserID'] = $this->idUser;
        $this->parameters['Action'] = $this->action;
        $this->parameters['Timestamp'] = $this->currentDate;

        ksort($this->parameters);

        foreach ( $this->parameters as $name => $value ) 
        {
            $this->encoded[] = rawurlencode((string)$name) . '=' . rawurlencode($value);
        }
        $this->concatenated = implode('&', str_replace('%20','',$this->encoded));

        $this->parameters['Signature'] = rawurlencode(hash_hmac('sha256', $this->concatenated, $this->api_key, false));
    }
    public function url()
    {
        $this->url = $this->api_url.$this->concatenated.'&Signature='.$this->parameters['Signature'];
    }
    public function callApi($metodo, array $xml)
    {
    	if(count($xml) != 0)
    	{
	        for ($i=0; $i < count($xml); $i++) 
	        { 
	            curl_setopt($this->ch, CURLOPT_URL, $this->url);
	            curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION,1);
	            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
	            if($metodo == 'post')
	            	curl_setopt($this->ch, CURLOPT_POSTFIELDS, $xml[$i]);
	            $this->data[] = curl_exec($this->ch);
	            curl_close($this->ch);
	        }
	        return $this->data;
	    }
	    else
	    {
	    	//return $errors->message(000);
	    }
    }
}

