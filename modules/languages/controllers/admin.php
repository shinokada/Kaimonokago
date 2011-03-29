<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Shop_Admin_Controller {
  function Admin(){
   	parent::Shop_Admin_Controller();
   	// Check for access permission
	check('Multi languages');
   	// load modules/languages/model/mlangs
   	$this->load->module_model('languages','MLangs');
        // Load needed files
        $this->lang->load('multi');
   	// Load modules/pages/models/MPages
	//$this->load->module_model('pages','MPages');
        // load modules/menus/model/mmenus
   	$this->load->module_model('menus','MMenus');
	// Set breadcrumb
	$this->bep_site->set_crumb($this->lang->line('backendpro_menus'),'mulitlang/admin');
    $table = 'omc_languages';

    }


  function index(){
    if ($this->input->post('langname')){
    // check if the same language does not exist.

        $langname = $this->input->post('langname');
    // check if there is the same in omc_languages

        $check_lang = $this->MLangs->check_lang($langname);
        //var_dump($check_course);
        if($check_lang==TRUE){
// there is the same language name, warn it

            flashMsg('warning',"You can't add the same language");
        }else{
// everything ok so insert a course
            $this->MLangs->addnewlang();
            //$this->session->set_flashdata('message','Course Created');
            flashMsg('message','Language Added');
        }
        flashMsg('success',$this->lang->line('kago_language_added'));
           redirect('languages/admin/index/','refresh');
  	}else{
   // there is no input, so let's display
    $data['title'] = "Manage Languages";
    // lagnage in session
    $session_lang = $this->session->userdata('lang');
    if ($session_lang){
        $data['lang'] = $session_lang;
    }else{// if there is no lang in session then it must be english
        $data['lang'] = 'english';
    }
    // get all languages to display
    $langs = $this->MLangs->getalllang();
    if($langs){
        $data['langs'] = $langs;
    }else{
        $data['langs'] = 'No other languages';
    }

    $tree = array();
    $parentid = 0;
    $this->MMenus->generateallTree($tree,$parentid);
    $data['navlist'] = $tree;
    $data['header'] = $this->lang->line('backendpro_access_control');
    $data['page'] = $this->config->item('backendpro_template_admin') . "admin_lang_home";
    $data['module'] = 'languages';
    $this->load->view($this->_container,$data);
        }
                
  }


 





}//end class
?>