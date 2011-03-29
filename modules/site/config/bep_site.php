<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BackendPro
 *
 * A website backend system for developers for PHP 4.3.2 or newer
 *
 * @package         BackendPro
 * @author          Adam Price
 * @copyright       Copyright (c) 2009
 * @license         http://www.gnu.org/licenses/lgpl.html
 * @link            http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ---------------------------------------------------------------------------

/**
 * Default Site Variables
 * 
 * An array of site variables which will always
 * be outputed to the page.
 * 
 * Please do not remove base_url and index_page
 * since this are used by BackendPro
 * 
 * @var array
 */
$config['default_site_variables'] = array(
	'base_url' => base_url(),
    'index_page' => index_page()
);

/* End of file bep_site.php */
/* Location: ./modules/site/config/bep_site.php */