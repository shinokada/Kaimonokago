<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BackendPro
 *
 * An open source development control panel written in PHP
 *
 * @package		BackendPro
 * @author		Adam Price
 * @copyright	Copyright (c) 2008, Adam Price
 * @license		http://www.gnu.org/licenses/lgpl.html
 * @link		http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Access Control Controller
 *
 * Display a splash page showing the access control options
 *
 * @package         BackendPro
 * @subpackage      Controllers
 */
class Access_control extends Admin_Controller
{
	function Access_control()
	{
		parent::Admin_Controller();

		// Load needed files
		$this->lang->load('access_control');

		// Check for access permission
		check('Access Control');

		// Set breadcrumb
		$this->bep_site->set_crumb($this->lang->line('backendpro_access_control'),'auth/admin/access_control');

		log_message('debug','BackendPro : Access_control class loaded');
	}

	function index()
	{
		// Display Page
		$data['header'] = $this->lang->line('backendpro_access_control');
		$data['page'] = $this->config->item('backendpro_template_admin') . "access_control/home";
		$data['module'] = 'auth';
		$this->load->view($this->_container,$data);
		return;
	}
}

/* End of file access_control.php */
/* Location: ./modules/controllers/admin/access_control.php */