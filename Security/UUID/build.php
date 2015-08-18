<?php
namespace PinkCow\Security;

class UUID
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
	public static function generate()
	{
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.1.0.1
	 * @version 1.1.0.1
	 * 
	 * @param string $binary
	 * @return string
	 */
	public static function uuidFromBin($binary) {
		$str = bin2hex($binary);
		
		return (
			substr($str,8,8).'-'.
			substr($str,4,4).'-'.
			substr($str,0,4).'-'.
			substr($str,16,4).'-'.
			substr($str,20)
		); 
	}
	
	public static function uuidToBin($string) {
		$uuidToBin = str_replace('-','',$string);
		$uuidIn = (
			substr($uuidToBin,12,4) .
			substr($uuidToBin,8,4) .
			substr($uuidToBin,0,8) .
			substr($uuidToBin,16,4) .
			substr($uuidToBin,20)
		);
		return pack("H*",$uuidIn);
	}
}
?>