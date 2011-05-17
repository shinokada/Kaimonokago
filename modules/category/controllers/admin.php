<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * modules/category/controllers/admin.php
 * Kaimonokago shopping cart on CodeIgniter
 * Author   Shin Okada
 * Contact okada.shin@gmail.com
 * version: 1.1.4 beta
 *
 *
 */

class Admin extends Shop_Admin_Controller {

private $module;


    function Admin(){
        parent::Shop_Admin_Controller();
        // Check for access permission
        check('Category');
        $this->load->model('MCats');
        $this->module=basename(dirname(dirname(__FILE__)));
        //$this->module='category';
        // Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('backendpro_category'),$this->module.'/admin');
        mb_internal_encoding('UTF-8');
        }


    function index(){
        $data['title'] = $this->lang->line('kago_category');
        $fields = array('id', 'name','parentid','status','table_id','lang_id');
        $orderby = array('lang_id','parentid','table_id');
        //$data['categories'] = $this->MCats->getAllCategories();
        $data['categories'] = $this->MKaimonokago->getAll($this->module,$fields, $orderby);
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_cat_home";
        $data['module'] = $this->module;
        $this->load->view($this->_container,$data);
  
    }

    function _fields(){
        $data = array(
		'name'      => db_clean($_POST['name']),
		'shortdesc' =>  db_clean($_POST['shortdesc']),
		'longdesc'  =>  db_clean($_POST['longdesc'],5000),
		'status'    =>  db_clean($_POST['status'],8),
		'parentid'  => id_clean($_POST['parentid']),
                'lang_id'   => id_clean($_POST['lang_id']),
                'table_id'  => id_clean($_POST['table_id'])
                );
        // $this->MKaimonokago->addItem($this->module, $data);
        return $data;
    }

    function create(){
        $this->bep_assets->load_asset_group('TINYMCE');

        if ($this->input->post('name')){
            //$this->MCats->addCategory();
            $data = $this-> _fields();
            $this->MKaimonokago->addItem($this->module, $data);
            $string = $this->input->post('name');
            // createdirname function is from plugin mytools.php
            $folder = createdirname($string);
            $folder = 'assets/images/'.$folder;
            create_path($folder);
            // we used to use like this. $this->session->set_flashdata('message','Category created');
            // now we are using Bep's flashMsg function to show messages.
            flashMsg('success',$this->lang->line('userlib_category_created'));
            //redirect($this->module.'/admin/index','refresh');
        }else{
            $data['title'] = "Create Category";
            $data['categories'] = $this->MCats->getTopCategories();
            //$data['right'] = 'admin/category_right';

            // Set breadcrumb
            $this->bep_site->set_crumb($this->lang->line('userlib_create')." category",'category/admin/create');

            $data['header'] = $this->lang->line('backendpro_access_control');

            // This is how BackendPro do
            $data['page'] = $this->config->item('backendpro_template_admin') . "admin_cat_create";
            $data['cancel_link']= $this->module."/admin/index/";
            $data['module'] = $this->module;
            $this->load->view($this->_container,$data);
        }
    }

    function edit($id=0){
        $this->bep_assets->load_asset_group('TINYMCE');
        $multilang = $this->preference->item('multi_language');
        $data['multilang']=$multilang;
        if ($this->input->post('name')){
            $data = $this-> _fields();
            $this->MKaimonokago->updateItem($this->module,$data);
            //$this->MCats->updateCategory();
            flashMsg('success',$this->lang->line('userlib_category_updated'));
            redirect('category/admin/index','refresh');
        }else{
        // similar to menus
                    $data['title'] = $this->lang->line('kago_edit')." ".$this->lang->line('kago_category');
        // get all the languages
        $data['languages'] =$this->MLangs->getLangDropDownWithId();
        // get translated languages
        // For other languages segment 4 is omc_categroy.table_id, table_id is id of english(original), omc_category.id
        // for english is omc_category.id
        // $table_id is used to find translated languages and it is used to get info of english menu
        $table_id = $this->uri->segment(4);
        // segment 5 is not used in category
        // segment 5 is omc_category.page_uri_id. page_uri_id is omc_pages.id which the menu is using for a page
        // page_uri_id is sent to a view. This is used to add page_uri_id in omc_menus.
        //$page_uri_id = $this->uri->segment(5);
        //$data['page_uri_id']= $page_uri_id;
        // translanguages shows translated languages by checking the same page_uri_id
        $data['translanguages'] =$this->MLangs->getTransLang($this->module,$table_id);
        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_cat_edit";
        $category = $this->MCats->getCategory($id);
        $data['category'] = $category;
        $data['module']=$this->module;

                    //$data['categories'] = $this->MCats->getTopCategories();
        $lang_id = $category['lang_id'];
        $data['categories'] = $this->MCats->getTopCategories($lang_id);
        $data['right'] = 'admin/category_right';
        if (!count($data['category'])){
                redirect('admin/category/index','refresh');
        }

        // Set breadcrumb
        $this->bep_site->set_crumb($this->lang->line('kago_edit'),'category/admin/edit');

        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['cancel_link']= $this->module."/admin/index/";
        $data['module'] = $this->module;
        $this->load->view($this->_container,$data);
            }
    }

    function delete($id){
    // delete button is hidden in the page, but
    // check if parentid is not 0
    $cate = $this->MCats->getCategory($id);
    $parentid = $cate['parentid'];
    if(!$parentid==0){
        $cat = $this->MCats->getCategory($id);
        $string = $cat['name'];
        $catname = createdirname($string);
        $catname = 'assets/images/'.$catname;
        recursive_remove_directory($catname, $empty=FALSE);

        $orphans = $this->MCats->checkOrphans($id);
        if (count($orphans)){
            $this->session->set_userdata('orphans',$orphans);
            redirect('category/admin/reassign/'.$id,'refresh');
        }else{
            $this->MCats->deleteCategory($id);

            flashMsg('success',$this->lang->line('userlib_category_deleted'));
            redirect('category/admin/index','refresh');
        }
    }  else {
        $this->MCats->deleteCategory($id);

            flashMsg('success',$this->lang->line('userlib_category_deleted'));
            redirect('category/admin/index','refresh');
    }
    }


    function export(){
            $this->load->helper('download');
            $csv = $this->MCats->exportCsv();
            $name = "category_export.csv";
            force_download($name,$csv);
     }


    function reassign($id=0){
            if ($_POST){
                    $this->load->module_model('products','MProducts');
                    $this->MProducts->reassignProducts();
                    $id = $this->input->post('id');
                    $this->MCats->deleteCategory($id); // this is not working at the moment.

                    flashMsg('success',$this->lang->line('userlib_category_reassigned'));
                    redirect('category/admin/index','refresh');
            }else{
                    //$id = $this->uri->segment(4);
                    $data['category'] = $this->MCats->getCategory($id);
                    $data['title'] = "Reassign Products";
                    $data['header'] = $this->lang->line('backendpro_access_control');
                    $data['categories'] = $this->MCats->getCategoriesDropDown();
                    // Set breadcrumb
                    $this->bep_site->set_crumb($this->lang->line('userlib_category_reassign'),'category/admin/reassign');


                    $data['page'] = $this->config->item('backendpro_template_admin') . "admin_cat_reassign";
                    $data['module'] = $this->module;
                    $this->load->view($this->_container,$data);
            }
    }


    function changeCatStatus($id){
            //$id = $this->uri->segment(4);
            $this->MCats->changeCatStatus($id);

            flashMsg('success',$this->lang->line('userlib_category_status'));
            redirect('category/admin/index','refresh');
    }


    function _remove_path($folder){

        $files = glob( $folder . DIRECTORY_SEPARATOR . '*');
        foreach( $files as $file ){
            if($file == '.' || $file == '..'){continue;}
            if(is_dir($file)){
                $this->_remove_path( $file );
            }else{
                unlink( $file );
            }
        }
        rmdir( $folder );
    }

    function langcreate(){
        $this->bep_assets->load_asset_group('TINYMCE');
        if ($this->input->post('name')){
            // info is filled out, so the followings
            $this->MCats->addCategory();
            // This is CI way to show flashdata
            // $this->session->set_flashdata('message','Page updated');
            // But here we use Bep way to display flash msg
            flashMsg('success',$this->lang->line('kago_translation_added'));
            redirect('category/admin/index','refresh');
        }else{

            // segment 4 is table_id
            $table_id = $this->uri->segment(4);
            // need to send it to a view for table_id
            $data['table_id']=$table_id;
            // page_uri_id is in segment 5
            //$page_uri_id = $this->uri->segment(5);
            //$data['page_uri_id']= $page_uri_id;
            // language id is in segment 5
            $lang_id = $this->uri->segment(5);
            $data['lang_id']=$lang_id;
            // no need for menu path
            //$path = $this->uri->segment(6);
            // check if there is no translation with this lang
            // this can use a model as well
            //$checktrans = $this->MKaimonokago->checktrans($this->module, $id, $lang_id);
            //if (count($checktrans)){
            // there is translation of this language
            //redirect with warning
            //flashMsg('warning',$this->lang->line('kago_translation_exists'));
            //redirect('menus/admin/index','refresh');
            //}
            // do normal thing
            // get all the languages
            $data['languages'] =$this->MLangs->getLangDropDownWithId();
            // get all the translated languages
            //$id =
            //$data['translanguages'] =$this->MLangs->getTransLang($this->module,$id);
            $data['translanguages'] =$this->MLangs->getTransLang($this->module,$table_id);
            //$data['translanguages'] =$this->MLangs->getTransLang($this->module,$page_uri_id);
            // get language info, langname. This will be used in Title
            $table ='languages';
            $selected_lang = $this->MKaimonokago->getinfo($table,$lang_id);
            $data['selected_lang']=  $selected_lang;
            // this must pull only pages where the segment 6 which is lang id
            // then use dropdown to select page
            // then use dropdown to select page
            //$data['pages'] = $this->MPages->getIdwithnone();
    /*
            $data['pages'] = $this->MPages->getIdwithnoneLang($lang_id);
            $lang_id = $this->uri->segment(6);
            $data['menus'] = $this->MMenus->getAllMenusDisplayByLang($lang_id);
    */      $data['category'] = $this->MCats->getCategory($table_id);
            // get category by lang
            //$data['categories'] = $this->MCats->getCategoriesbyLang($lang_id);
            $data['categories'] = $this->MCats->getTopCategories($lang_id);
            // set variables here
            $data['title'] = $this->lang->line('kago_add_translation').ucwords($selected_lang['langname']);
            $data['page'] = $this->config->item('backendpro_template_admin') . "admin_lang_create";
            // send the parent(English) field data to use it for other languages
            //$data['menu'] = $this->MMenus->getMenu($id);
            //if (!count($data['menu'])){
                // if page is not specified redirect to index
              //  flashMsg('warning',$this->lang->line('kago_no_exists'));
              //  redirect('menus/admin/index','refresh');
            //}
            $selected_lang=ucfirst($selected_lang['langname']);// using this in bread crumb
            //$data['menus'] = $this->MMenus->getAllMenusDisplay();
            // Set breadcrumb
            $this->bep_site->set_crumb($this->lang->line('kago_edit_home'),'menus/admin/edit/');
            //$this->bep_site->set_crumb($this->lang->line('kago_add_translation').$selected_lang,'menus/admin/edit/'.$id."/".$lang_id);
            $data['header'] = $this->lang->line('backendpro_access_control');
            $data['cancel_link']= $this->module."/admin/index/";
            $data['module'] = $this->module;
            $this->load->view($this->_container,$data);
        }
    }
 
}//end class
?>
