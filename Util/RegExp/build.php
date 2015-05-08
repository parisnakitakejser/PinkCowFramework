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
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 *
	 * @param $url string
	 * @return string
	 */
	public static function isEmailValid( $email )
	{
		return preg_match("/^[_a-z0-9-]+((\+|\.)[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i", $email);
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * 
	 * @param string $type
	 * @return boolean
	 */
	public static function checkUserAgent($type = NULL ) 
	{
		$user_agent = strtolower ( $_SERVER['HTTP_USER_AGENT'] );
		
		if ( $type == 'bot' )
		{
			// matches popular bots
			if ( preg_match ( "/googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent ) )
			{
				return true;
				// watchmouse|pingdom\.com are "uptime services"
			}
		} 
		elseif ( $type == 'browser' ) 
		{
			// matches core browser types
			if ( preg_match ( "/mozilla\/|opera\//", $user_agent ) ) 
			{
				return true;
			}
		} 
		elseif ( $type == 'mobile' ) 
		{
			// matches popular mobile devices that have small screens and/or touch inputs
			// mobile devices have regional trends; some of these will have varying popularity in Europe, Asia, and America
			// detailed demographics are unknown, and South America, the Pacific Islands, and Africa trends might not be represented, here
			if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) 
			{
				// these are the most common
				return true;
			} 
			elseif ( preg_match ( "/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent ) ) 
			{
				// these are less common, and might not be worth checking
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * 
	 * @param string $string
	 * @return string
	 */
	public static function regexSafe($string)
	{
		return addcslashes($string, '\\/.()[]^\$+');
	}
	
	/**
		* @author Paris Nakita Kejser
		* @since 1.1.0.0
		* @version 1.1.0.0
		* 
		* @param string $title
		* @param boolean $toLower
		* @param boolean $ignoreDots
		* @return string
		*/
		public static function convertUrl( $title, $toLower = true, $ignoreDots = false )
		{
			if ( $toLower === true )
			{
				$title = strtolower( $title );
			}
		
			if ( $ignoreDots == true )
			{
				$finalStr = trim(preg_replace(array('~[^0-9a-z.]~i', '~-+~'), '-', preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($title, ENT_QUOTES, 'UTF-8'))), '-');
			}
			else
			{
				$finalStr = trim(preg_replace(array('~[^0-9a-z]~i', '~-+~'), '-', preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($title, ENT_QUOTES, 'UTF-8'))), '-');
			}
			
			return $finalStr;
		}
}
?>
