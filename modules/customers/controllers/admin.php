<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Shop_Admin_Controller {
  function Admin(){
    parent::Shop_Admin_Controller();
    // Check for access permission
	check('Customers');
	// load MCustomers model
	$this->load->model('MCustomers');
   // Set breadcrumb
	$this->bep_site->set_crumb($this->lang->line('backendpro_customers'),'customers/admin');
	
  }
  
  function index(){
	$data['title'] = "Manage Customers";
	$data['customers'] = $this->MCustomers->getAllCustomers();
	$data['header'] = $this->lang->line('backendpro_access_control');
	$data['page'] = $this->config->item('backendpro_template_admin') . "admin_customers_home";
	$data['module'] = 'customers';
	$this->load->view($this->_container,$data);
  }
  

  function create(){
   	if ($this->input->post('customer_first_name')){
   		$rules['customer_first_name'] = 'required';
		$rules['password'] = 'required';
		$rules['passconf'] =  'required';
		$rules['email'] = 'required';
		$this->validation->set_rules($rules);

   	if ($this->validation->run() == FALSE)
		{
			$this->validation->output_errors();
			redirect('customers/admin/create','refresh');
		}
		else
		{
			$this->MCustomers->addCustomer();
	  		flashMsg('success','Customer created');
	  		redirect('customers/admin/index','refresh');
		}
  	}else{
		$data['title'] = "Create Customer";	
		// Set breadcrumb
		$this->bep_site->set_crumb($this->lang->line('userlib_customer_create'),'customers/admin/create');	
		$data['header'] = $this->lang->line('backendpro_access_control');
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_customers_create";
		$data['module'] = 'customers';
		$this->load->view($this->_container,$data);  
	} 
  }
  
  
  function edit($id=0){
  	if ($this->input->post('customer_first_name')){
  		$this->MCustomers->updateCustomer();
  		flashMsg('success','Customer editted');
  		redirect('customers/admin/index','refresh');
  	}else{
		$data['title'] = "Edit Customer";
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_customers_edit";
		$data['customer'] = $this->MCustomers->getCustomer($id);
		if (!count($data['customer'])){
			redirect('admin/customers/index','refresh');
		}
		$data['header'] = $this->lang->line('backendpro_access_control');
		// Set breadcrumb
		$this->bep_site->set_crumb($this->lang->line('userlib_customer_edit'),'customers/admin/edit');	
		$data['module'] = 'customers';
		$this->load->view($this->_container,$data);    
	}
  }
  
  
	function delete($id){
	/**
	 * When you delete customers, it will affect on omc_order table and it will affect omc_order_table_items
	 * Check if the customer has orders, if yes, then go back with warning to delete the order first.
	 *
	 */
		$order_orphans = $this->MCustomers->checkOrphans($id);
		if (count($order_orphans)){
			// $this->session->set_userdata($order_orphans);
			flashMsg('warning','Customer can\'t be deleted');
			flashMsg('warning',$order_orphans);
			redirect('customers/admin/index/','refresh');	
		}else{
		    $this->MCustomers->deleteCustomer($id);
			flashMsg('success','Customer deleted');
			redirect('customers/admin/index','refresh');
		}
  	}
 
  
	function changeUserStatus($id){
		$this->MAdmins->changeCustomerStatus($id);
		flashMsg('success','User status changed');
		redirect('admins/admin/index','refresh');
  	}
	
	
}


?>