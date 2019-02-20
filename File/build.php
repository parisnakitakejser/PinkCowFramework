<?php
namespace PinkCow;

class File
{
	public $path = '';
	public $type = 'none';
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.6
	 * @version 1.0.0.6
	 * @access public
	 *
	 * @var array
	 */
	public static $errorHandler = array();
	
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
	 * @since 1.0.0.1
	 * @version 1.0.0.1
	 *
	 * @return array
	 */
	public function type()
	{
		$content = array(
			'mime-type' => $this->type,
			'file-type' => '',
			'file-classification' => gettext('none'),
			'primary-association' => gettext('none'),
		);
		
		switch( $this->type )
		{
			// .png
			case 'image/png':
			case 'application/png':
			case 'application/x-png':
				$content['file-classification'] = 'Graphic';
				$content['primary-association'] = 'PNG';
				break;
				
			// .jpg
			case 'image/jpeg':
			case 'image/jpg':
			case 'image/jp_':
			case 'application/jpg':
			case 'application/x-jpg':
			case 'image/pjpeg':
			case 'image/vnd.swiftview-jpeg':
			case 'image/x-xbitmap':
				$content['file-classification'] = 'Graphic';
				$content['primary-association'] = 'JPG';
				break;
			
			// .gif
			case 'image/gif':
			case 'image/x-xbitmap':
			case 'image/gi_':
				$content['file-classification'] = 'Graphic';
				$content['primary-association'] = 'GIF';
				break;
			
			// .bmp
			case 'image/bmp':
			case 'image/x-bmp':
			case 'image/x-bitmap':
			case 'image/x-xbitmap':
			case 'image/x-win-bitmap':
			case 'image/x-windows-bmp':
			case 'image/ms-bmp':
			case 'image/x-ms-bmp':
			case 'application/bmp':
			case 'application/x-bmp':
			case 'application/x-win-bitmap':
				$content['file-classification'] = 'Graphic';
				$content['primary-association'] = 'BMP';
				break;
			
			// .pdf
			case 'application/pdf':
			case 'application/x-pdf':
			case 'application/acrobat':
			case 'applications/vnd.pdf':
			case 'text/pdf':
			case 'text/x-pdf':
				$content['file-classification'] = 'PDF';
				$content['primary-association'] = 'PDF';
				break;
				
			// .php
			case 'text/php':
			case 'application/x-httpd-php':
			case 'application/php':
			case 'magnus-internal/shellcgi':
			case 'application/x-php':
				$content['file-classification'] = 'Source Code';
				$content['primary-association'] = 'PHP';
				break;
				
			// .doc & .docx
			case 'application/msword':
			case 'application/doc':
			case 'appl/text':
			case 'application/vnd.msword':
			case 'application/vnd.ms-word':
			case 'application/winword':
			case 'application/word':
			case 'application/x-msw6':
			case 'application/x-msword':
			case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document': # .docx
				$content['file-classification'] = 'Document';
				$content['primary-association'] = 'Word';
				break;
			
			// .txt
			case 'text/plain':
			case 'application/txt':
			case 'browser/internal':
			case 'text/anytext':
			case 'widetext/plain':
			case 'widetext/paragraph':
				$content['file-classification'] = 'Text';
				$content['primary-association'] = 'Text File';
				break;
				
			// .zip, .tar.gz
			case 'application/zip':
			case 'application/x-zip':
			case 'application/x-zip-compressed':
			case 'application/octet-stream':
			case 'application/x-compress':
			case 'application/x-compressed':
			case 'multipart/x-zip':
			case 'application/gzip': # .tar.gz
			case 'application/x-gzip': # .tar.gz
			case 'application/x-gunzip': # .tar.gz
			case 'application/gzipped': # .tar.gz
			case 'application/gzip-compressed': # .tar.gz
			case 'application/x-compressed': # .tar.gz
			case 'application/x-compress': # .tar.gz
			case 'gzip/document': # .tar.gz
				$content['file-classification'] = 'Compressed Archive File';
				$content['primary-association'] = 'Archive';
				break;
				
			// if file type are unknown
			default:
				$content['file-classification'] = 'Unknown';
				$content['primary-association'] = 'Unknown';
				break;
		}
		
		return $content;
	}
	
	/**
	 * @author Paris Nakita Kejser
	 * @since 1.0.0.4
	 * @version 1.0.0.4
	 *
	 * @param string $path Folder path to create
	 * @param boolean $recursive Create the entire nested structure if necessary
	 * @param int $mode Octal access mode (for UNIX-like systems)
	 * @return boolean TRUE if the folder was created or exists, FALSE on failure
	 */
	public static function createFolderIfNotExists($path, $recursive=false, $mode=0755)
	{
	  if (!file_exists($path))
		  return mkdir($path, $mode, $recursive);

	  return true;
	}
}
