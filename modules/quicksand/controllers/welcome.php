<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BackendPro
 *
 * An open source development control panel written in PHP
 *
 * @package		BackendPro
 * @author		Adam Price
 * @copyright	Copyright (c) 2008, Adam Price
 * @license		http://www.gnu.org/licenses/lgpl.html
 * @link		http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Welcome
 *
 * The default welcome controller
 *
 * @package  	BackendPro
 * @subpackage  Controllers
 */
class Welcome extends Public_Controller
{
	function Welcome()
	{
		parent::Public_Controller();
		// Load modules/products/models/MProducts
		$this->load->model('MQuicksand');
	}

	function index()
	{
		// Display Page
		$data['header'] = "Welcome";
		$data['page'] = $this->config->item('backendpro_template_public') . 'welcome';
		$data['module'] = 'welcome';
		$this->load->view($this->_container,$data);
	}
	
	function quicksand(){
		$data['header']='Quicksand';
		$group = 'quicksand';
		$data['image_num']= $this->MQuicksand->getNumRowsByGroup($group);
		$data['images']= $this->MQuicksand->getProductsByGroup($group);
		$this->load->view('general/quicksand_temp',$data);
	}
	
	
	function ajaxquicksand(){
		$data['header']='Quicksand';
		$group = 'quicksand';
		$data['image_num']= $this->MQuicksand->getNumRowsByGroup($group);
		$data['images']= $this->MQuicksand->getProductsByGroup($group);
		
		$data['module'] = 'welcome';
		$this->load->view('general/quicksand_temp',$data);
		// $this->load->view('welcome/public/quicksand_view',$data);
	}
	
	
}


/* End of file welcome.php */
/* Location: ./modules/welcome/controllers/welcome.php */