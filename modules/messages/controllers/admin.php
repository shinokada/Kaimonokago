<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Shop_Admin_Controller {
  function Admin(){
   parent::Shop_Admin_Controller();
   // Check for access permission
	check('Messages');
	// Load model MMessages
	$this->load->model('MMessages');
		
	// Set breadcrumb
	$this->bep_site->set_crumb($this->lang->line('backendpro_messages'),'messages/admin');	
		
    }
  
  function index(){
  	$data['title'] = "Manage Messages";
	
	$data['user_id'] =$this->session->userdata('id');
	$data['username'] =$this->session->userdata('username');
	
	$data['todos'] = $this->MMessages->getToDoMessages();
	$data['completed'] = $this->MMessages->getCompletedMessages();
	 
	$data['header'] = $this->lang->line('backendpro_access_control');
	$data['page'] = $this->config->item('backendpro_template_admin') . "admin_messages_home";
	$data['module'] = 'messages';
	$this->load->view($this->_container,$data);
	
  }

		
	function getCompletedBox(){
	  	
	  		$messages = $this->MMessages->getCompletedMessages();
			flashMsg('success','Status changed');
			redirect ('messages/admin/');
	  		
		}
		
	// Instead of using AjaxinserShoutBox we use IS_AJAX here	
	function insertShoutBox(){
	  if(IS_AJAX){
			$this->MMessages->updateMessage();
			}else{
			$this->MMessages->updateMessage();
			flashMsg('success','New task added');
			redirect ('messages/admin/');
			}
		}
		
	function changestatus($id){
		if($id){
			$this->MMessages->changeMessageStatus($id);
			$this->getCompletedBox();
			flashMsg('success','Status changed');
			redirect ('messages/admin/','refresh');
		}
			flashMsg('warning','Status not changed');
			redirect('messages/admin/','refresh');		
	  }
	 
	 
	 function delete($id){
		if(IS_AJAX){
			  $this->MMessages->delete($id);
		}else{
		  if($id){	
			  $this->MMessages->delete($id);
			  flashMsg('success','Task deleted');
			  redirect('messages/admin/','refresh');
			  }
			  flashMsg('warning','Task not deleted');
			  redirect('messages/admin/','refresh');
		}
	  }
	  
	  	function AjaxinsertShoutBox(){
			
			$this->MMessages->updateMessage();
			
		}
	  
	  function AjaxgetShoutBox(){
	  	
	  		$todos = $this->MMessages->getToDoMessages();
	  		if(is_array($todos)){
	  		foreach ($todos as $key => $todo){
			//	 echo "\n<li class=\"delete\" >".$message['message']."</li>";
				 echo "\n<li class=\"".$todo['id']."\">\n<div class=\"listbox\"><span class=\"user\"><strong>".$todo['user']."</strong></span>\n\n<span class=\"date\" >" .$todo['date']."</span>\n";
				 echo anchor ('messages/admin/changestatus/'.$todo['id'],$todo['status'],array('class'=>'todo'));
				 echo "<span class=\"msg\">".$todo['message'].
				"</span></div></li>";
				}
	  		}else{
	  			echo "No list. Let's add new one.";
	  		}	
		}
		
	function AjaxgetCompletedBox(){
	  	
	  		$completed = $this->MMessages->getCompletedMessages();
	  		if(is_array($completed)){
	  		foreach ($completed as $key => $list){
			
			echo "\n<li class=\"".$list['id']."\">\n<span class=\"user\"><strong>".$list['user']."</strong></span>\n<span class=\"date\" >" .$list['date']."</span>\n";
			echo anchor ('messages/admin/changestatus/'.$list['id'],$list['status'],array('class'=>'completedmsg'));
			echo	 "\n<a href=\"admin/delete/"
				 .$list['id']."\" id=\"".$list['id']."\" class=\"delete\">x</a><span class=\"msg\">".$list['message'].
				"</span>\n</li>";

				}
	  		}else{
	  			echo "No completed list.";
	  		}	
		}		
}