<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This Model is Loaded in MY_Controller
 *
 */
class MKaimonokago extends Base_model{


    function MKaimonokago(){
		parent::Base_model();
        
	}
/**
 * Used in playroom/controller/admin/index
 * @param string $module
 * @param array $fields
 * @param array $orderby
 * @return array
 */
    function getAll($module,$fields,$orderby,$lang_id=NULL){
        $string= '';
	    $module_table = 'omc_'.$module;
        $data = array();
        if(is_array($fields)){
            foreach ($fields as $field){
            $field = $module_table.".".$field;
            $string .= ",$field";
            }
        }  else {

        }
        
        $string =substr($string,1); // remove leading ","
        $this->db->select("$string,omc_languages.langname");
        /*
        $this->db->select("$module_table.id, $module_table.name,$module_table.parentid,$module_table.status,$module_table.table_id,$module_table.lang_id
         ,omc_languages.langname");
         *
         */
        if(is_array($orderby)){
             foreach ($orderby as $order){
                 $this->db->order_by("$order asc");
             }
         }else{
             $this->db->order_by("$orderby asc");
         }
         if(isset($lang_id)){
             $this->db->where('lang_id',$lang_id);
         }
         $this->db->join('omc_languages', $module_table.'.lang_id = omc_languages.id','left');
	     $Q = $this->db->get($module_table);
	     if ($Q->num_rows() > 0){
	       	foreach ($Q->result_array() as $row){
	         	$data[] = $row;
	       	}
	    }
	    $Q->free_result();
	    return $data;
	}


    function addItem($module,$data){
        $module_table = 'omc_'.$module;
		$this->db->insert($module_table, $data);

        if($_POST['table_id']==0){
            $this->addtableid($module_table);
        }
	 }

    function addtableid($module_table){
         $table_id = $this->db->insert_id();
         $data = array(
            'table_id' =>  $table_id,
            );

        $this->db->where('id', $table_id);
        $this->db->update($module_table, $data);
    }



    function updateItem($module,$data){
        $module_table = 'omc_'.$module;
        $this->db->where('id', id_clean($_POST['id']));
		$this->db->update($module_table, $data);
	 }




     function getAllDisplay($module, $lang_id=NULL,$checkfield,$value){
         $module_table = 'omc_'.$module;
         if(!$lang_id){
         $lang_id = '0';
         }
         // I don't want to show this root if there is already 0 under parentid with that lang_id
         // this can be different by module for now playroom, it is parentid

         $checkroot = $this->_checkroot($module_table, $lang_id,$checkfield,$value);
         if(!$checkroot==TRUE){
             $data[0] = 'root';
         }
         
         $this->db->where('parentid',0);
         $Q = $this->db->get_where($module_table,array('lang_id'=>$lang_id));

         if ($Q->num_rows() > 0){
           foreach ($Q->result_array() as $row){
             $data[$row['id']] = $row['name'];
           }
        }
        $Q->free_result();
        return $data; 
     }


     function _checkroot($module_table, $lang_id, $checkfield, $value){
        
        $Q = $this->db->get_where($module_table,array('lang_id'=>$lang_id, $checkfield=>$value));

         if ($Q->num_rows() > 0){
           foreach ($Q->result_array() as $row){
               return TRUE;
           }
        }
     }


    function changeStatus($module, $id){
        // getting status of page
        $tableinfo = array();
        // since the following uses getInfo which add omc_, here I use module
        $tableinfo = $this->getInfo($module,$id);
        $table='omc_'.$module;
        $status = $tableinfo['status'];
        if($status =='active'){

            $data = array('status' => 'inactive');
            $this->db->where('id', $id);
            $this->db->update($table, $data);

        }else{

            $data = array('status' => 'active');
            $this->db->where('id', $id);
            $this->db->update($table, $data);
        }

    }

    function getInfo($module, $id){
        $data = array();
        $table = "omc_".$module;
        $where = 'id';
        $options = array($where =>$id);
        $Q = $this->db->get_where($table,$options,1);
        if ($Q->num_rows() > 0){
          $data = $Q->row_array();
        }

        $Q->free_result();
        return $data;
    }
    
    
    function getTopItems($module, $lang_id=NULL,$checkfield,$value){
        $module_table = "omc_".$module;
        if(!$lang_id){
         $lang_id = '0';
         }
         $checkroot = $this->_checkroot($module_table, $lang_id,$checkfield,$value);
         if(!$checkroot==TRUE){
             $data[0] = 'root';
         }
         $this->db->where('parentid',0);
         $Q = $this->db->get_where($module_table,array('lang_id'=>$lang_id));

         if ($Q->num_rows() > 0){
           foreach ($Q->result_array() as $row){
             $data[$row['id']] = $row['name'];
           }
        }
        $Q->free_result();
        return $data;
    }





    function deleteitem($table, $id){
        // $data = array('status' => 'inactive');
	 	$this->db->where('id', $id)->delete($table);
    }

    /**
     * for pages module, $two is path of (parent/english) content
     * for menus module, $two is id
     * @param string $module
     * @param int $two
     * @param int $lang_id
     * @return bool
     */
    function checktrans($module, $two, $lang_id){
        // from menus, $two is omc_menus.id
        
        $data = array();
        $table = "omc_".$module;
        if($module =='pages'){
            $where = 'path';
        }elseif($module=='menus'){

            // should be menu_id??
            $where = 'page_uri_id';
        }elseif($module =='category'){
            $where = 'table_id';
        }

	    $Q = $this->db->get_where($table,array($where=>$two,'lang_id'=>$lang_id));
        if ($Q->num_rows() > 0){
           foreach ($Q->result_array() as $row){
             $data[$row['id']] = $row['name'];
           }
        }
        $Q->free_result();
        return $data;
    }

}

?>