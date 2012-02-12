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
 * Public_Controller
 *
 * Extends the Site_Controller class so I can declare special Public controllers
 *
 * @package        BackendPro
 * @subpackage     Controllers
 */
class Public_Controller extends Site_Controller
{
	function Public_Controller()
	{
		parent::Site_Controller();

		// Set container variable
		$this->_container = $this->config->item('backendpro_template_public') . "container.php";

		// Set public meta tags
		//$this->bep_site->set_metatag('name','content',TRUE/FALSE);

		// Load the PUBLIC asset group
		$this->bep_assets->load_asset_group('PUBLIC');
		
		log_message('debug','BackendPro : Public_Controller class loaded');
	}
}

/* End of Public_controller.php */
/* Location: ./system/application/libraries/Public_controller.php */