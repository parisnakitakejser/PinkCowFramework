<?php
namespace PinkCow\Maps;

class Geocoding
{
	private static $sensor = 'false';
	private static $apiUrl = 'http://maps.googleapis.com/maps/api/geocode/json?';
	
	public $street = '';
	public $zipcode = '';
	public $country = '';
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 *
	 * @return void
	 */
	public function __construct()
	{
		
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 *
	 * @return string
	 */
	private function _buildUrl()
	{
		$url = self::$apiUrl . urlencode( self::$street ) .','. self::$zipcode .','. self::$country .'&sensor='. self::$sensor;
	}
}
?>