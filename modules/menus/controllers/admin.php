<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * modules/menus/controllers/admin.php
 * Kaimonokago shopping cart on CodeIgniter
 * Author   Shin Okada
 * Contact okada.shin@gmail.com
 * version: 1.1.4 beta
 *
 *
 */
// menu_id in db is used to find translated languages in $data['translanguages'] =$this->MLangs->getTransLang($this->module,$menu_id);


class Admin extends Shop_Admin_Controller {

    private $module;


    function Admin(){
        parent::Shop_Admin_Controller();
        // Check for access permission
        check('Menus');
        // define this module which will be used later
        $this->module=basename(dirname(dirname(__FILE__)));
        // load modules/menus/model/mmenus
        $this->load->module_model('menus','MMenus');
        // Load modules/pages/models/MPages
        $this->load->module_model('pages','MPages');
        // Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('backendpro_menus'),$this->module.'/admin');
    }
  

  function index(){
        $data['title'] = $this->lang->line('kago_manage'). " ". $this->lang->line('kago_menu');
        $tree = array();
        $parentid = 0;
        //$this->MMenus->generateallTreewithUriId($tree,$parentid);
        $this->MMenus->generateallTree($tree,$parentid);
        $data['navlist'] = $tree;
        // get pages which is used to show page_uri where page_uri_id = id
        //$pages =$this->MPages->getIdwithnone();
        $pages =$this->MPages->getIdwithnoneAll();
        $data['pages']=$pages;
        $data['languages'] =$this->MLangs->getLangDropDownWithId();
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_menu_home";
        $data['module'] = $this->module;
        $this->load->view($this->_container,$data);
  }


    function _fields(){
        $data = array(
            'name'          => db_clean($_POST['name']),
            'shortdesc'     =>  db_clean($_POST['shortdesc']),
            'status'        =>  db_clean($_POST['status'],8),
            'parentid'      => id_clean($_POST['parentid']),
            'order'         => id_clean($_POST['order'],10),
            'page_uri_id'   =>  db_clean($_POST['page_uri_id']),
            'lang_id'       =>  db_clean($_POST['lang_id']),
            'menu_id'       =>  db_clean($_POST['menu_id'])
        );
        // $this->MKaimonokago->addItem($this->module, $data);
        return $data;
    }


    function create(){
        // Since create function is used for English, it should show only English menus
        // This is used in admin/menus, when you click Create new menu, then this is called
        // 'parentid' ,'0' is in hidden in views/admin_menu_create.php
        if ($this->input->post('name')){
            /*
            $data = array(
            'name' => db_clean($_POST['name']),
            'shortdesc' =>  db_clean($_POST['shortdesc']),
            'status' =>  db_clean($_POST['status'],8),
            'parentid' => id_clean($_POST['parentid']),
            'order' => id_clean($_POST['order'],10),
            'page_uri_id' =>  db_clean($_POST['page_uri_id']),
            'lang_id' =>  db_clean($_POST['lang_id']),
            'menu_id' =>  db_clean($_POST['menu_id'])
            );
             * 
             */
            $data = $this-> _fields();
            $this->MKaimonokago->addItem($this->module, $data);
            //$this->MMenus->addMenu();
            //$this->session->set_flashdata('message','Menu created');
            flashMsg('success',$this->lang->line('kago_created'));
            redirect($this->module.'/admin/index','refresh');
  	}else{
            $data['title'] = "Create Menu";
        // need to show only english menus
	  	//$data['menus'] = $this->MMenus->getAllMenusDisplay();
            $lang_id ='0';
            $data['menus'] = $this->MMenus->getAllMenusDisplayByLang($lang_id);
            // this need to be id => page_uri, currently page_uri=>page_uri
            // it is better to store id. if you change the page uri then it does not show the change
            // if you store the page_uri
            // this means index page need to be changed to show uri rather than id
            //$data['pages'] = $this->MPages->getAllPathwithnone();

            $data['pages'] = $this->MPages->getIdwithnone();
            // Set breadcrumb
            $this->bep_site->set_crumb($this->lang->line('kago_create'),$this->module.'/admin/create');

            $data['header'] = $this->lang->line('backendpro_access_control');
            $data['cancel_link']= $this->module."/admin/index/";
            $data['page'] = $this->config->item('backendpro_template_admin') . "admin_menu_create";
            $data['module'] = $this->module;
            $this->load->view($this->_container,$data);
	} 
  }



  function edit($id=0){
    // This is for editing Menu, such as Main menu etc
        $multilang = $this->preference->item('multi_language');
        $data['multilang']=$multilang;
  	if ($this->input->post('name')){
            $data = $this-> _fields();
            $this->MKaimonokago->updateItem($this->module,$data);
            //$this->MMenus->updateMenu();
            $this->session->set_flashdata('message','Menu updated');
            flashMsg('success',$this->lang->line('kago_updated'));
            redirect($this->module.'/admin/index','refresh');
  	}else{
	// if segment 6 is 0 then it is English
        // for English, it has structure of menus/admin/edit/' .  $row['id'] .'/'.$row['page_uri_id'].'/'.$row['lang_id']
        // for other language it has structure of menus/admin/edit/' .  $row['menu_id'] .'/'.$row['page_uri_id'].'/'.$row['lang_id'].'/'.$row['id']
        $data['title'] = $this->lang->line('kago_edit')." ".$this->lang->line('kago_menu');
        // pull all the languages
        $data['languages'] =$this->MLangs->getLangDropDownWithId();
        // get all the translated languages
        // For other languages segment 4 is omc_menus.menu_id, menu_id is id of english(original), omc_menu.id
        // for english is omc_menus.id
        // $menu_id is used to find translated languages and it is used to get info of english menu
        $menu_id = $this->uri->segment(4);
        // segment 5 is omc_menus.page_uri_id. page_uri_id is omc_pages.id which the menu is using for a page
        // page_uri_id is sent to a view. This is used to add page_uri_id in omc_menus.
        $page_uri_id = $this->uri->segment(5);
        $data['page_uri_id']= $page_uri_id;
        // translanguages shows translated languages by checking the same page_uri_id
        $data['translanguages'] =$this->MLangs->getTransLang($this->module,$menu_id);

        // $data['main'] = 'admin_menu_edit';
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_menu_edit";

        //$data['menu'] = $this->MMenus->getMenuwithPage($id);
        // $menus will be used for a dropdown which you select a parent menu
        // segment 6 is omc_menus.lang_id for other languages and omc_menus.id for English
        // both have the same id
        $lang_id = $this->uri->segment(6);
        // this should show only the same language
		//$data['menus'] = $this->MMenus->getAllMenusDisplay();
        $data['menus'] = $this->MMenus->getAllMenusDisplayByLang($lang_id);
        //$data['pages'] = $this->MPages->getIdwithnone();
        $data['pages'] = $this->MPages->getIdwithnoneLang($lang_id);
		//$data['pages'] = $this->MPages->getAllPathwithnone();
		
        // get menu details for other language

        // if segment 6 is not 0 then they are not English
        if(!$lang_id =='0'){
        // segment 7 which is omc_menu.id is added if they are not English which has lang_id 0.
        $id = $this->uri->segment(7);
        }else{
            // otherwise use menu_id for english
            $id = $menu_id;
        }
        $data['menu'] = $this->MMenus->getMenu($id);
        /**
        if (!count($data['menu'])){
            flashMsg('success',$this->lang->line('kago_no_exist'));
			redirect($this->module.'/admin/index','refresh');
		}
         * 
         */
        $data['header'] = $this->lang->line('backendpro_access_control');

        // Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('kago_edit'),$this->module.'/admin/edit');
        $data['cancel_link']= $this->module."/admin/index/";
        $data['module'] = $this->module;
        $this->load->view($this->_container,$data);
	}
  }
  
    function deleteMenu($id){

        // This will be called to delete a menu(not sub-menu item).
        //$id = $this->uri->segment(4);

        // delete button is hidden in the page, but
        // check if parentid is not 0
        $menu = $this->MMenus->getMenu($id);
        $parentid = $menu['parentid'];
        if(!$parentid==0){
            $orphans = $this->MMenus->checkMenuOrphans($id);
            if (count($orphans)){
                $this->session->set_userdata('orphans',$orphans);
                flashMsg('success',$this->lang->line('kago_reassing'));
                redirect($this->module.'/admin/reassign/'.$id,'refresh');
            }else{
                $this->MMenus->deleteMenu($id);
                $this->session->set_flashdata('message','Menu deleted');
                flashMsg('success',$this->lang->line('kago_deleted'));
                redirect($this->module.'/admin/index','refresh');
            }
        }
    }
  
  function changeMenuStatus($id){
    
	$orphans = $this->MMenus->checkMenuOrphans($id);
	if (count($orphans)){
		$this->session->set_userdata('orphans',$orphans);
		redirect($this->module.'/admin/reassign/'.$id,'refresh');
	}else{
		$this->MMenus->changeMenuStatus($id);
		$this->session->set_flashdata('message','Menu status changed');
		redirect($this->module.'/admin/index','refresh');
	}
  }
  
  
  function export(){
  	$this->load->helper('download');
  	$csv = $this->MMenus->exportCsv();
  	$name = "Menu_export.csv";
  	force_download($name,$csv);

  }

  function reassign($id=0){
    // This is called when you delete one of menu from deleteMenu() function above.
      if ($_POST){
        $this->MMenus->reassignMenus();
        $this->session->set_flashdata('message','Menu deleted and sub-menus reassigned');
        redirect($this->module.'/admin/index','refresh');
        }else{
        //$id = $this->uri->segment(4);
        $menu = $this->MMenus->getMenu($id);
        $data['menu'] = $menu;
        $data['title'] = "Reassign Sub-menus";
        // this one must be get other menus in the language
        //$data['menus'] = $this->MMenus->getrootMenus();
        $lang_id = $menu['lang_id'];
        $data['menus'] = $this->MMenus->getAllMenusDisplayByLang($lang_id);
        $this->MMenus->deleteMenu($id);
        // Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('userlib_menu_reassign'),$this->module.'/admin/reassign');
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_submenu_reassign";
        $data['module'] = $this->module;
        $this->load->view($this->_container,$data);
        }
    }


    function langcreate(){
        if ($this->input->post('name')){
            // info is filled out, so the followings
             $data = $this-> _fields();
             $this->MKaimonokago->addItem($this->module, $data);
            //$this->MMenus->addMenu();
            // This is CI way to show flashdata
            // $this->session->set_flashdata('message','Page updated');
            // But here we use Bep way to display flash msg
            flashMsg('success',$this->lang->line('kago_translation_added'));
            redirect($this->module.'/admin/index','refresh');
        }else{
            // omc_menus.id is in segment 4
            $id = $this->uri->segment(4);
            // need to send it to a view for content id
            // not used
            $data['content_id']=$id;
            // page_uri_id is in segment 5
            $page_uri_id = $this->uri->segment(5);
            $data['page_uri_id']= $page_uri_id;
            // language id is in segment 6
            $lang_id = $this->uri->segment(6);
            $data['lang_id']=$lang_id;
            // no need for menu path
            //$path = $this->uri->segment(6);
            // check if there is no translation with this lang
            // this can use a model as well
            $checktrans = $this->MKaimonokago->checktrans($this->module, $id, $lang_id);
            if (count($checktrans)){
            // there is translation of this language
            //redirect with warning
            flashMsg('warning',$this->lang->line('kago_translation_exists'));
            redirect($this->module.'/admin/index','refresh');
            }
            // do normal thing
            // get all the languages
            $data['languages'] =$this->MLangs->getLangDropDownWithId();
            // get all the translated languages
            //$data['translanguages'] =$this->MLangs->getTransLang($this->module,$id);
            $data['translanguages'] =$this->MLangs->getTransLang($this->module,$id);
            //$data['translanguages'] =$this->MLangs->getTransLang($this->module,$page_uri_id);
            // get language info, langname. This will be used in Title
            $table ='languages';
            $selected_lang = $this->MKaimonokago->getinfo($table,$lang_id);
            // just for checking in a view. You don't need to have this.
            $data['selected_lang']=  $selected_lang;
            // this must pull only pages where the segment 6 which is lang id
            // then use dropdown to select page
            // then use dropdown to select page
            //$data['pages'] = $this->MPages->getIdwithnone();
            $data['pages'] = $this->MPages->getIdwithnoneLang($lang_id);
            $lang_id = $this->uri->segment(6);
            $data['menus'] = $this->MMenus->getAllMenusDisplayByLang($lang_id);
            // set variables here
            $data['title'] = $this->lang->line('kago_add_translation').ucwords($selected_lang['langname']);
            $data['page'] = $this->config->item('backendpro_template_admin') . "admin_lang_create";
            // send the parent(English) field data to use it for other languages
            $data['menu'] = $this->MMenus->getMenu($id);
            $selected_lang=ucfirst($selected_lang['langname']);// using this in bread crumb
            //$data['menus'] = $this->MMenus->getAllMenusDisplay();
            // Set breadcrumb
            $this->bep_site->set_crumb($this->lang->line('kago_edit_home'),$this->module.'/admin/edit/'.$id);
            $this->bep_site->set_crumb($this->lang->line('kago_add_translation').$selected_lang,$this->module.'/admin/edit/'.$id."/".$lang_id);
            $data['header'] = $this->lang->line('backendpro_access_control');
            $data['cancel_link']= $this->module."/admin/edit/".$id;
            $data['module'] = $this->module;
            $this->load->view($this->_container,$data);
        }
    }
    
    


	
}//end class
?>
