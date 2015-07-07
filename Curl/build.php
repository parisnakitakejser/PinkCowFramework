<?php
namespace PinkCow;

class Curl {
	const CURLOPT_CONNECTTIMEOUT = 5;
	const CURLOPT_HEADER = false;
	const CURLOPT_RETURNTRANSFER = true;
	
	private
		$_thread = [],
		$_nodes = [];
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.1.0.0
	 * @version 1.1.0.0
	 * @access public
	 * 
	 * @param string $url
	 * @param boolean $standalone
	 * @return object
	 */
	public function init($url,$standalone=true) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, self::CURLOPT_RETURNTRANSFER);
		curl_setopt($curl, CURLOPT_HEADER, self::CURLOPT_HEADER);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, self::CURLOPT_CONNECTTIMEOUT);
		
		if($standalone !== true) {
			return $curl;
		} else {
			curl_exec($curl);
			$info = curl_getinfo($curl);

			if(!curl_errno($curl)) {
				if ($info['http_code'] == 200){
					return $curl;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.1.0.0
	 * @version 1.1.0.0
	 * @access public
	 * 
	 * @param array $urls
	 * @param array $option
	 * @return object
	 */
	public function multiple_threads_request(array $urls=[],array $option = []) {
		$mh = curl_multi_init();
		
		if(count($urls) > 0) {
			foreach($urls AS $key => $val) {
				$this->_thread[$key] = $this->init($val['url'],false);
				if ($this->_thread[$key] !== false) {
					curl_multi_add_handle($mh,$this->_thread[$key]);
				}
			}
			
			$running = NULL;
			do { 
				curl_multi_exec($mh,$running);
			} while($running > 0); 
			
			
			foreach($urls AS $key => $url) {
				if ($this->_thread[$key] !== false) {
					$this->_nodes[$key] = curl_multi_getcontent($this->_thread[$key]);
					curl_multi_remove_handle($mh, $this->_thread[$key]);
					
					if (isset($option['save']) && $option['save'] === true) {
						if(isset($url['save_path']) && $url['save_path'] != '') {
							$this->_save_thread_content($key, $url['save_path']);
						} else {
							// send error out.
						}
					}
					
					if(isset($url['callback'])) {
						call_user_func($url['callback'][0],$url['callback'][1]);
					}
				}
			}
			
			curl_multi_close($mh);
		} else {
			// send a error out
		}
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.1.0.0
	 * @version 1.1.0.0
	 * @access private
	 * 
	 * @param int $node_key
	 * @param string $save_path
	 * @return void
	 */
	private function _save_thread_content($node_key, $save_path) {
		$handle = fopen($save_path, "w");
		fwrite($handle, $this->_nodes[$node_key]);
		fclose($handle);
		
		unset($this->_nodes[$node_key]);
	}
}
?>