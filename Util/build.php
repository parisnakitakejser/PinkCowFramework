<?php
namespace PinkCow;

class Util
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
	 * @since 1.0.0.3
	 * @version 1.0.0.3
	 * 
	 * @param string $modul
	 * @return void
	 */
	public static function import( $modul )
	{
		$exportModul = explode( '.', $modul );
		require_once( PCF_CFG_FRAMEWORK_PATH . implode('/', $exportModul ) .'/ns.php' );
	}
	
	public static function replace($tag, $content, $tpl)
	{
		$tpl = str_replace('{%'. $tag .'%}', $content, $tpl);
		
		return $tpl;
	}
}
?>