<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MSubscribers extends Model{

	function MSubscribers(){
		parent::Model();
	}

function getSubscriber($id){
    $this->db->where('id',id_clean($id));
    $this->db->limit(1);
    $Q = $this->db->getwhere('omc_subscribers');
    if ($Q->num_rows() > 0){
      $data = $Q->row_array();
    }

    $Q->free_result();    
    return $data;    
 }
	
 function getAllSubscribers(){
     $data = array();
     $Q = $this->db->get('omc_subscribers');
     if ($Q->num_rows() > 0){
       foreach ($Q->result_array() as $row){
         $data[] = $row;
       }
    }
    $Q->free_result();  
    return $data; 
 }
 
 
 function createSubscriber(){
	$this->db->where('email', $_POST['email']);
	$this->db->from('omc_subscribers');
	$ct = $this->db->count_all_results();

	if ($ct == 0){
		$data = array( 
			'name' => db_clean($_POST['name']),
			'email' => db_clean($_POST['email'])	
		);

		$this->db->insert('omc_subscribers', $data);	 
 	}
 }
 
 
 function updateSubscriber(){
	$data = array( 
		'name' => db_clean($_POST['name']),
		'email' => db_clean($_POST['email'])
	
	);

 	$this->db->where('id', id_clean($_POST['id']));
	$this->db->update('omc_subscribers', $data);	
 
 }


 
	function checkSubscriber($email){
		$numrow = 0;
		$this->db->select('id');
		$this->db->where('email',db_clean($email));
		$this->db->limit(1);
		$Q = $this->db->get('omc_subscribers');
		if ($Q->num_rows() > 0){
			$numrow = TRUE; 
			return $numrow;
		}else{
			$numrow = FALSE;
			return $numrow;
		}		
	}

}//end class
?>