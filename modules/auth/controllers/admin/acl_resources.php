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
 * ACL Resources
 *
 * Provide the ability to manage ACL resources
 *
 * @package         BackendPro
 * @subpackage      Controllers
 */
class Acl_resources extends Admin_Controller
{
	function Acl_resources()
	{
		parent::Admin_Controller();

		// Load files
		$this->lang->load('access_control');
		$this->load->model('access_control_model');
		$this->load->helper('form');

		// Set breadcrumb
		$this->bep_site->set_crumb($this->lang->line('backendpro_access_control'),'auth/admin/access_control');
		$this->bep_site->set_crumb($this->lang->line('access_resources'),'auth/admin/acl_resources');

		// Check for access permission
		check('Resources');

		log_message('debug','BackendPro : ACcl_resources class loaded');
	}

	/**
	 * Display Resources
	 *
	 * @access public
	 * @return void
	 */
	function index()
	{
		// Display Page
		$data['header'] = $this->lang->line('access_resources');
		$data['page'] = $this->config->item('backendpro_template_admin') . "access_control/resources";
		$data['module'] = 'auth';
		$this->load->view($this->_container,$data);
	}

	/**
	 * Display Form
	 *
	 * @access public
	 * @param integer $id Resource ID
	 * @return void
	 */
	function form($id = NULL)
	{
		// Setup form validation
		$this->load->library('validation');
		$fields['id'] = "ID";
		$fields['name'] = $this->lang->line('access_name');
		$fields['parent'] = $this->lang->line('access_parent_name');
		$this->validation->set_fields($fields);

		$rules['name'] = "trim|required|max_length[254]";
		$rules['parent'] = "required";

		if( ! is_null($id) AND ! $this->input->post('submit'))
		{
			// Load values into form
			$node = $this->access_control_model->resource->getNodeFromId($id);

			// Check it isn't the root
			if( $this->access_control_model->resource->checkNodeIsRoot($node)){
				flashMsg('warning',sprintf($this->lang->line('access_resource_root'),$node['name']));
				redirect('auth/admin/acl_resources');
			}

			$parent = $this->access_control_model->resource->getAncestor($node);
			$this->validation->set_default_value('id',$id);
			$this->validation->set_default_value('name',$node['name']);
			$this->validation->set_default_value('parent',$parent['name']);
		}
		elseif( $this->input->post('submit'))
		{
			// Form submited, check rules
			$this->validation->set_rules($rules);
		}

		if($this->validation->run() === FALSE)
		{
			// Display Errors
			$this->validation->output_errors();

			// Get Resources
			$data['resources'] = $this->access_control_model->buildACLDropdown('resource');

			// Display Page
			$data['header'] = (is_null($id)?$this->lang->line('access_create_resource'):$this->lang->line('access_edit_resource'));
			$this->bep_site->set_crumb($data['header'],'auth/admin/acl_resources/form/'.$id);
			$data['page'] = $this->config->item('backendpro_template_admin') . "access_control/form_resource";
			$data['module'] = 'auth';
			$this->load->view($this->_container,$data);
		}
		else
		{
			$name = $this->input->post('name');
			$parent = $this->input->post('parent');

			if( is_null($id))
			{
				// Create Resource
				$this->load->library('khacl');

				$this->db->trans_begin();
				if( ! $this->khacl->aco->create($name,$parent))
				{
					flashMsg('warning',sprintf($this->lang->line('access_resource_exists'),$name));
					redirect('auth/admin/acl_resources/form');
				}

				$this->access_control_model->insert('resources',array('id'=>$this->db->insert_id()));

				if( $this->db->trans_status() === TRUE)
				{
					$this->db->trans_commit();
					flashMsg('success',sprintf($this->lang->line('access_resource_created'),$name));
				}
				else
				{
					$this->db->trans_rollback();
					flashMsg('error',sprintf($this->lang->line('backendpro_action_failed'),$this->lang->line('access_create_resource')));
				}
			}
			else
			{
				$id = $this->input->post('id');
				// Update Resource
				$node = $this->access_control_model->resource->getNodeFromId($id);
				$new_parent = $this->access_control_model->resource->getNodeWhere("name='".$parent."'");

				// Check the assigment isn't illeagal
				if($this->access_control_model->resource->checkNodeIsChildOrEqual($new_parent,$node)){
					flashMsg('warning',sprintf($this->lang->line('access_resource_illegal_assignment'),$name));
					redirect('auth/admin/acl_resources/form/'.$id);
				}

				$this->access_control_model->resource->setNodeAsLastChild($node,$new_parent);
				flashMsg('success',sprintf($this->lang->line('access_resource_saved'),$name));
			}
			redirect('auth/admin/acl_resources');
		}
	}

	/**
	 * Delete Resources
	 *
	 * @access public
	 * @return void
	 */
	function delete()
	{
		if(FALSE === ($resources = $this->input->post('select')))
		{
			redirect('auth/admin/acl_resources','location');
		}

		$this->load->library('khacl');
		foreach($resources as $resource)
		{
			// Check we havn't already deleted it as a child of another node
			$query = $this->access_control_model->fetch('acos',NULL,NULL,array('name'=>$resource));
			if($query->num_rows() === 0){
				flashMsg('success',sprintf($this->lang->line('access_resource_deleted'),$resource));
				continue;
			}

			if( $this->khacl->aco->delete($resource))
			{
				flashMsg('success',sprintf($this->lang->line('access_resource_deleted'),$resource));
			}
			else
			{
				flashMsg('error',sprintf($this->lang->line('backendpro_action_failed'),$this->lang->line('access_delete_resource')));
			}
		}

		redirect('auth/admin/acl_resources','location');
	}
}
/* End of file acl_resources.php */
/* Location: ./modules/auth/controllers/admin/acl_resources.php */