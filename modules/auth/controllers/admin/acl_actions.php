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
 * ACL Actions Controller
 *
 * Provide the ability to manage ACL actions
 *
 * @package         BackendPro
 * @subpackage      Controllers
 */
class Acl_actions extends Admin_Controller
{
	function Acl_actions()
	{
		parent::Admin_Controller();

		// Load needed files
		$this->lang->load('access_control');
		$this->load->model('access_control_model');

		// Check for access permission
		check('Actions');

		// Set breadcrumb
		$this->bep_site->set_crumb($this->lang->line('backendpro_access_control'),'auth/admin/access_control');
		$this->bep_site->set_crumb($this->lang->line('access_actions'),'auth/admin/acl_actions');

		log_message('debug','BackendPro : Acl_actions class loaded');
	}

	function index()
	{
		$this->load->helper('form');

		// Display Page
		$data['header'] = $this->lang->line('access_actions');
		$data['page'] = $this->config->item('backendpro_template_admin') . "access_control/actions";
		$data['module'] = 'auth';
		$this->load->view($this->_container,$data);
	}

	/**
	 * Create action
	 *
	 * @access public
	 */
	function create()
	{
		// Setup validation
		$this->load->library('validation');
		$fields['name'] = $this->lang->line('access_name');
		$rules['name'] = 'trim|required|min_length[3]|max_length[254]';
		$this->validation->set_fields($fields);
		$this->validation->set_rules($rules);

		if($this->validation->run() === FALSE)
		{
			// FAIL
			$this->validation->output_errors();
		}
		else
		{
			// PASS
			$name = $this->input->post('name');
			$this->load->library('khacl');

			if($this->khacl->axo->create($name))
			{
				flashMsg('success',sprintf($this->lang->line('access_action_created'),$name));
			}
			else
			{
				flashMsg('warning',sprintf($this->lang->line('access_action_exists'),$name));
			}
		}
		redirect('auth/admin/acl_actions','location');
	}

	/**
	 * Delete Actions
	 *
	 * @access public
	 */
	function delete()
	{
		if(FALSE === ($actions = $this->input->post('select')))
		{
			redirect('auth/admin/acl_actions','location');
		}

		$this->load->library('khacl');
		foreach($actions as $action)
		{
			if( $this->khacl->axo->delete($action))
			{
				flashMsg('success',sprintf($this->lang->line('access_action_deleted'),$action));
			}
			else
			{
				flashMsg('error',sprintf($this->lang->line('backendpro_action_failed'),$this->lang->line('access_delete_action')));
			}
		}
		redirect('auth/admin/acl_actions','location');
	}
}

/* End of file acl_actions.php */
/* Location: ./modules/auth/controllers/admin/acl_actions.php */