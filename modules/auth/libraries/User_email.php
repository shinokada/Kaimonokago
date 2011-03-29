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
 * User_email
 *
 * User email library. This implements easy to use method to send emails to
 * a user.
 *
 * @package         BackendPro
 * @subpackage      Libraries
 */
class User_email
{
	function User_email()
	{
		// Get CI Instance
		$this->CI = &get_instance();

		// Load needed files
		$this->CI->load->library('email');
		$this->CI->load->helper('email');
		$this->CI->load->library('parser');

		log_message('debug','BackendPro : User_email class loaded');
	}

	/**
	 * Send email to user
	 *
	 * Send an email to a site user. Using the given view file and data
	 *
	 * @access public
	 * @param mixed $user User email or ID
	 * @param string $subject Email subject
	 * @param string $view View file to use
	 * @param array $data Variable replacement array
	 * @return boolean Whether the email was sent
	 */
	function send($user=NULL,$subject='No Subject',$view=NULL,$data=array())
	{
		if( valid_email($user))
		{
			// Email given
			$email = $user;
		}
		elseif( is_integer($user))
		{
			// Get users email
			$query = $this->CI->user_model->fetch('Users','email',NULL,array('id'=>$user));
			$user = $query->row();
			$email = $user->email;
		}
		else
		{
			// Error
			return FALSE;
		}

		// Build email
		$subject = "[".$this->CI->preference->item('site_name')."] " . $subject;
		$message = $this->CI->parser->parse($view, $data, TRUE);

		// Setup Email settings
		$this->_initialize_email();

		// Send email
		$this->CI->email->from($this->CI->preference->item('automated_from_email'), $this->CI->preference->item('automated_from_name'));
		$this->CI->email->to($email);
		$this->CI->email->subject($subject);
		$this->CI->email->message($message);

		if( !$this->CI->email->send())
		{
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * Initialize Email using BackendPro Preferences
	 *
	 * @access private
	 */
	function _initialize_email()
	{
		$config['useragent'] = "BackendPro";
		$config['protocol'] = $this->CI->preference->item('email_protocol');
		$config['mailpath'] = $this->CI->preference->item('email_mailpath');
		$config['smtp_host'] = $this->CI->preference->item('smtp_host');
		$config['smtp_user'] = $this->CI->preference->item('smtp_user');
		$config['smtp_pass'] = $this->CI->preference->item('smtp_pass');
		$config['smtp_port'] = $this->CI->preference->item('smtp_port');
		$config['smtp_timeout'] = $this->CI->preference->item('smtp_timeout');
		$config['wordwrap'] = $this->CI->preference->item('email_wordwrap');
		$config['wrapchars'] = $this->CI->preference->item('email_wrapchars');
		$config['mailtype'] = $this->CI->preference->item('email_mailtype');
		$config['charset'] = $this->CI->preference->item('email_charset');
		$config['bcc_batch_mode'] = $this->CI->preference->item('bcc_batch_mode');
		$config['bcc_batch_size'] = $this->CI->preference->item('bcc_batch_size');
		$this->CI->email->initialize($config);
	}
}
/* End of file User_email.php */
/* Location: ./modules/auth/libraries/User_email.php */