<?php
namespace PinkCow;

class Arrays
{
	/**
	 * @since 1.0.0.1
	 * @version 1.0.0.1
	 *
	 * @param array $array
	 * @param string $key
	 * @param boolean $asc
	 * @param boolean $resortKey
	 *
	 * @return true
	 */
	public static function sortByOneKey(array $array, $key, $asc = true, $resortKey = true) 
	{
		$result = array();
		$resultArray = array();
		$values = array();
		
		foreach ($array as $id => $value) 
		{
			$values[$id] = isset( $value[$key] ) ? $value[$key] : '';
		}
		
		if ($asc) 
			asort($values);
		else 
			arsort($values);
		
		foreach ($values as $key => $value) 
		{
			$result[$key] = $array[$key];
		}
		
		if ( $resortKey == true )
		{
			foreach( $result AS $val )
			{
				array_push( $resultArray, $val);
			}
		}
		else
		{
			$resultArray = $result;
		}
		
	    return $resultArray;
	}
}
?>