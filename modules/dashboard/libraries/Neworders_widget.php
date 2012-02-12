<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * New Order Widget for BackendPro
 *
 * 
 * @author          Shin Okada
 * @copyright       Copyright (c) 2010
 * @license         http://www.gnu.org/licenses/lgpl.html
 * @link            http://www.okadadesign.no
 *
 */

// ---------------------------------------------------------------------------

/**
 * neworder_widget Class
 *
 * This class contains the code to create the statistic widget.
 */
class Neworders_widget
{
	function Neworders_widget()
	{
		$this->CI =& get_instance();

		$this->CI->load->module_model('orders','morders');
	}

	function create()
	{
		
		// Get total number of orders
		$query = $this->CI->morders->getOrders();
		$data['total_orders'] = $query->num_rows();
		
		// Get total number of orders
		$Q = $this->CI->morders->ordersToComplete();
		$data['total_new_orders'] = $Q->num_rows();
		$data['orderdetails'] = $Q;
		
		return $this->CI->load->module_view('dashboard',$this->CI->config->item('backendpro_template_admin') . 'dashboard/neworders',$data,TRUE);
	}
}

/* End of file Statistic_Widget.php */
/* Location: ./modules/dashboard/libraries/Statistic_Widget.php */