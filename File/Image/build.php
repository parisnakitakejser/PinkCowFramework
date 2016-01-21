<?php
namespace PinkCow\File;

class Image {
	private
		$_filePath = null,
		$_fileDist = null,
		$_imageObj = null,
		$_mimeType = null,
		$_compression = 80,
		$_permissions = null,
		$_imageWidth = null,
		$_imageHeight = null,
		$_imageNewWidth = null,
		$_imageNewHeight = null,
		$_imageResizedWidth = null,
		$_imageResizedHeight = null,
		$_positionX = 0,
		$_positionY = 0;

	public static $debug = false;

	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.0
	 * @version 1.0.0.0
	 * @access public
	 *
	 * @param string $filePath
	 * @return void
	 */
	public function __construct($filePath = null) {
		$this->_filePath = $filePath;

		$image_info = getimagesize($this->_filePath);
		$this->_mimeType = $image_info[2];

		$this->_createImageObj();
	}

	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.0
	 * @version 1.0.0.0
	 * @access private
	 *
	 * @return void
	 */
	private function _debug() {
		if($this->_debug === true) {

		}
	}

	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.0
	 * @version 1.0.0.0
	 * @access public
	 *
	 * @return int
	 */
	public function getWidth() {
		return imagesx($this->_imageObj);
	}

	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.0
	 * @version 1.0.0.0
	 * @access public
	 *
	 * @return int
	 */
	public function getHeight() {
		return imagesy($this->_imageObj);
	}

	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.0
	 * @version 1.0.0.0
	 * @access private
	 *
	 * @return void
	 */
	private function _createImageObj() {
		if( $this->_mimeType == IMAGETYPE_JPEG ) {
			$this->_imageObj = imagecreatefromjpeg($this->_filePath);
		} elseif( $this->_mimeType == IMAGETYPE_GIF ) {
			$this->_imageObj = imagecreatefromgif($this->_filePath);
		} elseif( $this->_mimeType == IMAGETYPE_PNG ) {
			$this->_imageObj = imagecreatefrompng($this->_filePath);
		}
	}

	private function _resizeAlgoritme() {
		if ( $this->_imageWidth > $this->_imageNewWidth ) {
			$ratio = $this->_imageNewWidth / $this->_imageWidth;
			$this->_imageResizedWidth = round($this->_imageWidth * $ratio);
			$this->_imageResizedHeight = round($this->_imageHeight * $ratio);

			if(self::$debug === true) {
				echo "# Change rezied size:\n";
				echo "Ratio: ". $ratio ."\n";
				echo "Width: ". $this->_imageWidth ." => ". $this->_imageResizedWidth ."\n";
				echo "Height: ". $this->_imageHeight ." => ". $this->_imageResizedHeight ."\n";
				echo "\n";
			}

		} else {
			$this->_imageResizedWidth = $this->_imageWidth;
			$this->_imageResizedHeight = $this->_imageHeight;
		}

		if ($this->_imageResizedHeight > $this->_imageNewHeight) {
			$tmpW = $this->_imageResizedWidth;
			$tmpH = $this->_imageResizedHeight;

			$ratio = $this->_imageNewHeight / $this->_imageResizedHeight;
			$this->_imageResizedWidth = round($this->_imageResizedWidth * $ratio);
			$this->_imageResizedHeight = $this->_imageNewHeight;

			if(self::$debug === true) {
				echo "# Change rezied size:\n";
				echo "Ratio: ". $ratio ."\n";
				echo "Width: ". $tmpW ." => ". $this->_imageResizedWidth ."\n";
				echo "Height: ". $tmpH ." => ". $this->_imageResizedHeight ."\n";
				echo "\n";
			}
		}

		if ($this->_imageResizedWidth < $this->_imageNewWidth ) {
			$this->_positionX = round(($this->_imageNewWidth - $this->_imageResizedWidth) / 2 );

			if(self::$debug === true) {
				echo "# Change position:\n";
				echo "Position-X: ". $this->_positionX ."\n";
				echo "\n";
			}
		}

		if ($this->_imageResizedHeight < $this->_imageNewHeight ) {
			$this->_positionY = round(($this->_imageNewHeight - $this->_imageResizedHeight) / 2 );

			if(self::$debug === true) {
				echo "# Change position:\n";
				echo "Position-Y: ". $this->_positionY ."\n";
				echo "\n";
			}
		}
	}

	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.0
	 * @version 1.0.0.0
	 * @access public
	 *
	 * @param int $width
	 * @param int $height
	 * @return void
	 */
	public function resize($width=null,$height=null) {

		$this->_imageWidth = $this->getWidth();
		$this->_imageHeight = $this->getHeight();
		$this->_imageNewHeight = $height;
		$this->_imageNewWidth = $width;

		$targetImageIdentifier=imagecreatetruecolor($this->_imageNewWidth,$this->_imageNewHeight);
		$bgcolor = imagecolorallocate($targetImageIdentifier, 255, 255, 255);
		imagefill($targetImageIdentifier, 0, 0, $bgcolor);

		if(self::$debug === true) {
			echo "Org. width: ". $this->_imageWidth ."\n";
			echo "New. width: ". $this->_imageNewWidth ."\n";
			echo "Org. height: ". $this->_imageHeight ."\n";
			echo "New. height: ". $this->_imageNewHeight ."\n";
		}

		$positionX = 0;
		$positionY = 0;


		if($this->_imageWidth < $this->_imageNewWidth && $this->_imageHeight < $this->_imageNewHeight) {

			if($this->_imageWidth < $this->_imageNewWidth ) {
				$positionX = ceil( ( $this->_imageNewWidth - $this->_imageWidth ) / 2 );
			}

			if($this->_imageHeight < $this->_imageNewHeight ) {
				$positionY = ceil( ( $this->_imageNewHeight - $this->_imageHeight ) / 2 );
			}

			imagecopy($targetImageIdentifier,$this->_imageObj,$positionX,$positionY,0,0,$this->_imageWidth,$this->_imageHeight);
		}
		else {
			if(self::$debug === true) {
				echo "# - Orgianl image is larger then output images size - #\n";
				echo "\n";
			}

			$this->_resizeAlgoritme();

			imagecopyresampled($targetImageIdentifier, $this->_imageObj,$this->_positionX,$this->_positionY,0,0,$this->_imageResizedWidth,$this->_imageResizedHeight,$this->_imageWidth, $this->_imageHeight);
		}

		if(self::$debug === true) {
			echo "\n";
		}

		$this->_imageObj = $targetImageIdentifier;
	}

	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.0
	 * @version 1.0.0.0
	 * @access public
	 *
	 * @param string $fileDist,
	 * @param string $format
	 * @return void
	 */
	public function save($fileDist=null,$format='jpg') {
		$this->_fileDist = $fileDist;

		if($format== 'jpg') {
			imagejpeg($this->_imageObj,$this->_fileDist,$this->_compression);
		} elseif( $format == 'gif') {
			imagegif($this->_imageObj,$this->_fileDist);
		} elseif($format == 'png') {
			imagepng($this->_imageObj,$this->_fileDist);
		} else {
			// nothing to do! - images will not be saved
		}

		if($this->_permissions != null) {
			chmod($fileDist,$this->_permissions);
		}
	}
}
?>
