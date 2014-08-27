<?php
namespace Gateway;

/**
 * @author Paris Nakita Kejser
 * @since 1.0.1.1
 * @version 1.0.1.1
 * 
 * @example Show more info about ePay payment gateway here: DK: http://tech.epay.dk/da/betalingswebservice / EN: http://tech.epay.dk/en/payment-web-service
 */
class ePay
{
	public $merchantnumber = '';
	public $transactionid = '';
	public $amount = '';
	public $group = '';
	public $orderid = '';
	public $instantcapture = 0;
	public $fraud = 0;
	public $currency = 208; // 208 = DKK
	
	// public $pbsResponse = '';
	// public $epayresponse = '';
	
	public function __construct()
	{
		$this->wsdl = new \SoapClient('https://ssl.ditonlinebetalingssystem.dk/remote/payment.asmx?WSDL');
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.1.1
	 * @version 1.0.1.1
	 * @access public
	 * 
	 * @return json
	 */
	public function capture()
	{
		$epay_params = array(
			'merchantnumber' => $this->merchantnumber,
			'transactionid' => $this->transactionid,
			'amount' => $this->amount,
			'group' => $this->group,
			'pbsResponse' => '-1',
			'epayresponse' => '-1'
		);
		
		$result = $this->wsdl->capture($epay_params); 
		
		if( $result->captureResult == true )
		{ 
			//Capture OK 
			return json_encode( $result );
		} 
		else 
		{ 
			//Error - see pbsResponse and epayresponse
			return json_encode( $result );
		} 
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.1.1
	 * @version 1.0.1.1
	 * @access public
	 * 
	 * @return json
	 */
	public function authoriz()
	{
		$this->wsdl = new \SoapClient('https://ssl.ditonlinebetalingssystem.dk/remote/subscription.asmx?WSDL');
		
		if ( $this->orderid == '' )
		{
			$this->orderid = md5( time() . uniqid() );
		}
		
		$epay_params = array(
			'merchantnumber' => $this->merchantnumber,
			'subscriptionid' => $this->subscriptionid,
			'orderid' => $this->orderid,
			'amount' => $this->amount,
			'currency' => $this->currency,
			'instantcapture' => $this->instantcapture,
			'fraud' => 0,
			'transactionid' => '-1',
			'pbsresponse' => '-1',
			'epayresponse' => '-1'
		);
		
		$result = $this->wsdl->authorize($epay_params); 
		
		if( $result->authorizeResult == true )
		{ 
			//Authorize OK 
			return json_encode( $result );
		} 
		else 
		{ 
			//Error - see pbsResponse and epayresponse
			return json_encode( $result );
		} 
	}
	
	public function renew()
	{
	}
	
	public function credit()
	{
		
	}
	
	public function delete()
	{
		
	}
	
	public function getEpayError()
	{
		
	}
	
	public function getPbsError()
	{
		
	}
	
	public function getcardtype()
	{
		
	}
	
	public function gettransaction()
	{
		
	}
	
	public function gettransactionlist()
	{
		
	}
	
	public function getcardinfo()
	{
		
	}
}
?>