<?php
namespace PinkCow\Util;

class Html
{
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * @access public
	 *
	 * @param array $array
	 * @param string $name
	 * @param string $id
	 * @param string $selected
	 * @param string $class
	 * @return string
	 */
	public static function buildSelect($array = array(), $name = '', $id = '', $selected = '', $class = '')
	{
		$contect = '<select'. ( $name != '' ? ' name="'. $name .'"' : '' ) .''. ( $id != '' ? ' id="'. $id .'"' : '' ) .''. ( $class != '' ? ' class="'. $class .'"' : '' ) .'>';
		
		if ( count( $array ) > 0 )
		{
			foreach( $array AS $key => $val )
			{
				$contect .= '<option value="'. $key .'"'. ( $key == $selected ? ' selected' : '' ) .'>'. $val .'</option>';
			}
		}
		else
		{
			$contect .= '<option>{missing:array}</option>';
		}
		
		$contect .= '</select>';
		
		return $contect;
	}
}
?>