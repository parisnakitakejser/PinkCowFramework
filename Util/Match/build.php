<?php
namespace PinkCow\Util;

class Match
{
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.3
	 * @version 1.0.0.3
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
	 * @param string $tag
	 * @param string $content
	 * @return void
	 */
	public static function matchAll( $tag , $content )
	{
		preg_match_all("/\[". $tag ."](.+?)\[\/". $tag ."]/s", $content , $match );
		return $match;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.3
	 * @version 1.0.0.3
	 * 
	 * @param string $tag
	 * @param string $content
	 * @return void
	 */
	public static function removeAllMatch( $tag, $content )
	{
		$match = self::matchAll( $tag, $content );
		
		$tpl = $content;
		if ( count( $match[0] ) > 0 )
		{
			foreach( $match[0] AS $key => $val )
			{
				$tpl = str_replace($match[0][$key], '', $tpl);
			}
		}
		
		return $tpl;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.3
	 * @version 1.0.0.3
	 * 
	 * @param string $tag
	 * @param string $content
	 * @return void
	 */
	public static function keepAllMatch($tag, $content)
	{
		$match = self::matchAll( $tag, $content );
		
		$tpl = $content;
		if ( count( $match[0] ) > 0 )
		{
			foreach( $match[0] AS $key => $val )
			{
				$tpl = str_replace($match[0][$key], $match[1][$key], $tpl);
			}
		}
		
		return $tpl;
	}

}
?>