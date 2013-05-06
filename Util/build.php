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
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * 
	 * @param string $file
	 * @return string
	 */
	public static function loadTpl( $file = '' )
	{
		if ( !defined('PINKCOW_UTIL_TEMPLATE_PATH') )
		{
			$content = gettext('You need to define PINKCOW_UTIL_TEMPLATE_PATH in your config file.');
		}
		else
		{
			$url = PINKCOW_UTIL_TEMPLATE_PATH;
		
			if ( file_exists( $url . $file ) )
			{
				$tpl = file_get_contents( $url . $file );
				$tpl = str_replace( '<?php' , '' , $tpl );
				$tpl = str_replace( '?>' , '' , $tpl );
				$content = eval( $tpl );
			}
			else
			{
				$content = gettext('The file you are trying to load does not exist<br /><i>Path: '. $url . $file .'</i>' );
			}
		}
		
		return $content;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.4
	 * @version 1.0.0.4
	 * 
	 * @param string $modul
	 * @return void
	 */
	public static function replace($tag, $content, $tpl)
	{
		$tpl = str_replace('{%'. $tag .'%}', $content, $tpl);
		
		return $tpl;
	}
}
?>