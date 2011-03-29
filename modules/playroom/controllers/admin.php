<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Shop_Admin_Controller {

    private $module;

	function Admin(){
		   parent::Shop_Admin_Controller();
		   // Check for access permission
			check('Playroom');
            $this->module=basename(dirname(dirname(__FILE__))); // playroom
			// Load modules/playroom/models/MPlayroom
			$this->load->module_model($this->module,'MPlayroom');
            $this->load->module_model('kaimonokago','MKaimonokago');
			// Load pages model
			//$this->load->model('MPages');
			// Set breadcrumb
			$this->bep_site->set_crumb($this->lang->line('kago_playroom'),$this->module.'/admin');
	}


	function index(){
            // we use the following variables in the view
            $data['title'] = $this->lang->line('kago_playroom');
            $fields = array('id', 'name','parentid','status','table_id','lang_id');
            $orderby = array('lang_id','parentid','table_id');
            $data['playrooms'] = $this->MKaimonokago->getAll($this->module,$fields, $orderby);
            $data['languages'] =$this->MLangs->getLangDropDownWithId();
            $data['header'] = $this->lang->line('backendpro_access_control');
            // This how Bep load views
            $data['page'] = $this->config->item('backendpro_template_admin') . "admin_home";
            $data['module'] = $this->module;
            $this->load->view($this->_container,$data);
	}


	function create(){
		// We need TinyMCE, so load it
	  	$this->bep_assets->load_asset_group('TINYMCE');
	   	if ($this->input->post('name')){
	   		// if info is filled in then do this
            // send playroom 
            $data = array(
                'name' => db_clean($_POST['name']),
                'shortdesc' =>  db_clean($_POST['shortdesc']),
                'longdesc' =>  db_clean($_POST['longdesc'],5000),
                'image' =>  db_clean($_POST['image']),
                'status' =>  db_clean($_POST['status'],8),
                'parentid' => id_clean($_POST['parentid']),
                'lang_id' => id_clean($_POST['lang_id']),
                'table_id' => id_clean($_POST['table_id'])
            );
	  		$this->MKaimonokago->addItem($this->module, $data);
	  		// This is CI way to show flashdata
	  		// $this->session->set_flashdata('message','Page created');
	  		// But here we use Bep way to display flash msg
	  		flashMsg('success',$this->lang->line('kago_page_created'));
	  		// and redirect to this index page
	  		redirect($this->module.'/admin/index','refresh');
	  	}else{
	  		// this must be first visit to the creat page
			$data['title'] = $this->lang->line('kago_create')." ".$this->lang->line('kago_activity');
			// create English in this create(), so $lang_id = 0
            $lang_id = 0;
            // $checkfield and $value will be used to check parentid 0 exist or not
            // if it exist root won't be shown
            $checkfield='parentid';
            $value = 0;
            $data['plays'] = $this->MKaimonokago->getAllDisplay($this->module, $lang_id,$checkfield,$value);

			// Set breadcrumb
			$this->bep_site->set_crumb($this->lang->line('kago_create'),'pages/admin/create');
			$data['header'] = $this->lang->line('backendpro_access_control');
			// Setting up page and telling which module
			$data['page'] = $this->config->item('backendpro_template_admin') . "admin_create";
            
			$data['module'] = $this->module;
			$this->load->view($this->_container,$data);
		}
	}


	function edit(){
			$this->bep_assets->load_asset_group('TINYMCE');

	  	if ($this->input->post('name')){
            if($_POST['lang_id']){
                $lang_id = $_POST['lang_id'];
            }  else {
                $lang_id = 0;
            }
            $data = array(
                'name' => db_clean($_POST['name']),
                'shortdesc' =>  db_clean($_POST['shortdesc']),
                'longdesc' =>  db_clean($_POST['longdesc'],5000),
                'image' =>  db_clean($_POST['image']),
                'status' =>  db_clean($_POST['status'],8),
                'parentid' => id_clean($_POST['parentid']),
                'lang_id' => $lang_id,
                'table_id' => id_clean($_POST['table_id'])
            );
	  		$this->MKaimonokago->updateItem($this->module, $data);

	  		flashMsg('success',$this->lang->line('userlib_category_updated'));
	  		redirect($this->module.'/admin/index','refresh');
	  	}else{
            // similar to menus
			$data['title'] = $this->lang->line('kago_edit')." ".$this->lang->line('kago_activity');
            // get all the languages
            $data['languages'] =$this->MLangs->getLangDropDownWithId();
            // get translated languages
            // For other languages segment 4 is omc_categroy.cat_id, cat_id is id of english(original), omc_category.id
            // for english is omc_category.id
            // $cat_id is used to find translated languages and it is used to get info of english menu
            $id = $this->uri->segment(4);
            // segment 5 is not used in category
            // segment 5 is omc_category.page_uri_id. page_uri_id is omc_pages.id which the menu is using for a page
            // page_uri_id is sent to a view. This is used to add page_uri_id in omc_menus.
            //$page_uri_id = $this->uri->segment(5);
            //$data['page_uri_id']= $page_uri_id;
            // translanguages shows translated languages by checking the same page_uri_id
            $data['translanguages'] =$this->MLangs->getTransLang($this->module,$id);
			$data['page'] = $this->config->item('backendpro_template_admin') . "admin_edit";
			$info = $this->MKaimonokago->getInfo($this->module, $id);
            $data['info'] = $info;
            $data['module']=$this->module;

			//$data['categories'] = $this->MCats->getTopCategories();
            $lang_id = $info['lang_id'];
            // $checkfield and $value will be used to check parentid 0 exist or not
            // if it exist root won't be shown
            $checkfield='parentid';
            $value = 0;
            $data['items'] = $this->MKaimonokago->getTopItems($this->module, $lang_id,$checkfield,$value);
			//$data['right'] = 'admin/category_right';
			if (!count($data['info'])){
				redirect($this->module.'/admin/index','refresh');
			}

			// Set breadcrumb
			$this->bep_site->set_crumb($this->lang->line('kago_edit'),$this->module.'/admin/edit');

			$data['header'] = $this->lang->line('backendpro_access_control');
			$data['module'] = $this->module;
			$this->load->view($this->_container,$data);
		}
	}


    function langcreate(){

        // we are using TinyMCE here, so load it.
        $this->bep_assets->load_asset_group('TINYMCE');
        if ($this->input->post('name')){
            if($_POST['lang_id']){
                $lang_id = $_POST['lang_id'];
            }  else {
                $lang_id = 0;
            }
            // info is filled out, so the followings
             $data = array(
                'name' => db_clean($_POST['name']),
                'shortdesc' =>  db_clean($_POST['shortdesc']),
                'longdesc' =>  db_clean($_POST['longdesc'],5000),
                'image' =>  db_clean($_POST['image']),
                'status' =>  db_clean($_POST['status'],8),
                'parentid' => id_clean($_POST['parentid']),
                'lang_id' => $lang_id,
                'table_id' => id_clean($_POST['table_id'])
            );
            $this->MKaimonokago->addItem($this->module, $data);
            // This is CI way to show flashdata
            // $this->session->set_flashdata('message','Page updated');
            // But here we use Bep way to display flash msg
            flashMsg('success',$this->lang->line('kago_translation_added'));
            redirect($this->module.'/admin/index','refresh');
        }else{

            // id of content is segment 4
            $id = $this->uri->segment(4);
            // need to send it to a view for content id
            $data['content_id']=$id;

            // language id is segment 5
            $lang_id = $this->uri->segment(5);
            $data['lang_id']=$lang_id;

            // check if there is no translation with this lang
            // this can use a model as well
           /*
            $checktrans =$this->MKaimonokago->checktrans($this->module,$id, $lang_id);
            if (count($checktrans)){
            //redirect with warning
           // flashMsg('warning',$this->lang->line('kago_translation_exists'));
            redirect($this->module.'/admin/index','refresh');
            }
            * 
            */
            // do normal thing
            // get all the languages
            $data['languages'] =$this->MLangs->getLangDropDownWithId();
            $data['translanguages'] =$this->MLangs->getTransLang($this->module,$id);
            // get language info, langname. This will be used in Title
            $table ='languages';
            $selected_lang = $this->MKaimonokago->getinfo($table,$lang_id);
            $data['selected_lang']=  $selected_lang;
            // set variables here
            $data['title'] = $this->lang->line('kago_add_translation').ucwords($selected_lang['langname']);
            $data['page'] = $this->config->item('backendpro_template_admin') . "admin_lang_create";
            $checkfield='parentid';
            $value = 0;
            $data['plays'] = $this->MKaimonokago->getAllDisplay($this->module, $lang_id,$checkfield,$value);

           // $data['plays'] = $this->MKaimonokago->getAllDisplay($this->module,$lang_id);
            $info = $this->MKaimonokago->getInfo($this->module, $id);
            $data['info'] = $info;
            if (!count($data['info'])){
                // if page is not specified redirect to index
                flashMsg('warning',$this->lang->line('kago_no_exist'));
                redirect($this->module.'/admin/index','refresh');
            }
            $selected_lang=ucfirst($selected_lang['langname']);// using this in bread crumb
            //$data['menus'] = $this->MMenus->getAllMenusDisplay();
            // Set breadcrumb
            $this->bep_site->set_crumb($this->lang->line('kago_edit'),'pages/admin/edit/'.$id);
            //$this->bep_site->set_crumb($this->lang->line('kago_add_translation').$selected_lang,'pages/admin/edit/'.$id."/".$lang_id);
            $data['header'] = $this->lang->line('backendpro_access_control');
            $data['module'] = $this->module;
            $this->load->view($this->_container,$data);
        }
	}



}//end class
?>