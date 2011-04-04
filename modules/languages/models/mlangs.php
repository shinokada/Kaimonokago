<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MLangs extends Base_model{

    function MLangs(){
          parent::Base_model();
          $table = 'omc_languages';
          $this->_TABLES = array(    'Langs' => 'omc_languages',
                                    );
      }

    function getalllang(){
      // getting all the products of the same categroy.
        $data = array();
        $Q = $this->db->get($this->_TABLES['Langs']);
            if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
            $data[] = $row;
           }
        }
        $Q->free_result();
        return $data;
    }

    

    function check_lang($langname=NULL){

    $Q = $this->db->get_where($this->_TABLES['Langs'],array('langname' => $langname));
    if ($Q->num_rows() > 0){
            $data = TRUE;
        }else{
            $data = FALSE;
        }
    $Q->free_result();
    return $data;
    }


    function addnewlang(){
      // save it in lower case in db
      $langname = strtolower($this->input->post('langname'));
      $this->insert('Langs',array('langname'=>$langname));
    }


    function getLangDropDown(){
        $data = array();
        $data[''] = 'Select Language';
        $data['english'] = ucwords('english');
        $Q = $this->db->get_where($this->_TABLES['Langs'], array('status'=>'active'));
            if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                $data[$row['langname']] = ucwords($row['langname']);
                }
            }
        $Q->free_result();
        return $data; 
    }


    function getLangDropDownWithId(){
        $data = array();
        $data[0] = ucwords('english');
        $Q = $this->db->get_where($this->_TABLES['Langs'], array('status'=>'active'));
            if ($Q->num_rows() > 0){
                foreach ($Q->result_array() as $row){
                $data[$row['id']] = ucwords($row['langname']);
                }
            }
        $Q->free_result();
        return $data;
    }
/**
 * This will return translated language 
 * @param string $path
 * @return array
 */
    function getTransLang($module, $path){
        $data = array();
        $table = 'omc_'.$module;
        $this->db->join($table, "$table.lang_id = omc_languages.id", 'left');
        if ($module=='pages'){
           // $this->db->join($table, 'omc_pages.lang_id = omc_languages.id', 'left');
            //$Q = $this->db->get_where('omc_languages', array('omc_pages.path' => $path));
            $table_field = $table.".path";
        }  elseif ($module=='menus') {
           // $this->db->join($table, 'omc_menus.lang_id = omc_languages.id', 'left');
            //$Q = $this->db->get_where('omc_languages', array('omc_menus.menu_id' => $path));
             $table_field = $table.".menu_id";
        }elseif ($module == 'category'){
           // $this->db->join($table, 'omc_category.lang_id = omc_languages.id', 'left');
           // $Q = $this->db->get_where('omc_languages', array('omc_category.table_id' => $path));
             $table_field = $table.".table_id";
        }elseif ($module == 'products'){
            // $this->db->join($table, 'omc_products.lang_id = omc_languages.id', 'left');
            //$Q = $this->db->get_where('omc_languages', array('omc_products.product_id' => $path));
             $table_field = $table.".table_id";
        }elseif($module == 'playroom'){
             $table_field = $table.".table_id";
        }

        $Q = $this->db->get_where('omc_languages', array($table_field => $path));
        if ($Q->num_rows() > 0){

            foreach ($Q->result_array() as $row){
            $data[$row['id']] = ucwords($row['langname']);
            }
        }
        $Q->free_result();
        return $data;
    }
    

    function getId($language){
        $data = array();
        $Q = $this->db->get_where($this->_TABLES['Langs'],array('langname'=>$language));
            if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
            $data = $row;
           }
        }
        $Q->free_result();
        return $data;
    }

}
