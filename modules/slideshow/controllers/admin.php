<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Shop_Admin_Controller {

    private $module;

  	function Admin(){
	   	parent::Shop_Admin_Controller();
		// Check for access permission
		check('Slideshow');
		// load modules/categories/model/mcats
		//$this->load->module_model('category','MCats');
		// load the MSlideshow model
		$this->load->model('MSlideshow');
        $this->module='slideshow';
		// Set breadcrumb
		$this->bep_site->set_crumb($this->lang->line('backendpro_slideshow'),'slideshow/admin');
  	}
  
  	
  	function index(){
  		// Setting variables 
		$data['title'] = "Manage Slideshow";
		$data['slideshow'] = $this->MSlideshow->getAllslideshow();
		//$data['categories'] = $this->MCats->getCategoriesDropDown();
		// we are pulling a header word from language file
		$data['header'] = $this->lang->line('backendpro_access_control');
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_slideshow_home";
		$data['module'] = $this->module;
		$this->load->view($this->_container,$data);
	}
  

  	function create(){
  		// we are using TinyMCE in this page, so load it
  		$this->bep_assets->load_asset_group('TINYMCE');
  	
	   	if ($this->input->post('name')){
	   		// fields are filled up so do the followings
	  		$this->MSlideshow->insertslideshow();
	  		// CI way to set flashdata, but we are not using it
	  		// $this->session->set_flashdata('message','slideshow created');
	  		// we are using Bep function for flash msg
	  		flashMsg('success','slideshow created');
	  		redirect('slideshow/admin/index','refresh');
	  	}else{
	  		// this must be the first time, so set variables
			$data['title'] = "Create slideshow";
            // get categories by lang_id
            // $data['categories'] = $this->MCats->getCategoriesDropDown();
            $lang_id = '0';
			//$data['categories'] = $this->MCats->getCategoriesDropDownbyLang($lang_id);
			// loading this for giving some instructions.
			//$data['right'] = 'admin/slideshow_right';
			// Set breadcrumb
			$this->bep_site->set_crumb($this->lang->line('kago_create'),'slideshow/admin/create');
			$data['header'] = $this->lang->line('backendpro_access_control');
			$data['page'] = $this->config->item('backendpro_template_admin') . "admin_slideshow_create";
			$data['module'] = $this->module;
			$this->load->view($this->_container,$data);
		} 												
  	}
  
  	
  	function edit($id=0){
  		// we are using TinyMCE in edit as well
	  	$this->bep_assets->load_asset_group('TINYMCE');
	  	if ($this->input->post('name')){
	  		// fields filled up so,
	  		$this->MSlideshow->updateslide();
	  		// CI way to set flashdata, but we are not using it
	  		// $this->session->set_flashdata('message','slideshow updated');
	  		// we are using Bep function for flash msg
	  		flashMsg('success','slideshow updated');
	  		redirect('slideshow/admin/index','refresh');
	  	}else{
            // similar to category
			//$id = $this->uri->segment(4);
            $data['title'] = $this->lang->line('kago_edit')." ".$this->lang->line('kago_slideshow');
			// get all the languages
            //$data['languages'] =$this->MLangs->getLangDropDownWithId();
			// get translated languages
            // For other languages segment 4 is omc_slideshow.slideshow_id, slideshow_id is id of english(original), omc_menu.id
            // for english is omc_slideshow.id
            // $slideshow_id is used to find translated languages and it is used to get info of english menu
            //$slideshow_id = $this->uri->segment(4);
            //$data['translanguages'] =$this->MLangs->getTransLang($this->module,$slideshow_id);
            $data['module']=$this->module;
			$data['page'] = $this->config->item('backendpro_template_admin') . "admin_slideshow_edit";
			$slide = $this->MSlideshow->getslideshow($id);
            $data['slide'] = $slide;
            // get categories by lang
            //$lang_id = $slideshow['lang_id'];
			//$data['categories'] = $this->MCats->getCategoriesDropDownbyLang($lang_id);
			// I am not using colors and sizes any more. But they are available if you want to use them.
			//$data['assigned_colors'] = $this->Mslideshow->getAssignedColors($id);
			//$data['assigned_sizes'] = $this->Mslideshow->getAssignedSizes($id);
			// I am loading slideshow_right here which gives instructions.
			//$data['right'] = 'admin/slideshow_right';
			if (!count($data['slide'])){
				redirect('slideshow/admin/index','refresh');
			}
			// 	Set breadcrumb
			$this->bep_site->set_crumb($this->lang->line('kago_edit'),'slideshow/admin/edit');
			$data['header'] = $this->lang->line('backendpro_access_control');
			$data['module'] = $this->module;
			$this->load->view($this->_container,$data);
		}
  	}
 

}


?>