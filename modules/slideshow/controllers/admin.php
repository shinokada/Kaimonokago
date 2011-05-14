<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Shop_Admin_Controller {

    private $module;

    function Admin(){
        parent::Shop_Admin_Controller();
        // Check for access permission
        check('Slideshow');
        // load the MSlideshow model
        //$this->load->model('MSlideshow');
        $this->module=basename(dirname(dirname(__FILE__)));
        //$this->module='slideshow';
        // Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('backendpro_slideshow'),$this->module.'/admin');
    }
  
  	
    function index(){
        // Setting variables
        $data['title'] = "Manage Slideshow";
        $data['slideshow'] = $this->MKaimonokago->getAllSimple($this->module);
        //$data['slideshow'] = $this->MSlideshow->getAllslideshow();
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_slideshow_home";
        $data['module'] = $this->module;
        $this->load->view($this->_container,$data);
    }


    function _feild(){
        $data = array(
            'name'          => db_clean($_POST['name']),
            'shortdesc'     => db_clean($_POST['shortdesc']),
            'longdesc'      => db_clean($_POST['longdesc'],5000),
            'status'        => db_clean($_POST['status'],8),
            'slide_order'   => db_clean($_POST['slide_order']),
            'thumbnail'     => db_clean($_POST['thumbnail']),
            'image'         => db_clean($_POST['image']),
        );
        return $data;
    }


    function create(){
    // we are using TinyMCE in this page, so load it
    $this->bep_assets->load_asset_group('TINYMCE');

    if ($this->input->post('name')){
        // fields are filled up so do the followings
        $data = $this->_feild();
        $this->MKaimonokago->addItem($this->module,$data);
        flashMsg('success','slideshow created');
        redirect($this->module.'/admin/index','refresh');
    }else{
        // this must be the first time, so set variables
        $data['title'] = "Create slideshow";
        $lang_id = '0';
        // Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('kago_create'),$this->module.'/admin/create');
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_slideshow_create";
        $data['cancel_link']= $this->module."/admin/index/";
        $data['module'] = $this->module;
        $this->load->view($this->_container,$data);
    }
}


    function edit($id=0){
        // we are using TinyMCE in edit as well
        $this->bep_assets->load_asset_group('TINYMCE');
        if ($this->input->post('name')){
            // fields filled up so,
            $data = $this->_feild();
            $this->MKaimonokago->updateItem($this->module,$data);
            flashMsg('success','slideshow updated');
            redirect($this->module.'/admin/index','refresh');
        }else{
        // similar to category
        //$id = $this->uri->segment(4);
        $data['title'] = $this->lang->line('kago_edit')." ".$this->lang->line('kago_slideshow');
        $data['module']=$this->module;
        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_slideshow_edit";
        $slide = $this->MKaimonokago->getInfo($this->module, $id);
        //$slide = $this->MSlideshow->getslideshow($id);
        $data['slide'] = $slide;
        if (!count($data['slide'])){
            redirect($this->module.'/admin/index','refresh');
        }
        // 	Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('kago_edit'),$this->module.'/admin/edit');
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['cancel_link']= $this->module."/admin/index/";
        $data['module'] = $this->module;
        $this->load->view($this->_container,$data);
        }
    }


}


?>