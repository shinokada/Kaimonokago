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
 * Conditional CSS Shorthand Browser Mappings
 * 
 * This array contains a mapping from valid browser names (defined
 * in the CodeIgniter user_agent config file) to shorthand
 * versions which are used when naming a conditional css file.
 * 
 * @var array
 */
$config['cond_css_browsers'] = array(
		'Opera'				=> 'op',
		'Internet Explorer'	=> 'ie',
		'Shiira'			=> 'sh',
		'Firefox'			=> 'ff',
		'Chimera'			=> 'ch',
		'Phoenix'			=> 'ph',
		'Firebird'			=> 'fb',
		'Camino'			=> 'ca',
		'Netscape'			=> 'ns',
		'OmniWeb'			=> 'ow',
		'Mozilla'			=> 'mz',
		'Safari'			=> 'sf',
		'Konqueror'			=> 'kq',
		'iCab'				=> 'ic',
		'Lynx'				=> 'lx',
		'Links'				=> 'lk',
		'HotJava'			=> 'hj',
		'Amaya'				=> 'ay',
		'IBrowse'			=> 'ib'
	);

/* End of bep_browser.php */
/* Location: ./modules/site/config/bep_browser.php */