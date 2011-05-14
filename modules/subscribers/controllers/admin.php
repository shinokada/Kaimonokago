<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Shop_Admin_Controller {

    private $module;

    function Admin(){
       parent::Shop_Admin_Controller();
       // Check for access permission
            check('Subscribers');
        // load model subscribers
        $this->load->model('MSubscribers');
        $this->module='subscribers';
        // Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('backendpro_subscribers'),'subscribers/admin');
        // Loading Bep validation
        // $this->load->library('validation');
    }
  

  function index(){
	$data['title'] = "Manage Subscribers";
	$data['subscribers'] = $this->MSubscribers->getAllSubscribers();
	$data['header'] = $this->lang->line('backendpro_access_control');
	$data['page'] = $this->config->item('backendpro_template_admin') . "admin_subs_home";
	$data['module'] = $this->module;
	$this->load->view($this->_container,$data);
  }
  


  function sendemail(){
  	$this->bep_assets->load_asset_group('TINYMCE');
  	 
  	$this->load->helper('file');
  	if ($this->input->post('subject')){
        $test = $this->input->post('test');
        $subject = $this->input->post('subject');
        $msg = $this->input->post('message');

        if ($test){
            $this->email->clear();
            // Replace with your email and company name
            $this->email->from('admin@google.com', 'Your company name');
            // Replace with your other email for testing
            $this->email->to('otheremail@gmail.com');
            $this->email->subject($subject);
            $this->email->message($msg);
            $this->email->send();
            $this->session->set_flashdata('message', "Test email sent");
            write_file('/tmp/email.log', $subject ."|||".$msg);
            // redirect wherever you want, it can be index page
            redirect('subscribers/admin/sendemail','refresh');
        }else{
            $subs = $this->MSubscribers->getAllSubscribers();
            foreach ($subs as $key => $list){
                // you need to change this link to your unsubscribe link
                $unsub = "<p><a href='". base_url()."welcome/unsubscribe/".$list['id']. "'>Unsubscribe</a></p>";
                $this->email->clear();
                // Replace with your email and company name
                $this->email->from('admin@gmail.com', 'Your company name');
                $this->email->to($list['email']);
                // Replace with your other email for checking or blank
                $this->email->bcc('otheremail@gmail.com');
                $this->email->subject($subject);
                $this->email->message($msg . $unsub);
                $this->email->send();
            }
            // You can use Bep's flashMsg('type','message')
            $this->session->set_flashdata('message', count($subs) . " emails sent");
        }
        // redirect wherever you want.
        redirect('subscribers/admin/index','refresh');
  	}
		else
		{
            if ($this->session->flashdata('message') == "Test email sent"){
                $lastemail = read_file('/tmp/email.log');
                list($subj,$msg) = explode("|||",$lastemail);
                $data['subject'] = $subj;
                $data['msg'] = $msg;
            }else{
                $data['subject'] = '';
                $data['msg'] = '';
            }
            $data['title'] = "Send Email";
            // Set breadcrumb
            $this->bep_site->set_crumb($this->lang->line('kago_sendemail'),'subscriber/admin/sendemail');
            $data['header'] = $this->lang->line('backendpro_access_control');
            $data['cancel_link']= $this->module."/admin/index/";
            $data['page'] = $this->config->item('backendpro_template_admin') . "admin_subs_mail";
            $data['module'] = $this->module;
            $this->load->view($this->_container,$data);
  	}
  }
	
	function create_home(){
		$data['title'] = "Create Subscribers";
		
		// Set breadcrumb
		$this->bep_site->set_crumb($this->lang->line('kago_create_subscriber'),'subscriber/admin/create_home');
		$data['header'] = $this->lang->line('backendpro_access_control');
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_subs_create";
                $data['cancel_link']= $this->module."/admin/index/";
		$data['module'] = $this->module;
		$this->load->view($this->_container,$data);
		
	}
	

    function create_sub(){
		$rules['name'] = 'trim|required';
		$rules['email'] = 'trim|required|valid_email';
		$this->validation->set_rules($rules);
		if ($this->validation->run() == FALSE)
			{
				$this->validation->output_errors();
				redirect('subscribers/admin/');
			}
			else
			{
                $this->MSubscribers->createSubscriber();
                flashMsg('success',$this->lang->line('userlib_sub_added'));
                redirect('subscribers/admin/','refresh');
			}
    }
	
	
}//end class
?>