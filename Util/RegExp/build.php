<?php
namespace PinkCow\Util;

class RegExp
{
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 *
	 * @param $url string
	 * @return string
	 */
	public static function addHttp( $url )
	{
		if ( !preg_match("~^(?:f|ht)tps?://~i", $url) )
		{
			$url = "http://" . $url;
		}
		
		return $url;
	}
}
?>
