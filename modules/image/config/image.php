<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Image Config Array
 *
 * Contains all config settings for the image controller
 *
 * @package		BackendPro
 * @subpackage	Configurations
 * @author		Adam Price
 * @copyright	Copyright (c) 2008, Adam Price
 * @license		http://www.gnu.org/licenses/lgpl.html
 * @link		http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ---------------------------------------------------------------------------

/**
 * Default Image Quality
 *
 * Image quality to use when outputing images. Should be a percentage.
 */
$config['image_default_quality'] = 100;

/**
 * Image Folders
 *
 * Locations relative to the base_url() to search for images in.
 * Please INCLUDE a trailing slash
 */
$config['image_folders'] = array(
	'assets/images/');

/* End of file image.php */
/* Location: modules/image/config/backendpro.php */