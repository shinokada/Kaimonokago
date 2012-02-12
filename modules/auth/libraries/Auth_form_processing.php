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
 * Auth_form_processing
 *
 * Authentication form processing class. This class performs
 * all actions to provide the user with suitable forms to
 * login/logout/register etc with the system.
 *
 * This file is only loaded the when the user goes to
 * the auth controller.
 *
 * @package			BackendPro
 * @subpackage		Libraries
 */
class Auth_form_processing
{
	function Auth_form_processing()
	{
		// Get CI Instance
		$this->CI = &get_instance();

		$this->CI->load->helper('form');

		// Load any files directly related to the authentication module
		$this->CI->load->library('User_email');
		$this->CI->bep_assets->load_asset_group('FORMS');

		// Load any other helpers/libraries needed
		$this->CI->load->library('validation');

		log_message('debug','BackendPro : Auth_form_processing class loaded');
	}

	/**
	 * Login Form
	 *
	 * Display a login form for the user
	 *
	 * @access public
	 * @param string $container View file container
	 */
	function login_form($container)
	{
		// First lets see if they are logged in, if so run action for that user
		if ( is_user() )
		{
			// If they have access to the control panel panel send them there
			if( check('Control Panel',NULL,FALSE))
			{
				redirect($this->CI->config->item('userlib_action_admin_login'),'location');
			}
			// Otherwise run user action
			redirect($this->CI->config->item('userlib_action_login'),'location');
		}

		// Lets see what login methods are allowed and setup the form as so
		switch($this->CI->preference->item('login_field'))
		{
			case 'email':
				$fields['login_field'] = $this->CI->lang->line('userlib_email');
				$rules['login_field']  = 'trim|required|valid_email';
				break;
			case 'username':
				$fields['login_field'] = $this->CI->lang->line('userlib_username');
				$rules['login_field']  = 'trim|required';
				break;

			default:
				$fields['login_field'] = $this->CI->lang->line('userlib_email_username');
				$rules['login_field']  = 'trim|required';
				break;
		}

		// Setup fields
		$fields['password'] = $this->CI->lang->line('userlib_password');
		$fields['recaptcha_response_field'] = $this->CI->lang->line('userlib_captcha');
		$this->CI->validation->set_fields($fields);

		// Set Rules
		// Only run captcha check if needed
		$rules['password'] = 'trim|required';
		if($this->CI->preference->item('use_login_captcha'))
		{
			$rules['recaptcha_response_field'] = 'trim|required|valid_captcha';
		}
		$this->CI->validation->set_rules($rules);

		if ( $this->CI->validation->run() === FALSE )
		{
			// Output any errors
			$this->CI->validation->output_errors();

			// TODO: There must be a better way to do this
			$data['login_field'] = $fields['login_field'];

			// Display page
			$data['header'] = $this->CI->lang->line('userlib_login');
			$data['captcha'] = ($this->CI->preference->item('use_login_captcha')?$this->_generate_captcha():'');
			$data['page'] = $this->CI->config->item('backendpro_template_public') . 'form_login';
			$data['module'] = 'auth';
			$this->CI->load->view($container,$data);

			if($this->CI->session->flashdata('requested_page') != "")
			{
				// Only remember the flashData if there was some in the first place
				$this->CI->session->keep_flashdata('requested_page');
			}
		}
		else
		{
			// Submit form
			$this->_login();
		}
	}

	/**
	 * Log User In
	 *
	 * Log the user into the system
	 *
	 * @access pubic
	 */
	function _login()
	{
		// Fetch what they entered in the login
		$values['login_field'] = $this->CI->input->post('login_field');
		$values['password'] = $this->CI->userlib->encode_password($this->CI->input->post('password'));

		// See if a user exists with the given credentials
		$result = $this->CI->user_model->validateLogin($values['login_field'],$values['password']);
		if ( $result['valid'] )
		{
			// We we have a valid user
			$user = $result['query']->row();

			// Check if the users account hasn't been activated yet
			if ( $user->active == 0 )
			{
				// NEEDS ACTIVATION
				flashMsg('warning',$this->CI->lang->line('userlib_account_unactivated'));
				redirect('auth/login','location');
			}

			// Everything is OK
			// Save details to session
			//@TODO: This dosn't seem very safe having the login code totaly exposed
			$this->CI->userlib->set_userlogin($user->id);
			//$this->_set_userlogin($user->id);

			// If they asked to remember login, store details
			if ( $this->CI->input->post('remember') )
			{
				set_cookie('autologin',
				serialize(array('id'=>$user->id, 'login_field'=>$values['login_field'], 'password'=>$values['password'])),
				$this->CI->preference->item('autologin_period')*86400);
			}

			flashMsg('success',$this->CI->lang->line('userlib_login_successfull'));

			// Redirect to requested page
			if(FALSE !== ($page = $this->CI->session->flashdata('requested_page')))
			{
				redirect($page,'location');
			}

			// If user has access to control panel
			if ( check('Control Panel',NULL,FALSE))
			{
				redirect($this->CI->config->item('userlib_action_admin_login'),'location');
			}

			redirect($this->CI->config->item('userlib_action_login'),'location');
		}
		else
		{
			// Login details not valid
			flashMsg('error',$this->CI->lang->line('userlib_login_failed'));
		}
		redirect('auth/login','location');
	}

	/**
	 * Logout User
	 *
	 * Log the user out from the system
	 *
	 * @access public
	 */
	function logout()
	{
		$this->CI->session->sess_destroy();
		$this->CI->session->sess_create();

		if ( is_user() )
		{
			// Failed to log user out
			flashMsg('error',$this->CI->lang->line('userlib_logout_failed'));
			redirect($this->CI->config->item('userlib_action_logout'),'location');
		}

		// Unset autologin variable
		delete_cookie('autologin');

		flashMsg('success',$this->CI->lang->line('userlib_logout_successfull'));
		redirect($this->CI->config->item('userlib_action_logout'),'location');
	}

	/**
	 * Forgotten Password Form
	 *
	 * Display the form for the forgotten password page
	 *
	 * @access public
	 * @param string $container View file container
	 */
	function forgotten_password_form($container)
	{
		// Setup fields
		$fields['email'] = $this->CI->lang->line('userlib_email');
		$this->CI->validation->set_fields($fields);

		// Set Rules
		$rules['email'] = 'trim|required|valid_email';
		$this->CI->validation->set_rules($rules);

		if ( $this->CI->validation->run() === FALSE )
		{
			// Output any errors
			$this->CI->validation->output_errors();

			// Display page
			$data['header'] = $this->CI->lang->line('userlib_forgotten_password');
			$data['page'] = $this->CI->config->item('backendpro_template_public') . 'form_forgotten_password';
			$data['module'] = 'auth';
			$this->CI->load->view($container,$data);

			$this->CI->session->keep_flashdata('requested_page');
		}
		else
		{
			// Submit form
			$this->_forgotten_password();
		}
	}

	/**
	 * Forgotten Password
	 *
	 * Set a new password for the user
	 *
	 * @access private
	 */
	function _forgotten_password()
	{
		$email = $this->CI->input->post('email');

		if ($this->CI->user_model->validEmail($email))
		{
			// Valid Email
			// Generate a new password
			$this->CI->load->helper('string');
			$password = random_string('alnum',$this->CI->preference->item('min_password_length'));
			$encoded_password = $this->CI->userlib->encode_password($password);

			// Email the new password to the user
			$query = $this->CI->user_model->fetch('Users','username',NULL,array('email'=>$email));
			$user = $query->row();
			$data = array(
                    'username'=>$user->username,
                    'email'=>$email,
                    'password'=>$password,
                    'site_name'=>$this->CI->preference->item('site_name'),
                    'site_url'=>base_url()
			);
			$this->CI->user_email->send($email,$this->CI->lang->line('userlib_email_forgotten_password'),'public/email_forgotten_password',$data);

			// Update password in database
			$this->CI->user_model->update('Users',array('password'=>$encoded_password),array('email'=>$email));

			flashMsg('success',$this->CI->lang->line('userlib_new_password_sent'));
		}
		else
		{
			// Email not found
			flashMsg('error',$this->CI->lang->line('userlib_email_not_found'));
		}
		redirect($this->CI->config->item('userlib_action_forgotten_password','location'));
	}

	/**
	 * Process registration
	 *
	 * Creat the new user accounts for the registered user. When this
	 * is called all the data should be valid and no more checks should
	 * be needed
	 *
	 * @access private
	 */
	function _register()
	{
		// Build
		$data['users']['username'] = $this->CI->input->post('username');
		$data['users']['email'] = $this->CI->input->post('email');
		$data['users']['password'] = $this->CI->userlib->encode_password($this->CI->input->post('password'));
		$data['users']['group'] = $this->CI->preference->item('default_user_group');
		$data['users']['created'] = date("Y-m-d H:i:s",time());

		// Check how the account should be activated
		switch($this->CI->preference->item('activation_method'))
		{
			case 'none':
				// Send welcome email, account already activated
				$data['users']['active'] = 1;
				$activation_message = $this->CI->lang->line('userlib_no_activation');
				break;

			case 'admin':
				// Admin must activate, do nothing
				$activation_message = $this->CI->lang->line('userlib_admin_activation');
				break;

			default:
				// Send email with activation link
				$this->CI->load->helper('string');
				$data['users']['activation_key'] = random_string('alnum',32);
				$activation_message = sprintf($this->CI->lang->line('userlib_email_activation'), site_url('auth/activate/'.$data['users']['activation_key']), $this->CI->preference->item('account_activation_time'));
				break;
		}

		$this->CI->db->trans_begin();
		// Add user details to DB
		$this->CI->user_model->insert('Users',$data['users']);

		// Get the auto insert ID
		$data['user_profiles']['user_id'] = $this->CI->db->insert_id();

		// Add user_profile details to DB
		$this->CI->user_model->insert('UserProfiles',$data['user_profiles']);

		if ($this->CI->db->trans_status() === FALSE)
		{
			// Registration failed
			$this->CI->db->trans_rollback();

			flashMsg('error',$this->CI->lang->line('userlib_registration_failed'));
			redirect('auth/register','location');
		}
		else
		{
			// User registered
			$this->CI->db->trans_commit();

			// Send email to user
			$edata = array(
                    'username'=> $data['users']['username'],
                    'email'=> $data['users']['email'],
                    'password'=> $this->CI->input->post('password'),
                    'activation_message' => $activation_message,
                    'site_name'=>$this->CI->preference->item('site_name'),
                    'site_url'=>base_url()
			);
			$this->CI->user_email->send($data['users']['email'],$this->CI->lang->line('userlib_email_register'),'public/email_register',$edata);

			flashMsg('success',$this->CI->lang->line('userlib_registration_success'));
			redirect($this->CI->config->item('userlib_action_register'),'location');
		}
	}

	/**
	 * Register form
	 *
	 * Display the register form to the user
	 *
	 * @access public
	 * @param string $container View file container
	 */
	function register_form($container)
	{
		if( ! $this->CI->preference->item('allow_user_registration'))
		{
			// If registration is not allowed
			flashMsg('info',$this->CI->lang->line('userlib_registration_denied'));
			redirect('auth/login','location');
		}

		// Setup fields
		$fields['username'] = $this->CI->lang->line('userlib_username');
		$fields['password'] = $this->CI->lang->line('userlib_password');
		$fields['confirm_password'] = $this->CI->lang->line('userlib_confirm_password');
		$fields['email'] = $this->CI->lang->line('userlib_email');
		$fields['recaptcha_response_field'] = $this->CI->lang->line('userlib_captcha');
		$this->CI->validation->set_fields($fields);

		// Set Rules
		$rules['username'] = 'trim|required|max_length[32]|spare_username';
		$rules['password'] = 'trim|required|min_length['.$this->CI->preference->item('min_password_length').']|matches[confirm_password]';
		$rules['email'] = 'trim|required|max_length[254]|valid_email|spare_email';
		if($this->CI->preference->item('use_registration_captcha'))
		{
			$rules['recaptcha_response_field'] = 'trim|required|valid_captcha';
		}
		$this->CI->validation->set_rules($rules);

		if ( $this->CI->validation->run() === FALSE )
		{
			// Output any errors
			$this->CI->validation->output_errors();

			// Display page
			$data['header'] = $this->CI->lang->line('userlib_register');
			$data['captcha'] = ($this->CI->preference->item('use_registration_captcha')?$this->_generate_captcha():'');
			$data['page'] = $this->CI->config->item('backendpro_template_public') . 'form_register';
			$data['module'] = 'auth';
			$this->CI->load->view($container,$data);
		}
		else
		{
			// Submit form
			$this->_register();
		}
	}

	/**
	 * Activate User Account
	 *
	 * @access public
	 */
	function activate()
	{
		// Fetch code from url
		$key = $this->CI->uri->segment(3);

		if( $this->CI->user_model->activateUser($key) )
		{
			// Activation successful
			flashMsg('success',$this->CI->lang->line('userlib_activation_success'));
			redirect($this->CI->config->item('userlib_action_activation'),'location');
		}
		else
		{
			// Activation failed
			flashMsg('error',$this->CI->lang->line('userlib_activation_failed'));
			redirect('auth/login','location');
		}
	}

	/**
	 * Generate Captcha Image
	 *
	 * @access private
	 * @return string
	 */
	function _generate_captcha()
	{
		$this->CI->bep_assets->load_asset('recaptcha');
		$this->CI->load->module_library('recaptcha','Recaptcha');
		return $this->CI->recaptcha->recaptcha_get_html();
	}
}
/* End of file Auth_form_processing.php */
/* Location: ./modules/auth/libraries/Auth_form_processing.php */