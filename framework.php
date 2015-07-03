<?php
class PinkCow
{
	public static $debug = false;
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.2
	 * @version 1.1.0.1
	 * 
	 * @var string
	 */
	public static $version = '1.1.0.1';
	
	public static $frameworkPath = '';
	
	public function __construct()
	{
	}
	
	/**
	 * @since 1.0.0.1
	 * @version 1.0.0.1
	 * 
	 * @param string $framework
	 * @return void
	 */
	public static function import( $framework = '' ) {
		$explode = explode( '.', $framework );
		$importUrl = self::$frameworkPath . implode( '/', $explode ) .'/build.php';
		
		require_once( $importUrl );
	}
	
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.1.0.1
	 * @version 1.1.0.1
	 * 
	 * @param string $value
	 * @return string
	 */
	public static function debug($value) {
		if (\PinkCow::$debug == true) {
			echo $value ."\n";
		}
	}
}
?>