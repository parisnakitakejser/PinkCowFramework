<?php
namespace PinkCow\Util;

class Encode
{
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.1.0.0
	 * @version 1.1.0.0
	 * @access public
	 * 
	 * @param string $string
	 * @return string
	 */
	public static function win1252ToUtf8($string) {
		return iconv('windows-1252', 'UTF-8', $string);
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.1.0.0
	 * @version 1.1.0.0
	 * @access public
	 * 
	 * @param string $string
	 * @return string
	 */
	public static function ibm850ToUtf8($string) {
		return iconv('IBM850', 'UTF-8', $string);
	}
}
?>
