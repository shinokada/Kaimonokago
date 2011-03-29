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
 * ACL Permissions
 *
 * Provide the ability to manage ACL permissions
 *
 * @package  	BackendPro
 * @subpackage  Controllers
 */
class Acl_permissions extends Admin_Controller
{
	function Acl_permissions()
	{
		parent::Admin_Controller();

		// Load files
		$this->lang->load('access_control');
		$this->load->model('access_control_model');
		$this->load->helper('form');

		// Set breadcrumb
		$this->bep_site->set_crumb($this->lang->line('backendpro_access_control'),'auth/admin/access_control');
		$this->bep_site->set_crumb($this->lang->line('access_permissions'),'auth/admin/acl_permissions');

		// Check for access permission
		check('Permissions');

		log_message('debug','BackendPro : Acl_permissions class loaded');
	}

	/**
	 * View Permissions
	 *
	 * @access public
	 * @return void
	 */
	function index()
	{
		// Display Page
		$data['header'] = $this->lang->line('access_permissions');
		$data['page'] = $this->config->item('backendpro_template_admin') . "access_control/permissions";
		$data['module'] = 'auth';
		$this->load->view($this->_container,$data);
	}

	/**
	 * Permission Form
	 *
	 * @access public
	 * @param integer $id Permission ID
	 */
	function form($id = NULL)
	{
		$this->load->library('validation');

		// Load the JS file needed
		$this->bep_assets->load_asset('bep_access_control');

		// Set action defauts since this is needed for both CREATE & MODIFY
		$query = $this->access_control_model->fetch('axos');
		foreach($query->result() as $action)
		{
			$this->validation->set_default_value('allow_'.$action->id,'N');
		}

		if( is_null($id))
		{
			// CREATE PERMISSION
			$data['header'] = $this->lang->line('access_create_permission');

			// Set form defaults
			$this->validation->set_default_value('allow','N');
			$this->validation->set_default_value('id','');
		}
		else
		{
			// MODIFY PERMISSION
			$data['header'] = $this->lang->line('access_edit_permission');

			// Fetch form data
			$this->validation->set_default_value('id',$id);
			$result = $this->access_control_model->getPermissions(NULL,array('acl.id'=>$id));
			$row = $result[$id];

			$this->validation->set_default_value('aro',$row['aro']);
			$this->validation->set_default_value('aco',$row['aco']);
			$this->validation->set_default_value('allow',($row['allow']?'Y':'N'));

			if( isset($row['actions']))
			{
				foreach($row['actions'] as $action)
				{
					$this->validation->set_default_value('action_'.$action['id'],$action['axo']);
					$this->validation->set_default_value('allow_'.$action['id'],($action['allow']?'Y':'N'));
				}
			}
		}

		// Display Page
		$this->bep_site->set_crumb($data['header'],'auth/admin/acl_permissions/form/'.$id);
		$data['page'] = $this->config->item('backendpro_template_admin') . "access_control/form_permission";
		$data['module'] = 'auth';
		$this->load->view($this->_container,$data);
	}

	/**
	 * Save Permission
	 *
	 * @access public
	 * @return void
	 */
	function save()
	{
		// Get values from form
		$id = $this->input->post('id');
		$allow = $this->input->post('allow');

		// INFO: This is a bit of a dirty fix for bug #20 there must be a better way
		if($id != NULL)
		{
			// Form has been submited, so we need to fetch the
			// aro and aco values from the database
			$result = $this->access_control_model->getPermissions(NULL,array('acl.id'=>$id));
			$row = $result[$id];

			$_POST['aro'] = $row['aro'];
			$_POST['aco'] = $row['aco'];
		}

		$aro = $this->input->post('aro');
		$aco = $this->input->post('aco');

		$this->load->library('khacl');

		$this->db->trans_begin();

		// Remove old actions if modifying
		if($id != NULL)
		{
			$this->access_control_model->delete('access_actions',array('access_id'=>$id));
		}

		// First we will process the actions
		foreach($_POST as $key=>$value)
		{
			if(substr($key,0,7) == 'action_')
			{
				$key = substr($key,strpos($key,"_")+1);
				switch($this->input->post('allow_'.$key))
				{
					case 'Y':$this->khacl->allow($aro,$aco,$this->input->post('action_'.$key));break;
					case 'N':$this->khacl->deny($aro,$aco,$this->input->post('action_'.$key));break;
				}
			}
		}

		// Now process the main permission
		switch($allow)
		{
			case 'Y':$this->khacl->allow($aro,$aco);break;
			case 'N':$this->khacl->deny($aro,$aco);break;
		}

		// Did everything go OK?
		if($this->db->trans_status() === TRUE)
		{
			// Yup all good
			$this->db->trans_commit();
			if($id == '')
			{
				flashMsg('success',$this->lang->line('access_permission_created'));
			}
			else
			{
				flashMsg('success',$this->lang->line('access_permission_saved'));
			}
		}
		else
		{
			// Something went wrong
			$this->db->trans_rollback();
			if($id == '')
			{
				flashMsg('error',sprintf($this->lang->line('backendpro_action_failed'),$this->lang->line('access_create_permission')));
			}
			else
			{
				flashMsg('error',sprintf($this->lang->line('backendpro_action_failed'),$this->lang->line('access_edit_permission')));
			}
		}
		redirect('auth/admin/acl_permissions','location');
	}

	/**
	 * Delete Permissions
	 *
	 * @access public
	 * @return void
	 */
	function delete()
	{
		if(FALSE === ($permissions = $this->input->post('select')))
		{
			redirect('auth/admin/acl_permissions','location');
		}

		foreach($permissions as $permission)
		{
			$this->access_control_model->delete('access',array('id'=>$permission));
		}
		flashMsg('success',$this->lang->line('access_permissions_deleted'));
		redirect('auth/admin/acl_permissions','location');
	}

	/**
	 * View Permissions in Advanced Mode
	 *
	 * Displays a way so a user can select a group and it shows exactly
	 * what resources that group has access to
	 *
	 * @access public
	 * @return void
	 */
	function show()
	{
		// INFO: This line has been added to solve "Fatal error: Call to a member function on a non-object in C:\xampp\htdocs\BackendPro\modules\auth\models\access_control_model.php on line 320" being thrown on advanced permission page
		$this->load->library('validation');

		// Load required JS
		$this->bep_assets->load_asset('bep_access_control');

		// Display Page
		$this->bep_site->set_crumb($this->lang->line('access_advanced_permissions'),'auth/admin/acl_permissions/show');
		$data['header'] = $this->lang->line('access_advanced_permissions');
		$data['page'] = $this->config->item('backendpro_template_admin') . "access_control/view_advanced_permissions";
		$data['module'] = 'auth';
		$this->load->view($this->_container,$data);
	}

	/**
	 * Ajax Function to fetch resources
	 *
	 * @access public
	 * @param string $group Fetch resource access rights for this group
	 * @return void
	 */
	function ajax_fetch_resources($group)
	{
		$this->load->model('access_control_model');
		$this->load->library('khacl');

		$obj = $this->access_control_model->resource;
		$tree = $obj->getTreePreorder($obj->getRoot());
		$lvl = 0;
		while($obj->getTreeNext($tree))
		{
			// Nest the tree
			$newLvl = $obj->getTreeLevel($tree);
			if ($lvl > $newLvl)
			{
				// Just gone up some levels
				for($i=0;$i<$lvl-$newLvl;$i++)
				{
					print "</ul></li>";
				}
			}
			$lvl = $newLvl;

			$allow = $this->khacl->check($group,$tree['row']['name']);

			print '<li id="'.$tree['row']['name'].'"><span ';
			print ($allow) ? 'class="icon_tick">' : 'class="icon_cross">';
			print $tree['row']['name'];
			print '</span>';

			if($obj->checkNodeHasChildren($tree['row']))
			{
				print "<ul>";
			}
			else
			{
				print "</li>";
			}
		}
	}

	/**
	 * Ajax Function to fetch a groups resources
	 *
	 * @access public
	 * @param string $group Fetch actions for this group
	 * @param string $resource Fetch actions for this resource
	 * @return void
	 */
	function ajax_fetch_actions($group,$resource)
	{
		// INFO: This line was added to stop the error Fatal error: Call to a member function on a non-object in C:\xampp\htdocs\BackendPro\modules\auth\controllers\admin\acl_permissions.php on line 274 being thrown on advanced permission page
		$this->load->library('khacl');
		$query = $this->access_control_model->fetch('axos');
		foreach($query->result() as $result)
		{
			$allow = $this->khacl->check($group,$resource,$result->name);
			print '<div class="access_action_box"><span ';
			print ($allow) ? 'class="icon_tick">' : 'class="icon_cross">';
			print $result->name;
			print '</span></div>';
		}
	}
}

/* End of file acl_permissions.php */
/* Location : ./system/application/controllers/admin/acl_permissions.php */