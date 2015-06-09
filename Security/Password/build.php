<?php
namespace PinkCow\Security;

class Password {
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.0
	 * @version 1.0.0.0
	 * @access public
	 * 
	 * @param int $length
	 * @param int $strength
	 * @return string
	 */
	public static function autoGen($length=8, $strength=0) 
	{
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}

		$password = '';
		
		$alt = time() % 2;
		
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		
		return $password;
	}
}
?>