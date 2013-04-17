<?php
namespace PinkCow\Util;

/**
 * This modul are for https://www.flowdock.com
 *
 * Its created from a author persons blog post there have inspired me Lasse Hassing (http://hassing.org) Thanks to him.
 */
class Flowdock
{
	private static $url     = 'https://api.flowdock.com/v1/messages/team_inbox/';
	public static $token   = 'api-token-here';
	public static $source  = 'app-name';
	public static $email   = 'from@address.com';
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.5
	 * @version 1.0.0.5
	 *
	 * @param string $name
	 * @param string $subject
	 * @param string $content
	 * @param array $tags
	 * @return void
	 */
	public static function TeamInbox($name, $subject, $content, $tags=array())
	{
		$data = array(
			'source' => self::$source,
			'from_address' => self::$email,
			'from_name' => $name,
			'subject' => $subject,
			'content' => $content,
			'tags' => $tags
		);
		
		$data_string = json_encode($data);
		
		$ch = curl_init(self::$url.self::$token);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string))
		);
		
		$result = curl_exec($ch);
    }
}
?>