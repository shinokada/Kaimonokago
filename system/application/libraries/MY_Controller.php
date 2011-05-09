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
 * Site_Controller
 *
 * Extends the default CI Controller class so I can declare special site controllers.
 * Also loads the BackendPro library since if this class is part of the BackendPro system
 *
 * @package         BackendPro
 * @subpackage      Controllers
 */
class Site_Controller extends Controller
{
	var $_container;
	function Site_Controller()
	{
		parent::Controller();

		// Load Base CodeIgniter files
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->helper('html');

		// Load Base BackendPro files
		$this->load->config('backendpro');
		$this->lang->load('backendpro');
		$this->load->model('base_model');

		// Load site wide modules
		$this->load->module_library('status','status');
		$this->load->module_model('preferences','preference_model','preference');
		$this->load->module_library('site','bep_site');
		$this->load->module_library('site','bep_assets');
                $this->load->module_library('page','Page');
		
		$this->load->module_library('auth','userlib');

        // Loading kaimonokago model
        $this->load->module_model('kaimonokago','MKaimonokago');
        //$this->load->module_language('kaimonokago','kaimonokago');
        

		// Display page debug messages if needed
		if ($this->preference->item('page_debug'))
		{
			$this->output->enable_profiler(TRUE);
		}

		// Set site meta tags
		//$this->bep_site->set_metatag('name','content',TRUE/FALSE);
		$this->output->set_header('Content-Type: text/html; charset='.config_item('charset'));
		$this->bep_site->set_metatag('content-type','text/html; charset='.config_item('charset'),TRUE);
		$this->bep_site->set_metatag('robots','all');
		$this->bep_site->set_metatag('pragma','cache',TRUE);

		// Load the SITE asset group
		$this->bep_assets->load_asset_group('SITE');

		log_message('debug','BackendPro : Site_Controller class loaded');
	}
}

include_once("Admin_controller.php");
include_once("Public_controller.php");
include_once("Shop_controller.php");
include_once("Shop_admin_controller.php");


/* End of file MY_Controller.php */
/* Location: ./system/application/libraries/MY_Controller.php */