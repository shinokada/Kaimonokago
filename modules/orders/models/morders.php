<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MOrders extends Model{
	 function  __construct(){
	    parent::Model();
	 }
 
	 
	 function getAllOrders(){
		$this->db->from('omc_order');
		$this->db->join('omc_customer', 'omc_order.customer_id = omc_customer.customer_id');
		$Q = $this->db->get();
		if ($Q->num_rows() > 0){
			foreach ($Q->result_array() as $row){
			$data[] = $row;
		}
		$Q->free_result();    
		return $data; 
		}
	 }

	 
	 function getOrders(){
		 $Q = $this->db->get('omc_order');
		 return $Q;
	 }
 
	 
	 function ordersToComplete(){
	 	$Q = $this->db->get_where('omc_order', array('delivery_date' => 0));	
	  	return $Q;
	      
	 }
 
	function getOrderDetails($id){
		 $this->db->select('omc_order_item.order_item_id,omc_order_item.order_id,omc_order_item.product_id,
						   omc_order_item.quantity,omc_order_item.price,omc_products.name,
						   omc_order.order_date, omc_order.delivery_date, omc_order.payment_date');
		 $this->db->from('omc_order_item');
		 $this->db->join('omc_products', 'omc_products.id = omc_order_item.product_id');
		 $this->db->join('omc_order', 'omc_order.order_id = omc_order_item.order_id');
		 $this->db->where('omc_order_item.order_id', $id);
		 $Q = $this->db->get();
		 
		 if ($Q->num_rows() > 0){
		       foreach ($Q->result_array() as $row){
		         $data[] = $row;
		       }
		 }
		 $Q->free_result();    
		 return $data; 
	 
	}
	
	
    function updateCart($productid,$fullproduct){
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
        $productid = id_clean($productid);
        $totalprice = 0;
        if (count($fullproduct)){
            if (isset($cart[$productid])){
                $prevct = $cart[$productid]['count'];
                $prevname = $cart[$productid]['name'];
                $prevprice = $cart[$productid]['price'];
                $cart[$productid] = array(
                                'name' => $prevname,
                                'price' => $prevprice,
                                'count' => $prevct + 1
                                );
            }else{
                $cart[$productid] = array(
                                'name' => $fullproduct['name'],
                                // 'price' => $this->format_currency($fullproduct['price']),
                                // This should be done in view
                                'price' => $fullproduct['price'],
                                'count' => 1
                                );			
            }				
            foreach ($cart as $id => $product){
                            $totalprice += $product['price'] * $product['count'];
            } 

            // This format should be done later in a view otherwise it will mess up.
            $_SESSION['totalprice'] = $totalprice;
            $_SESSION['cart'] = $cart;
            $msg = lang('orders_added_cart');
            $this->session->set_flashdata('conf_msg', $msg); 
        }	
    }

	
	function removeLineItem($id){
		$id = id_clean($id);
		$totalprice = 0;
		$cart = $_SESSION['cart'];//$this->session->userdata('cart');
		if (isset($cart[$id])){
			unset($cart[$id]);
			foreach ($cart as $id => $product){
				$totalprice += $product['price'] * $product['count'];
			}		
			// this should be done later
			$_SESSION['totalprice'] = $totalprice;
			$_SESSION['cart'] = $cart;
			$msg = lang('orders_product_removed');
			echo $msg;
		}else{
			 $msg = lang('orders_not_in_cart');
			echo "Product not in cart!";
		}
	}

	
	function updateCartAjax($idlist){
		$cart = $_SESSION['cart'];//$this->session->userdata('cart');
		//split idlist on comma first
		$records = explode(',',$idlist);
		$updated = 0;
		$totalprice = $_SESSION['totalprice'];
		if (count($records)){
			foreach ($records as $record){
				if (strlen($record)){
					//split each record on colon
					$fields = explode(":",$record);
					$id = id_clean($fields[0]);
					$ct = $fields[1];
					
					if ($ct > 0 && $ct != $cart[$id]['count']){
						$cart[$id]['count'] = $ct;
						$updated++;
					}elseif ($ct == 0){
						unset($cart[$id]);
						$updated++;
					}
				}
			}
			if ($updated){
				$totalprice=0;
				$shippingprice = 0;
					foreach ($cart as $id => $product){
					   	$totalprice += $product['price'] * $product['count'];
					 	$maxprice = 0;
						foreach ($_SESSION['cart'] as $item) {
						    if ($item['price'] > $maxprice) {
						        $maxprice = $item['price'];
						    }
						}
					   if ($maxprice > 268 ){
					       $shippingprice = 65.0;
					   }else{
					   		$shippingprice = 25.0;
					   }
					} 
				$_SESSION['shipping'] = $shippingprice;
				$_SESSION['totalprice'] = $totalprice;
				$_SESSION['cart'] = $cart;
				switch ($updated){
					case 0:
					$string = lang('orders_no_records');
					break;
					
					case 1:
					$string = $updated . " " . lang('orders_record'); 
					break;
					
					default:
					$string = $updated . " " . lang('orders_records'); 
					break;
				}
				echo $string . $updated . " " . lang('orders_updated'); 
			}else{
				echo lang('orders_no_changes_detected');
			}
		}else{
			echo lang('orders_nothing_to_update');
		}
	}

	function verifyCart(){
		$cart = $_SESSION['cart'];
		$change = false;
		
		if (count($cart)){
			foreach ($cart as $id => $details){
				$idlist[] = $id;		
			}
			$ids = implode(",",$idlist);			
			$this->db->select('id,price');
			$this->db->where("id in ($ids)");
			$Q = $this->db->get('omc_products');
	    	if ($Q->num_rows() > 0){
				foreach ($Q->result_array() as $row){
					$db[$row['id']] = $row['price'];
				}
			}			
			foreach ($cart as $id => $details){
				if (isset($db[$id])){
					if ($details['price'] != $db[$id]){
						$details['price'] = $db[$id];
						$change = true;
					}
					$final[$id] = $details;
				}else{
					$change = true;
				}
			}
			$totalprice=0;
			foreach ($final as $id => $product){
				$totalprice += $product['price'] * $product['count'];
			}
			$_SESSION['totalprice'] = $totalprice;
			$_SESSION['cart'] = $final;
			$this->session->set_flashdata('change',$change);		
		}else{
			//nothing in cart!
			$this->session->set_flashdata('error',lang('orders_nothing_in_cart'));
		}	
	}

	
	 function format_currency($number){
		 return number_format($number,2,'.',',');
	 }
 
	 function enterorder($totalprice){
	  
		  $data = array (
			  'customer_last_name' => db_clean($this->input->post('customer_last_name')),
			  'customer_first_name' => db_clean($this->input->post('customer_first_name')),
			  'phone_number' => db_clean($this->input->post('telephone')),
			  'email' => db_clean($this->input->post('email')),
			  'address' => db_clean($this->input->post('shippingaddress')),
			  'city' => db_clean($this->input->post('city')),
			  'post_code' => db_clean($this->input->post('post_code'))
		  );
		
		  	$e = $this->input->post('email');
			$numrow = $this->MCustomers->checkCustomer($e);
			if ($numrow == TRUE){
				// if there is email in db, then update the details
				$this->db->where('email', $e);
				$this->db->update('omc_customer',$data);
				// get the customer_id
				$customer_details = $this -> MCustomers->getCustomerByEmail($e);
				$customer_id = $customer_details['customer_id'];
			}else{
				// no email entry, then insert the details
		  		$this->db->insert('omc_customer',$data);
		  		// get the customer_id
		  		$customer_id = $this->db->insert_id();
			}
		
		  $data = array (
			   'customer_id'=> $customer_id,
			   'total' => $totalprice
		  );
		  $this->db->set('order_date', 'NOW()', FALSE);
		  $this->db->insert('omc_order', $data);
		  $order_id = $this->db->insert_id();
		  $cart = $_SESSION['cart'];
		  foreach ($cart as $id => $product){
				$data = array(
						'order_id' => $order_id,
						'product_id'=> $id ,
						'quantity' => $product['count'],
						'price'=> $product['price']
				);
		  $this->db->insert('omc_order_item', $data);
				}				
	 }
 
 
	 function setpayment($id){
		  $this->db->where('order_id', $id);
		  $this->db->set('payment_date', 'NOW()', FALSE);
		  $this->db->update('omc_order');
	 }
 
	  function setdelivery($id){
		  $this->db->where('order_id', $id);
		  $this->db->set('delivery_date', 'NOW()', FALSE);
		  $this->db->update('omc_order');
	 }
 
 
	 function deleteOrderItem($id){
			$this->db->where('order_item_id', id_clean($id));
			$this->db->delete('omc_order_item');	
	 }
 
	 function deleteOrder($id){
			$this->db->where('order_id', id_clean($id));
			$this->db->delete('omc_order');	
	 }
 
 
	 function checkOrphans($id){
		 	$data = array();
		 	$this->db->select('order_item_id,name');
		 	$this->db->where('order_id',id_clean($id));
		 	$Q = $this->db->get('omc_order_item');
		    if ($Q->num_rows() > 0){
				return TRUE;
		    }else{
			 	return FALSE;
			}
		    $Q->free_result();   	
	 }
	 
 
	 function findParent($order_item_id){
		  $this->db->where('order_item_id', $order_item_id);
		  $Q = $this->db->get('omc_order_item');
		    	if ($Q->num_rows() > 0){
					foreach ($Q->result_array() as $row){
						$data[] = $row;
					}
				}
		   $Q->free_result();  
		   return $data; 	
	 }
	 
	 
	 function findsiblings($order_id){
		  $this->db->where('order_id', $order_id);
		  $Q = $this->db->get('omc_order_item');
		    	if ($Q->num_rows() > 0){
					foreach ($Q->result_array() as $row){
						$data[] = $row;
					}
				}
		   $Q->free_result();  
		   return $data; 
	 }
	 
}//end class
?>