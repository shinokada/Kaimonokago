<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BackendPro
 *
 * A website backend system for developers for PHP 4.3.2 or newer
 *
 * @package         BackendPro
 * @author          Adam Price
 * @copyright       Copyright (c) 2008
 * @license         http://www.gnu.org/licenses/lgpl.html
 * @link            http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ---------------------------------------------------------------------------

/**
 * Image Controller
 *
 * Allows images to be resized and cropped. Has a feature so any work done
 * is cached for next time
 *
 * @package			BackendPro
 * @subpackage		Controllers
 */
class Image extends Controller
{
	var $cache;		// Cache Folder Location
	var $img_path;	// Image path

	function Image()
	{
		parent::Controller();

		// Load Image config file
		$this->load->config('image');

		$this->img_path = NULL;

		// Setup the cache path so it uses that declared in the
		// CodeIgniter config file
		if ($this->config->item('cache_path') == "")
		{
			$this->cache = BASEPATH . "cache/";
		}
		else
		{
			$this->cache = $this->config->item('cache_path');
		}

		log_message('debug','BackendPro : Image class loaded');
	}

	/**
	 * Get Image
	 *
	 * Process an image and output it to the browser
	 *
	 * @access public
	 * @return Image
	 */
	function get()
	{
		// Get the properties from the URI
		$default = array('file','width','height','crop','quality','nocache');
		$uri_array = $this->uri->uri_to_assoc(3, $default);

		if( $uri_array['file'] == NULL)
		{
			// Don't continue
			log_message("error","BackendPro->Image->get : Badly formed image request string: " . $this->uri->uri_string());
			return;
		}

		// Try to find the image
		foreach($this->config->item('image_folders') as $folder)
		{
			if ( file_exists($folder.$uri_array['file']))
			{
				$this->img_path = $folder.$uri_array['file'];
				break;
			}
		}

		// Image couldn't be found
		if ($this->img_path == NULL)
		{
			log_message("error","BackendPro->Image->get : Image dosn't exisit: " . $uri_array['file']);
			return;
		}

		// Get the size and MIME type of the requested image
		$size = GetImageSize($this->img_path);
		$width = $size[0];
		$height = $size[1];

		// Make sure that the requested file is actually an image
		if (substr($size['mime'], 0, 6) != 'image/')
		{
			log_message("error","BackendPro->Image->get : Requested file is not an accepted type: " . $this->img_path);
			return;
		}

		// Before we start to check for caches and alike, lets just see if the image
		// was requested with no changes, if so just return the normal image
		if( $uri_array['width'] == NULL AND $uri_array['height'] == NULL AND $uri_array['watermark'] == NULL AND $uri_array['crop'] == NULL AND $uri_array['quality'] == NULL)
		{
			$data	= file_get_contents($this->img_path);
			header("Content-type:". $size['mime']);
			header('Content-Length: ' . strlen($data));
			print $data;
			return;
		}

		// We know we have to do something, so before we do lets see if there is
		// cache of the image already
		if( $uri_array['nocache'] == NULL)
		{
			// TODO: This should check to see if the image has changed since the last cache?
			$image_cache_string = $this->img_path . " - " . $uri_array['width'] . "x" . $uri_array['height'];
			$image_cache_string.= "x" . $uri_array['crop'] . "x" . $uri_array['quality'];
			$image_cache_string = md5($image_cache_string);

			if (file_exists($this->cache.$image_cache_string))
			{
				// Yes a cached image exists
				$data	= file_get_contents($this->cache.$image_cache_string);

				// Before we output the image, does the local cache have the image?
				$this->_ConditionalGet($data);

				header("Content-type: ". $size['mime']);
				header('Content-Length: ' . strlen($data));
				print $data;
				return;
			}
		}

		// CROP IMAGE
		$offsetX = 0;
		$offsetY = 0;
		if( $uri_array['crop'] != NULL)
		{
			$crop = explode(':',$uri_array['crop']);
			if(count($crop) == 2)
			{
				$actualRatio = $width / $height;
				$requestedRatio = $crop[0] / $crop[1];

				if ($actualRatio < $requestedRatio)
				{ 	// Image is too tall so we will crop the top and bottom
					$origHeight	= $height;
					$height		= $width / $requestedRatio;
					$offsetY	= ($origHeight - $height) / 2;
				}
				else if ($actualRatio > $requestedRatio)
				{ 	// Image is too wide so we will crop off the left and right sides
					$origWidth	= $width;
					$width		= $height * $requestedRatio;
					$offsetX	= ($origWidth - $width) / 2;
				}
			}
		}

		// RESIZE
		$ratio = $width / $height;
		$new_width = $width;
		$new_height = $height;
		if( $uri_array['width'] != NULL AND $uri_array['height'] != NULL)
		{
			// Resize image to fit into both dimensions
			$new_ratio = $uri_array['width'] / $uri_array['height'];
			if($ratio > $new_ratio)
			{
				// Height is larger
				$uri_array['height'] = NULL;
			}
			else
			{
				// Width is larger
				$uri_array['width'] = NULL;
			}
		}

		if ( $uri_array['width'] == NULL AND $uri_array['height'] != NULL)
		{	// Keep height ratio
			$new_height = $uri_array['height'];
			$new_width = $new_height * $ratio;
		}
		else if ( $uri_array['width'] != NULL AND $uri_array['height'] == NULL)
		{	// Keep width ratio
			$new_width = $uri_array['width'];
			$new_height = $new_width / $ratio;
		}

		// QUALITY
		$quality = ($uri_array['quality'] != NULL) ? $uri_array['quality'] : $this->config->item('image_default_quality');

		$dst_image = imagecreatetruecolor($new_width, $new_height);
		$src_image = imagecreatefromjpeg($this->img_path);
		imagecopyresampled($dst_image,$src_image,0, 0, $offsetX, $offsetY, $new_width, $new_height, $width, $height  );

		// SAVE CACHE
		if( $uri_array['nocache'] == NULL)
		{
			// Make sure Cache dir is writable
			// INFO: This may be the source of the images sometimes not showing, seems some of the cache files can't be found
			// INFO: Since we are running this on a linux server its fine but this could cause issues http://codeigniter.com/forums/viewthread/94359/
			if ( !is_really_writable($this->cache))
			//if( !is_writable($this->cache))
			{
				log_message('error',"BackendPro->Image->get : Cache folder isn't writable: " . $this->cache);
			}
			else
			{
				// Write image to cache
				imagejpeg($dst_image,$this->cache.$image_cache_string,$quality);
			}
		}

		header("Content-type:". $size['mime']);
		imagejpeg($dst_image,NULL,$quality);
	}

	function _ConditionalGet($data)
	{
		$lastModified	= gmdate('D, d M Y H:i:s', filemtime($this->img_path)) . ' GMT';
		$etag = md5($data);

		header("Last-Modified: $lastModified");
		header("ETag: \"{$etag}\"");

		$if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ?
			stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) :
			false;

		$if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ?
			stripslashes($_SERVER['HTTP_IF_MODIFIED_SINCE']) :
			false;

		if (!$if_modified_since && !$if_none_match)
		{
			return;
		}

		if ($if_none_match && $if_none_match != $etag && $if_none_match != '"' . $etag . '"')
		{
			// Etag is there but doesn't match
			return;
		}

		if ($if_modified_since && $if_modified_since != $lastModified)
		{
			// if-modified-since is there but doesn't match
			return;
		}

		// Nothing has changed since their last request - serve a 304 and exit
		header('HTTP/1.1 304 Not Modified');
		exit();
	}
}

/* End of file image.php */
/* Location : ./modules/image/controllers/image.php */