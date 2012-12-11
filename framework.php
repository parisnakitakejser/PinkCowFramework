<?php
class PinkCow
{
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
	public static function import( $framework = '' )
	{
		$explode = explode( '.', $framework );
		$importUrl = self::$frameworkPath . implode( '/', $explode ) .'/build.php';
		
		require_once( $importUrl );
	}
}
?>