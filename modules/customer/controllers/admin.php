<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Shop_Admin_Controller {

    private $moudle;


    function Admin(){
    parent::Shop_Admin_Controller();
    // Check for access permission
	check('Customers');
	// load MCustomers model
	$this->load->model('MCustomers');
        $this->module=basename(dirname(dirname(__FILE__)));
   // Set breadcrumb
	$this->bep_site->set_crumb($this->lang->line('backendpro_customers'),$this->module.'/admin');
	
  }
  
  function index(){
	$data['title'] = "Manage customer";
	$data['customers'] = $this->MKaimonokago->getAllSimple($this->module);
        //$data['customers'] = $this->MCustomers->getAllCustomers();
	$data['header'] = $this->lang->line('backendpro_access_control');
	$data['page'] = $this->config->item('backendpro_template_admin') . "admin_customers_home";
	$data['module'] = $this->module;
	$this->load->view($this->_container,$data);
  }
  

    function _fields(){
        $data = array(
            'customer_first_name'   => db_clean($_POST['customer_first_name'],25),
            'customer_last_name'    => db_clean($_POST['customer_last_name'],25),
            'phone_number'          => db_clean($_POST['phone_number'],15),
            'email'                 => db_clean($_POST['email'],50),
            'address'               => db_clean($_POST['address'],50),
            'city'                  => db_clean($_POST['city'],25),
            'post_code'             => db_clean($_POST['post_code'],10),
            'password'              => db_clean(dohash($_POST['password']),16)
            );
        return $data;
    }

  function create(){
    if ($this->input->post('customer_first_name')){
        $rules['customer_first_name'] = 'required';
        $rules['password'] = 'required';
        $rules['email'] = 'required|valid_email';
        $this->validation->set_rules($rules);

    if ($this->validation->run() == FALSE)
        {
            $this->validation->output_errors();
            //redirect($this->module.'/admin/create');
            $data['title'] = "Create Customer";
            // Set breadcrumb
            $this->bep_site->set_crumb($this->lang->line('kago_create')." ".$this->lang->line('kago_customer'),$this->module.'/admin/create');
            $data['header'] = $this->lang->line('backendpro_access_control');
            $data['page'] = $this->config->item('backendpro_template_admin') . "admin_customers_create";
            $data['cancel_link']= $this->module."/admin/index/";
            $data['module'] = $this->module;
            $this->load->view($this->_container,$data);
        }
        else
        {
            /*
            $data = array(
            'customer_first_name'   => db_clean($_POST['customer_first_name'],25),
            'customer_last_name'    => db_clean($_POST['customer_last_name'],25),
            'phone_number'          => db_clean($_POST['phone_number'],15),
            'email'                 => db_clean($_POST['email'],50),
            'address'               => db_clean($_POST['address'],50),
            'city'                  => db_clean($_POST['city'],25),
            'post_code'             => db_clean($_POST['post_code'],10),
            'password'              => db_clean(dohash($_POST['password']),16)
            );
             *
             */
            $data = $this->_fields();
            $this->MKaimonokago->addItem($this->module, $data);
            //$this->MCustomers->addCustomer();
            flashMsg('success','Customer created');
            redirect($this->module.'/admin/index','refresh');
        }
    }else{
        $data['title'] = "Create Customer";
        // Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('kago_create')." ".$this->lang->line('kago_customer'),$this->module.'/admin/create');
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_customers_create";
        $data['cancel_link']= $this->module."/admin/index/";
        $data['module'] = $this->module;
        $this->load->view($this->_container,$data);
    }
  }
  
  
  function edit($id=0){
    if ($this->input->post('customer_first_name')){
        $rules['customer_first_name'] = 'required';
        //$rules['passconf'] =  'required';
        $rules['email'] = 'required|valid_email';
        $this->validation->set_rules($rules);
    if ($this->validation->run() == FALSE){
            $this->validation->output_errors();
            $customer_id = $this->input->post('customer_id');
            redirect($this->module.'/admin/edit/'.$customer_id,'refresh');
        }else{
            $data = $this->_fields();
            $this->MKaimonokago->updateItem($this->module, $data);
            //$this->MCustomers->updateCustomer();
            flashMsg('success','Customer editted');
            redirect($this->module.'/admin/index','refresh');
        }
    }else{
        $data['title'] = "Edit Customer";
        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_customers_edit";
        $data['customer'] = $this->MKaimonokago->getInfo($this->module,$id);
        //$data['customer'] = $this->MCustomers->getCustomer($id);
        if (!count($data['customer'])){
            redirect($this->module.'/customer/index','refresh');
        }
        $data['header'] = $this->lang->line('backendpro_access_control');
        // Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('kago_edit')." ".$this->lang->line('kago_customer'),$this->module.'/admin/edit');
        $data['cancel_link']= $this->module."/admin/index/";
        $data['module'] = $this->module;
        $this->load->view($this->_container,$data);
    }
  }
  
  
    function delete($id){
    /**
     * When you delete customer, it will affect on omc_order table and it will affect omc_order_table_items
     * Check if the customer has orders, if yes, then go back with warning to delete the order first.
     *
     */
        $order_orphans = $this->MCustomers->checkOrphans($id);
        if (count($order_orphans)){
            // $this->session->set_userdata($order_orphans);
            flashMsg('warning','Customer can\'t be deleted');
            flashMsg('warning',$order_orphans);
            redirect('orders/admin/index/','refresh');
        }else{
            $table = 'omc_'.$this->module;
            $this->MKaimonokago->deleteitem($table,$id);
            //$this->MCustomers->deleteCustomer($id);
            flashMsg('success','Customer deleted');
            redirect($this->module.'/admin/index','refresh');
        }
    }


    /*
Not used
    function changeUserStatus($id){
        $this->MAdmins->changeCustomerStatus($id);
        flashMsg('success','User status changed');
        redirect('admins/admin/index','refresh');
    }
     * 
     */
	
	
}


?>