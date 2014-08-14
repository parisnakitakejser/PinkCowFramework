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
	// public $pbsResponse = '';
	// public $epayresponse = '';
	
	public function __construct()
	{
		$this->wsdl = new SoapClient('https://ssl.ditonlinebetalingssystem.dk/remote/payment.asmx?WSDL');
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.1.1
	 * @version 1.0.1.1
	 * @access public
	 * 
	 * @return 
	 */
	public function capture()
	{
		$epay_params = array(
			'merchantnumber' => $this->merchantnumber,
			'transactionid' => $this->transactionid,
			'amount' => $this->amount,
			'pbsResponse' => '-1',
			'epayresponse' => '-1'
		);
		
		$result = $this->wsdl->capture($epay_params); 
		
		if( $result->captureResult == true )
		{ 
			//Capture OK 
		} 
		else 
		{ 
			//Error - see pbsResponse and epayresponse 
		} 
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