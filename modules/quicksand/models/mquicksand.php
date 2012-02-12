<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MQuicksand extends Model{
	 function MQuicksand(){
	 	parent::Model();
	 }
	 
	 	 function getProductsByGroup($group){
	     $data = array();
	     $this->db->where('grouping', $group);
	     $this->db->where('status', 'active');
	     // $this->db->orderby('name','asc');
	     $Q = $this->db->get('omc_products');
	     if ($Q->num_rows() > 0){
	     	$num_rows = $Q->num_rows();
	       foreach ($Q->result_array() as $row){
	         $data[] = $row;
	       }
	    }
	    $Q->free_result();    
	    return $data; 
	    return $num_rows;
	 } 
	 
	 
	 function getNumRowsByGroup($group){
	     $data = array();
	     $this->db->where('grouping', $group);
	     $this->db->where('status', 'active');
	     // $this->db->orderby('name','asc');
	     $Q = $this->db->get('omc_products');
	     if ($Q->num_rows() > 0){
	     	$num_rows = $Q->num_rows();
	       
	    }
	    $Q->free_result();    
	    
	    return $num_rows;
	 } 
	 
	 
}