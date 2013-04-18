<?php
namespace PinkCow;

class MVC
{
	private static $_metaTitle = '';
	
	public static $template = '';
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * 
	 * @param string $metaTitle
	 * @return string
	 */
	public static function setMetaTitle( $metaTitle = '' )
	{
		self::$_metaTitle = $metaTitle;
	}
	
	public static function application()
	{
		$mainTpl = util::loadTpl( 'main.php' );
	
		if ( !isset( $_GET['modul'] ) || $_GET['modul'] == '' )
		{
			require_once( CONTROLLER_PATH .'dashboard/defualt.php' );
			$dashboard = new dashboard();
		
			$mainTpl = util::replace('JS_BOTTOM', ( method_exists( $dashboard, 'JavascriptBottom' ) == 1 ? $dashboard->JavascriptBottom() : '' ), $mainTpl);
			$mainTpl = util::replace('PLACEHOLDER',$dashboard->Build(),$mainTpl);
		}
		else
		{
			$methodName = ( !isset( $_GET['method'] ) ? 'defualt' : $_GET['method'] );
		
			if ( file_exists( CONTROLLER_PATH . $_GET['modul'] .'/'. $methodName .'.php' ) )
			{
				require_once( CONTROLLER_PATH . $_GET['modul'] .'/'. $methodName .'.php' );
				$error = 0;
			}
			else
			{
				$error = 1;
			}
		
			if ( $error == 0 )
			{
				$cls = new $_GET['modul']();
				$cls->method = ( isset( $_GET['modul'] ) ? $_GET['modul'] : '' );
				
				$mainTpl = util::replace('JS_BOTTOM', ( method_exists( $cls, 'JavascriptBottom' ) == 1 ? $cls->JavascriptBottom() : '' ), $mainTpl);
				$mainTpl = util::replace('PLACEHOLDER', $cls->Build(), $mainTpl);
				$mainTpl = util::replace('META_TITLE', $cls->MetaTitle(), $mainTpl);
			}
			else
			{
				#$template->replace( 'BREADCRUMB' , gettext( 'ERROR!!!' ) );
				$mainTpl = util::replace('PLACEHOLDER', util::loadTpl('Error/none.controller.load.php'), $mainTpl);
			}
			// End dynmaisk class inloader.
		}

		echo $mainTpl;
	}
}
?>