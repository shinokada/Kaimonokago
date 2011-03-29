<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * system/application/plugins/mytools_pi.php
 * This will replace all non English to _/under bar.
 *
 */
function createfoldername($string){
		$string = mb_strtolower($string,'utf-8');
		$regexp = '/( |g)/iU';
		// $regexp = '/( |å|ø|æ|Å|Ø|Æ|Ã¥|Ã¸|Ã¦|Ã…|Ã˜|Ã†)/iU';
		$replace_char = '_';
		$data = preg_replace($regexp, $replace_char, $string);
		return $data;
 }
 
 /*
  * This will replace non English to similar letter in English
  *
  */
 function createdirname($string){
		
		$forbidden = array(" ", "å", "Å","ø", "Ø", "æ", "Æ", "ã…", "ã˜","ã†", "ã¥", "ã¸", "ã¦" );
		// order is space, å, Å,ø, Ø,æ, Æ, and Å, Ø, Æ, å,ø,æ
		$normal = array("_", "aa", "aa", "o", "o", "ae", "ae","aa","o", "ae", "aa", "o", "ae" );
		$string = str_replace($forbidden, $normal, $string);
		$data = mb_strtolower($string,'utf-8');
		return $data;
 }
 
 
 function create_path($folder)
    {
        // create dir if not exists
        $folder = explode( "/" , $folder );
        $mkfolder = "";
        //sets the complete directory path
        for(  $i=0 ; isset( $folder[$i] ) ; $i++ )
        {
            $mkfolder .= $folder[$i] . '/';
            if(!is_dir($mkfolder )) {
			  mkdir("$mkfolder");
			  mkdir("$mkfolder/thumbnails");
			}
        }
    }
	
	// ------------ lixlpixel recursive PHP functions -------------
 // recursive_remove_directory( directory to delete, empty )
 // expects path to directory and optional TRUE / FALSE to empty
 // of course PHP has to have the rights to delete the directory
 // you specify and all files and folders inside the directory
 // ------------------------------------------------------------
 
 // to use this function to totally remove a directory, write:
 // recursive_remove_directory('path/to/directory/to/delete');
 
 // to use this function to empty a directory, write:
 // recursive_remove_directory('path/to/full_directory',TRUE);
 
 function recursive_remove_directory($directory, $empty=FALSE)
 {
	 // if the path has a slash at the end we remove it here
	 if(substr($directory,-1) == '/')
	 {
		 $directory = substr($directory,0,-1);
	 }
 
	 // if the path is not valid or is not a directory ...
	 if(!file_exists($directory) || !is_dir($directory))
	 {
		 // ... we return false and exit the function
		 return FALSE;
 
	 // ... if the path is not readable
	 }elseif(!is_readable($directory))
	 {
		 // ... we return false and exit the function
		 return FALSE;
 
	 // ... else if the path is readable
	 }else{
 
		 // we open the directory
		 $handle = opendir($directory);
 
		 // and scan through the items inside
		 while (FALSE !== ($item = readdir($handle)))
		 {
			 // if the filepointer is not the current directory
			 // or the parent directory
			 if($item != '.' && $item != '..')
			 {
				 // we build the new path to delete
				 $path = $directory.'/'.$item;
 
				 // if the new path is a directory
				 if(is_dir($path)) 
				 {
					 // we call this function with the new path
					 // you need to change to $this->recursive_remove_directory($path);
					 // in controller.
					 recursive_remove_directory($path);
 
				 // if the new path is a file
				 }else{
					 // we remove the file
					 unlink($path);
				 }
			 }
		 }
		 // close the directory
		 closedir($handle);
 
		 // if the option to empty is not set to true
		 if($empty == FALSE)
		 {
			 // try to delete the now empty directory
			 if(!rmdir($directory))
			 {
				 // return false if not possible
				 return FALSE;
			 }
		 }
		 // return success
		 return TRUE;
	 }
 }
 /**
  * If you delete a category, you may be creating product orphans.
  * Find in omc_product table, select product id and name where product's
  * category_id is $id
  * 
  * original code
  * $this->db->select('id,name');
  * $this->db->where('category_id',id_clean($id));
  * $Q = $this->db->get('omc_product');
  * 
  * $id is the id number i.e. 6 or 12
  * $orphan_id is the name of id i.e products_id where you are looking for orphans
  * $db_table is the name of table omc_product etc
  *
  * If I use (in mcats, instead of checkOrphans($id) )
  * or in morders, $id will be order id
  * When I delete an order there might be order-item orphans
  * When I delete an product there might be order-item orphans
  * When I delete a customer there might be order orphans
  * 
  */
 
  function findOrphans($id, $orphan_id, $db_table){
 	// delete a customer from omc_customer table
	// if $db_table is omc_customer, this will create customer_id
	// then find customer_id in omc_order table to find orphans
	/**
	 * delete an order from omc_order table. this will create order_items orphans in omc_order_item
	 * find order_item where order_id is 
	 * 
	 *
			  */
	$tablename = explode("-", $db_table);
	$tableid = $tablename[1]."_id";
	
	// or
	// $id_name = preg_replace('/.*_(.*)/', '${1}_id', $db_table);
	
	$data = array();
	// $this->db->select($tableid.',name'); 
 	$this->db->select($tableid,'name');
 	$this->db->where($orphan_id,id_clean($id));
 	$Q = $this->db->get($db_table);
    if ($Q->num_rows() > 0){
       foreach ($Q->result_array() as $row){
         $data[$row['id']] = $row['name'];
       }
    }
    $Q->free_result();  
    return $data;  	
 
 }