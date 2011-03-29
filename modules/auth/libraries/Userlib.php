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
 * Userlib
 *
 * User authentication library used by BackendPro. Permits
 * protecting controllers/methods from un-authorized access.
 *
 * @package			BackendPro
 * @subpackage		Libraries
 */
class Userlib
{
	function Userlib()
	{
		// Get CI Instance
		$this->CI = &get_instance();

		// Load any files directly related to the authentication module
		$this->CI->load->config('userlib');
		$this->CI->lang->load('userlib');
		$this->CI->load->model('user_model');
		$this->CI->load->helper('userlib');

		// Load any other helpers/libraries needed
		$this->CI->load->helper('cookie');
		$this->CI->load->helper('Khacl');

		// Initialise the class
		$this->_init();

		log_message('debug','BackendPro : Userlib class loaded');
	}

	/**
	 * Initialise User Library
	 *
	 * Several jobs to perform
	 * > Check for autologin
	 * > Delete un activated user accounts
	 *
	 * @access private
	 */
	function _init()
	{
		// Log the user in if autologin details are correct
		if( !$this->is_user())
		{
			if (FALSE !== ($autologin = get_cookie('autologin')))
			{
				// Autologin data exists
				$autologin = unserialize($autologin);

				// Check its valid
				$result = $this->CI->user_model->validateLogin($autologin['login_field'],$autologin['password']);
				if($result['valid'])
				{
					// Log user in
					$this->set_userlogin($autologin['id']);
					log_message('debug','BackendPro->Userlib->_init : User logged in using autologin cookie');
				}
			}
		}

		// Remove any user accounts which have not been activated
		// within the specified deadline
		$query = $this->CI->user_model->delete('Users','DATE_ADD(created,INTERVAL '.$this->CI->preference->item('account_activation_time').' DAY) <= NOW() AND active=0');
	}

	/**
	 * Check a user is logged in
	 *
	 * @access public
	 * @return bool
	 */
	function is_user()
	{
		$CI = &get_instance();

		if($CI->session)
		{
			$loggedin = FALSE;

			// If the system is setup to store details in the database
			// only do a quick check since the user can't tamper with the values
			if(config_item('sess_use_database') === TRUE)
			{
				$email = $CI->session->userdata('email');
				$username = $CI->session->userdata('username');

				$loggedin = ($email !== FALSE && $username !== FALSE);

			}
			else
			{
				// Query the database to verify the details are correct
				switch($CI->preference->item('login_field'))
				{
					case 'email':
						$check = $CI->session->userdata('email');
						break;

					default:
						$check = $CI->session->userdata('username');
				}
				$result = $CI->user_model->validateLogin($check,$CI->session->userdata('password'));
				$loggedin = $result['valid'];
			}

			if ($loggedin)
			{
				// Logged in
				log_message('debug','BackendPro->Userlib->is_user : User is logged in');
				return TRUE;
			}
		}

		// Not logged in
		log_message('debug','BackendPro->Userlib->is_user : User is not logged in');
		return FALSE;
	}

	/**
	 * Check User Permissions
	 *
	 * Check the user has the correct permissions to access the resource
	 * If $redirect is TRUE then redirect to login page, otherwise return boolean
	 *
	 * @access public
	 * @return bool
	 */
	function check($resource,$action = NULL,$redirect = TRUE)
	{
		log_message('debug','BackendPro->Userlib->check : Checking if user has access to "'.$resource.'"');
		if ( $this->CI->session )
		{
			// Get details from user
			$email = $this->CI->session->userdata('email');
			$group = $this->CI->session->userdata('group');

			if ( $email !== FALSE && $group !== FALSE)
			{
				// There user has a session with values
				// Lets check there valid
				if (kh_acl_check($group,$resource,$action))
				{
					// They can access this resource
					log_message('debug','BackendPro->Userlib->check : User has access to ' . $resource);
					return TRUE;
				}
			}
		}

		// DENIED ACCESS
		log_message('debug','BackendPro->Userlib->check : Access is denied for user to ' . $resource);
		if ($redirect)
		{
			if( is_user())
			{
				// They just don't have access
				flashMsg('warning',$this->CI->lang->line('userlib_status_restricted_access'));
				redirect('auth/login','location');
			}
			else
			{
				// They arn't logged in
				flashMsg('warning',$this->CI->lang->line('userlib_status_require_login'));

				// Save requested page
				$this->CI->session->set_flashdata('requested_page',$this->CI->uri->uri_string());
				redirect('auth/login','location');
			}
		}
		return FALSE;
	}

	/**
	 * Set User Login data
	 *
	 * When given a user ID it will fetch the required data
	 * we need to save and save it to their session
	 *
	 * @access public
	 * @param integer $user_id User ID of user
	 */
	function set_userlogin($id)
	{
		//@INFO: This dosn't seem very safe having this exposed to everything.
		// Create Users session data
		$user = $this->CI->user_model->getUsers(array('users.id'=>$id));
		$user = $user->row_array();
		$this->CI->session->set_userdata($user);

		if( !$this->CI->session )
		{
			// Could not log user in, something went wrong
			flashMsg('error',$this->CI->lang->line('userlib_login_failed'));

			// Remove autologin value to stop an infinite loop
			delete_cookie('autologin');

			redirect('auth/login','location');
		}

		// Update users last login time
		$this->CI->user_model->updateUserLogin($id);
	}

	/**
	 * Encode Password
	 *
	 * Encode the users password using a set method.
	 * Use SHA-1 and a salt appended to password
	 *
	 * @parm string Password string
	 * @return string
	 */
	function encode_password($string=NULL)
	{
		if($string == NULL)
		{
			return NULL;
		}

		// Append the salt to the password
		$string .= $this->CI->config->item('encryption_key');

		// Return the SHA-1 encryption
		return sha1($string);
	}
}
/* End of file Userlib.php */
/* Location: ./modules/auth/libraries/Userlib.php */