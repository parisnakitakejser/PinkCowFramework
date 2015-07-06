<?php
namespace PinkCow\Util;

class Encode
{
	public static function win1252ToUtf8($string) {
		return iconv('windows-1252', 'UTF-8', $string);
	}
	
	public static function ibm850ToUtf8($string) {
		return iconv('IBM850', 'UTF-8', $string);
	}
}
?>
