<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BackendPro
 *
 * A website backend system for developers for PHP 4.3.2 or newer
 *
 * @package         BackendPro
 * @author          Adam Price
 * @copyright       Copyright (c) 2008
 * @license         http://www.gnu.org/licenses/lgpl.html
 * @link            http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ---------------------------------------------------------------------------

/**
 * auth.php
 *
 * Authentication Controller
 *
 * @package			BackendPro
 * @subpackage		Controllers
 */
class auth extends Public_Controller
{
	/**
	 * Constructor
	 */
	function auth()
	{
		parent::Public_Controller();

		// Load the Auth_form_processing class
		$this->load->library('auth_form_processing');

		log_message('debug','BackendPro : Auth class loaded');
	}

	function index()
	{
		$this->login();
	}

	function login()
	{
		$this->auth_form_processing->login_form($this->_container);
	}

	function logout()
	{
		$this->auth_form_processing->logout();
	}

	function forgotten_password()
	{
		$this->auth_form_processing->forgotten_password_form($this->_container);
	}

	function register()
	{
		$this->auth_form_processing->register_form($this->_container);
	}

	function activate()
	{
		$this->auth_form_processing->activate();
	}
}
/* End of file auth.php */
/* Location: ./modules/auth/controllers/auth.php */