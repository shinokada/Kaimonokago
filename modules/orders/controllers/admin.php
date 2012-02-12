<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Shop_Admin_Controller {
  	function Admin(){
   	parent::Shop_Admin_Controller();
	// Check for access permission
		check('Orders');
		// load category model from module categories	
		$this->load->module_model('category','MCats');	
		$this->load->module_model('products','MProducts');	
		// load orders model
		$this->load->model('MOrders');
		// Set breadcrumb
		$this->bep_site->set_crumb($this->lang->line('backendpro_orders'),'orders/admin');	
		
	}
  
  	function index(){
	
		$data['title'] = "Manage Orders";
		//$data['main'] = 'admin_orders_home';
		$data['products'] = $this->MProducts->getAllProducts();
		$data['categories'] = $this->MCats->getCategoriesDropDown();
		$data['orders'] = $this->MOrders->getAllOrders();
		$data['header'] = $this->lang->line('backendpro_access_control');
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_orders_home";
		$data['module'] = 'orders';
		$this->load->view($this->_container,$data);
	
  	}
  
  
  	function details($id){
	
		$data['title'] = "Order Details";
		//$data['main'] = 'admin_orders_details';
		$data['products'] = $this->MProducts->getAllProducts();
		$data['categories'] = $this->MCats->getCategoriesDropDown();
		$data['orderdetails'] = $this->MOrders->getOrderDetails($id);
		// Set breadcrumb
		$this->bep_site->set_crumb($this->lang->line('userlib_order_details'),'orders/admin/details');	
		$data['header'] = $this->lang->line('backendpro_access_control');
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_orders_details";
		$data['module'] = 'orders';
		$this->load->view($this->_container,$data);
  	}
  
  
  	function paid($id){
		$this->MOrders->setpayment($id);
		$this->session->set_flashdata('message', 'Payment Date updated!');
		redirect('orders/admin');
   	}
  
   
  	function delivered($id){
		$this->MOrders->setdelivery($id);
		$this->session->set_flashdata('message', 'Delivery Date updated!');
		redirect('orders/admin/');
   	}	
  
   	
  	function deleteitem($order_id, $order_item_id){
		$order_id = $this->uri->segment(4);
		$order_item_id = $this->uri->segment(5);
			
		if (count($this->MOrders->findsiblings($order_id)) < 2){
			$this->MOrders->deleteOrder($order_id);
			$this->MOrders->deleteOrderItem($order_item_id);
			$this->session->set_flashdata('message','Order deleted');
			redirect('orders/admin/index','refresh');
		}else{
		    $this->MOrders->deleteOrderItem($order_item_id);
			$this->session->set_flashdata('message','Order item deleted');
			redirect('orders/admin/details/'.$order_id,'refresh');
		}
	}
    
}


?>