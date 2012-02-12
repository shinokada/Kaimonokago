<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// menu_id in db is used to find translated languages in $data['translanguages'] =$this->MLangs->getTransLang($this->module,$menu_id);


class MMenus extends Model{

  function MMenus(){
          parent::Model();
      }

  function generateTree(&$tree, $parentid = 0) {
         $this->db->select('id,name,shortdesc,status,parentid,order,lang_id');
         $this->db->where ('parentid',$parentid);
		 $this->db->where ('status','active');
         $this->db->order_by('order asc, parentid asc'); 
         $res = $this->db->get('omc_menus');
         if ($res->num_rows() > 0) {
             foreach ($res->result_array() as $r) {
                
				// push found result onto existing tree
                $tree[$r['id']] = $r;
                // create placeholder for children
                $tree[$r['id']]['children'] = array();
                // find any children of currently found child
                $this->generateTree($tree[$r['id']]['children'],$r['id']);
             }
         }
     }


     function generateTreewithLang(&$tree, $parentid = 0,$lang_id) {
         $this->db->select('id,name,shortdesc,status,parentid,order,page_uri_id, lang_id');
        // $lang_id = 1;
         $this->db->where ('parentid',$parentid);
         $this->db->where ('lang_id',$lang_id);
		 $this->db->where ('status','active');
         $this->db->order_by('order asc, parentid asc');
         $res = $this->db->get('omc_menus');
         if ($res->num_rows() > 0) {
             foreach ($res->result_array() as $r) {
				// push found result onto existing tree
                $tree[$r['id']] = $r;
                // create placeholder for children
                $tree[$r['id']]['children'] = array();
                // find any children of currently found child
                $this->generateTreewithLang($tree[$r['id']]['children'],$r['id'],$lang_id);
             }
         }
     }

    function generateTreewithLangUri(&$tree, $parentid = 0,$lang_id) {
        // $this->db->select('id,name,shortdesc,status,parentid,page_uri,order,page_uri_id, $lang_id');
        // $lang_id = 1;
        $this->db->select('omc_menus.id AS menusid,omc_menus.name,omc_menus.shortdesc,omc_menus.status
          ,omc_menus.parentid,omc_menus.order,omc_menus.lang_id,omc_menus.page_uri_id
          , omc_pages.id AS pagesid, omc_pages.name,omc_pages.path');
        $this->db->where ('omc_menus.parentid',$parentid);
        $this->db->where ('omc_menus.lang_id',$lang_id);
        $this->db->where ('omc_menus.status','active');
        $this->db->order_by('omc_menus.order asc, omc_menus.parentid asc');
        $this->db->join("omc_pages", "omc_pages.id = omc_menus.page_uri_id");
        $res = $this->db->get('omc_menus');
        if ($res->num_rows() > 0) {
             foreach ($res->result_array() as $r) {

				// push found result onto existing tree
                $tree[$r['omc_menus.id']] = $r;
                // create placeholder for children
                $tree[$r['omc_menus.id']]['children'] = array();
                // find any children of currently found child
                $this->generateTreewithLangUri($tree[$r['omc_menus.id']]['children'],$r['omc_menus.id'],$lang_id);
             }
         }
     }

  function generateallTree(&$tree, $parentid = 0) {
         //$this->db->select('id,name,shortdesc,status,parentid,page_uri,order');
         $this->db->where ('parentid',$parentid);
         $this->db->order_by('order asc, parentid asc, page_uri_id asc');
         $res = $this->db->get('omc_menus');
         if ($res->num_rows() > 0) {
             foreach ($res->result_array() as $r) {
                
				// push found result onto existing tree
                $tree[$r['id']] = $r;
                // create placeholder for children
                $tree[$r['id']]['children'] = array();
                // find any children of currently found child
                $this->generateallTree($tree[$r['id']]['children'],$r['id']);
             }
         }
     }


      function generateallTreebyLang(&$tree, $parentid = 0,$lang_id) {
         //$this->db->select('id,name,shortdesc,status,parentid,page_uri,order');
         $this->db->where ('parentid',$parentid);
         $this->db->where ('lang_id',$lang_id);
         $this->db->order_by('order asc, parentid asc, page_uri_id asc');
         $res = $this->db->get('omc_menus');
         if ($res->num_rows() > 0) {
             foreach ($res->result_array() as $r) {

				// push found result onto existing tree
                $tree[$r['id']] = $r;
                // create placeholder for children
                $tree[$r['id']]['children'] = array();
                // find any children of currently found child
                $this->generateallTree($tree[$r['id']]['children'],$r['id']);
             }
         }
     }


    function generateallTreewithUriId(&$tree, $parentid = 0) {
/*
        $this->db->select('omc_menus.id AS menusid,omc_menus.name,omc_menus.shortdesc,omc_menus.status
          ,omc_menus.parentid,omc_menus.order,omc_menus.lang_id,omc_menus.page_uri_id
          , omc_pages.id AS pagesid, omc_pages.name,omc_pages.path');
  */
//$options = array('omc_menus.parentid' =>id_clean($parentid));
          $this->db->where ('parentid',$parentid);
      //   $this->db->order_by('omc_menus.order asc, omc_menus.parentid asc');
        $this->db->join("omc_pages", "omc_pages.id = omc_menus.page_uri_id");
         //$this->db->where ('omc_menus.parentid',$parentid);
         $res = $this->db->get('omc_menus');
         if ($res->num_rows() > 0) {
             foreach ($res->result_array() as $r) {

				// push found result onto existing tree
                $tree[$r['id']] = $r;
                // create placeholder for children
                $tree[$r['id']]['children'] = array();
                // find any children of currently found child
                $this->generateallTreewithUri($tree[$r['id']]['children'],$r['id']);
             }
         }
     }



  function getMenu($id){
      $data = array();
      $options = array('id' =>id_clean($id));
     // $this->db->join('omc_pages', 'omc_pages.id = omc_menus.page_uri_id');
      $Q = $this->db->get_where('omc_menus',$options,1);
      if ($Q->num_rows() > 0){
        $data = $Q->row_array();
      }
  
      $Q->free_result();    
      return $data;    
   }

    function getMenuwithPage($mid){
      $data = array();
      $this->db->select('omc_menus.id AS menusid,omc_menus.name,omc_menus.shortdesc,omc_menus.status
          ,omc_menus.parentid,omc_menus.order,omc_menus.lang_id,omc_menus.page_uri_id
          , omc_pages.id AS pagesid, omc_pages.name,omc_pages.path');
      $options = array('omc_menus.id' =>id_clean($mid));
      $this->db->join("omc_pages", "omc_pages.id = omc_menus.page_uri_id",'right');
      $Q = $this->db->get_where('omc_menus',$options,1);
      if ($Q->num_rows() > 0){
        $data = $Q->row_array();
      }

      $Q->free_result();
      return $data;
   }
      
   function getAllMenus(){
      // This is used to show menus in home tables
       $data = array();
       $Q = $this->db->get('omc_menus');
       if ($Q->num_rows() > 0){
         foreach ($Q->result_array() as $row){
           $data[] = $row;
         }
      }
      $Q->free_result();  
      return $data; 
   }


   function getAllMenusDisplay(){
       $data[0] = 'root';
       $Q = $this->db->get('omc_menus');
       if ($Q->num_rows() > 0){
         foreach ($Q->result_array() as $row){
           $data[$row['id']] = $row['name'];
         }
      }
      $Q->free_result();  
      return $data; 
   }


    function getAllMenusDisplayByLang($lang_id){
        $data = array();
      // $data[0] = 'root';
       $Q = $this->db->get_where('omc_menus',array('lang_id'=>$lang_id));
       if ($Q->num_rows() > 0){
         foreach ($Q->result_array() as $row){
           $data[$row['id']] = $row['name'];
         }
      }
      $Q->free_result();
      return $data;
   }
   
   function getMenusNav(){
       $data = array();
       $this->db->select('id,name,parentid');
      // $this->db->where('status', 'active');
       $this->db->orderby('parentid','asc');
       $this->db->orderby('name','asc');
       $this->db->groupby('parentid,id');
       $Q = $this->db->get('omc_menus');
       if ($Q->num_rows() > 0){
         foreach ($Q->result() as $row){
     
              if ($row->parentid > 0){
                  $data[0][$row->parentid]['children'][$row->id] = $row->name;
                 
              }else{
                  $data[0][$row->id]['name'] = $row->name;
                
              }
          }
      }
      $Q->free_result(); 
      return $data; 
   }
  
  
  
   function getMenusDropDown(){
       $data = array();
       $this->db->select('id,name');
       $this->db->where('parentid !=',0);
       $Q = $this->db->get('omc_menus');
       if ($Q->num_rows() > 0){
         foreach ($Q->result_array() as $row){
           $data[$row['id']] = $row['name'];
         }
      }
      $Q->free_result();  
      return $data; 
   }
  
      
   function getTopMenus(){
       $data[0] = 'root';
       $this->db->where('parentid',0);
       $Q = $this->db->get('omc_menus');
       if ($Q->num_rows() > 0){
         foreach ($Q->result_array() as $row){
           $data[$row['id']] = $row['name'];
         }
      }
      $Q->free_result();  
      return $data; 
   }	
  
	 
  function getrootMenus(){
       $this->db->where('parentid',0);
       $Q = $this->db->get('omc_menus');
       if ($Q->num_rows() > 0){
         foreach ($Q->result_array() as $row){
            $data[$row['id']] = $row['name'];
         }
      }
      $Q->free_result();  
      return $data; 
   }

   function getrootMenusByLang($lang_id){
       $data = array();
       $this->db->where('parentid',0);
       $this->db->where('lang_id',$lang_id);
       $Q = $this->db->get('omc_menus');
       if ($Q->num_rows() > 0){
         foreach ($Q->result_array() as $row){
            $data = $row['id'];
         }
      }
      $Q->free_result();
      return $data;
   }



    function getrootMenuNamesByLang($lang_id){
       $data = array();
       $this->db->where('parentid',0);
       $this->db->where('lang_id',$lang_id);
       $Q = $this->db->get('omc_menus');
       if ($Q->num_rows() > 0){
         foreach ($Q->result_array() as $row){
            $data[] = $row;
         }
      }
      $Q->free_result();
      return $data;
   }

   /*
    Not used
   function addMenu(){
      $data = array( 
            'name' => db_clean($_POST['name']),
            'shortdesc' =>  db_clean($_POST['shortdesc']),
            'status' =>  db_clean($_POST['status'],8),
            'parentid' => id_clean($_POST['parentid']),
            'order' => id_clean($_POST['order'],10),
          'page_uri_id' =>  db_clean($_POST['page_uri_id']),
          // page_uri not used any more
            'lang_id' =>  db_clean($_POST['lang_id']),
          'menu_id' =>  db_clean($_POST['menu_id'])

      );
  
      $this->db->insert('omc_menus', $data);
   }
  
   
   function updateMenu(){
      $data = array( 
            'name'          =>  db_clean($_POST['name']),
            'shortdesc'     =>  db_clean($_POST['shortdesc']),
            'status'        =>  db_clean($_POST['status'],8),
            'order'         =>  id_clean($_POST['order'],10),
            'parentid'      =>  id_clean($_POST['parentid']),
			'page_uri_id'   =>  id_clean($_POST['page_uri_id']),
            'menu_id'       =>  id_clean($_POST['menu_id'])
      
      );
  
      $this->db->where('id', id_clean($_POST['id']));
      $this->db->update('omc_menus', $data);
   
   }
    * 
    */
   
   function deleteMenu($id){
      // $data = array('status' => 'inactive');
      $this->db->where('id', id_clean($id));
      $this->db->delete('omc_menus');
   }
   
	 function changeMenuStatus($id){
		// getting status of page
		$menuinfo = array();
		$menuinfo = $this->getMenu($id);
		$status = $menuinfo['status'];
		if($status =='active'){
			
			$data = array('status' => 'inactive');
			$this->db->where('id', id_clean($id));
			$this->db->update('omc_menus', $data);
			
		}else{
			
			$data = array('status' => 'active');
			$this->db->where('id', id_clean($id));
			$this->db->update('omc_menus', $data);
	}
	
 }
	 
   
   function exportCsv(){
      $this->load->dbutil();
      $Q = $this->db->query("select * from omc_menus");
      return $this->dbutil->csv_from_result($Q,",","\n");
   }
   
   function checkMenuOrphans($id){
      $data = array();
      $this->db->select('id,name');
      $this->db->where('parentid',id_clean($id));
      $Q = $this->db->get('omc_menus');
      if ($Q->num_rows() > 0){
         foreach ($Q->result_array() as $row){
           $data[$row['id']] = $row['name'];
         }
      }
      $Q->free_result();  
      return $data;  	
   
   }

    function reassignMenus(){
        $data = array('parentid' => $this->input->post('parentid'));
        $idlist = implode(",",array_keys($this->session->userdata('orphans')));
        $where = "id in ($idlist)";
        $this->db->where($where);
        $this->db->update('omc_menus',$data);
     }





     
	
}
