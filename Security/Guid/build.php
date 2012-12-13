<?php
namespace PinkCow\Security;

class Guid
{
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.1
	 * @version 1.0.0.1
	 * 
	 * @return void
	 */
	public function __construct()
	{
		
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.1
	 * @version 1.0.0.1
	 * 
	 * @return string
	 */
	public function Generate()
	{
		$s = strtoupper( md5( uniqid( rand() , true ) ) ); 
		
		$guidText = 
			substr($s,0,8) . '-' . 
			substr($s,8,4) . '-' . 
			substr($s,12,4). '-' . 
			substr($s,16,4). '-' . 
			substr($s,20); 

		return $guidText;
	}
}
?>