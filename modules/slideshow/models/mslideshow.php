<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

// not used so delete it later

class MSlideshow extends Model{
	 function MSlideshow(){
	 	parent::Model();
	 }
   /* not used, move to kaimonokago

    function insertslideshow(){
        $data = array(
            'name' 			=> db_clean($_POST['name']),
            'shortdesc' 	=> db_clean($_POST['shortdesc']),
            'longdesc' 		=> db_clean($_POST['longdesc'],5000),
            'status' 		=> db_clean($_POST['status'],8),
            'slide_order' => db_clean($_POST['slide_order']),
            'thumbnail'		=> db_clean($_POST['thumbnail']),
            'image'			=> db_clean($_POST['image']),
        );
        $this->db->insert('omc_slideshow', $data);
     }

  

    function updateSlide(){
        $data = array(
            'name' 			=> db_clean($_POST['name']),
            'shortdesc' 	=> db_clean($_POST['shortdesc']),
            'longdesc' 		=> db_clean($_POST['longdesc'],5000),
            'status' 		=> db_clean($_POST['status'],8),
            'slide_order' => db_clean($_POST['slide_order']),
            'thumbnail'		=> db_clean($_POST['thumbnail']),
            'image'			=> db_clean($_POST['image']),
        );
        $this->db->where('id', $_POST['id']);
        $this->db->update('omc_slideshow', $data);
     }
       
     



    function getslideshow($id){
            // getting info of single slideshow.
        $data = array();
        $options = array('id' => id_clean($id));
        $Q = $this->db->getwhere('omc_slideshow',$options,1);
        if ($Q->num_rows() > 0){
            $data = $Q->row_array();
        }
        $Q->free_result();
        return $data;
    }


not used
Moved to kaimonokago

    function getAllslideshow(){
            // getting all the slideshow of the same categroy.
        $data = array();
       //$this->db->order_by('slideshow_id','asc');
        $Q = $this->db->get('omc_slideshow');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
            $data[] = $row;
           }
        }
        $Q->free_result();
        return $data;
}
 * 
 */

 
}//end class
?>