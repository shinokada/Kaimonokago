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
 * Status Class
 *
 * Allows the creation and display of status messages to the user.
 *
 * @package			BackendPro
 * @subpackage		Libraries
 */
class Status
{
	var $flash_var = "status";
	var $types = array('info','warning','error','success');

	function Status()
	{
		// Get CI Instance
		$this->CI = &get_instance();

		// Load other module files
		$this->CI->load->helper('status');
		$this->CI->lang->load('status');

		log_message('debug','BackendPro : Status class loaded');
	}

	/**
	 * Set status message
	 *
	 * The message will be live until $this->display() is called
	 *
	 * @access public
	 * @param string $type Type of message
	 * @param string $message Message to display
	 * @return bool
	 */
	function set($type = NULL, $message = NULL)
	{
		if ( $type == NULL OR $message == NULL)
		{
			return FALSE;
		}

		// Check its a valid type
		if ( ! in_array($type, $this->types) )
		{
			log_message('error','BackendPro->Status->set : Invalid status message type: ' . $type);
		}

		// Fetch current flashdata from session
		$data = $this->_fetch();

		// Append our message to the end if not already created
		if( ! array_key_exists($type,$data) OR ! in_array($message,$data[$type]))
		{
			$data[$type][] = $message;

			// Save the data back into the session
			$this->CI->session->set_userdata($this->flash_var,serialize($data));
		}
		return TRUE;
	}

	/**
	 * Display status messages
	 *
	 * If no type has been given it will display every message,
	 * otherwise it will only show and remove that certain type of
	 * message
	 *
	 * @access 	public
	 * @param 	string $type Error type to display
	 * @param 	bool $print Output to screen
	 * @return 	string
	 */
	function display($type = NULL,$print = TRUE)
	{
		log_message('debug','BackendPro->Status->display : Display all messages of type: ' . $type);
		// Fetch messages
		$msgdata = $this->_fetch();

		// Output variable
		$output = "";

		if ($type == NULL)
		{
			// Display all messages
			foreach ( $msgdata as $key => $mtype )
			{
				$data['messages'] = $mtype;
				$data['type'] = $key;
				$output .= $this->CI->load->view('status', $data, TRUE);
			}
		}
		else
		{
			// Only display messages of $type
			$data['messages'] = $msgdata[$type];
			$data['type'] = $type;
			$output =  $this->CI->load->view('status', $data, TRUE);
		}

		// Remove messages
		$this->_remove($type);

		// Print/Return output
		if($print)
		{
			print $output;
			return;
		}
		return $output;
	}

	/**
	 * Unset messages
	 *
	 * After a message has been shown remove it from
	 * the session data.
	 *
	 * @access private
	 * @param string $type Message type to remove
	 */
	function _remove($type = NULL)
	{
		if($type == NULL)
		{
			// Unset all messages
			$this->CI->session->unset_userdata($this->flash_var);
		}
		else
		{
			// Unset only messages with type $type
			$data = $this->_fetch();
			unset($data[$type]);
			$this->CI->session->set_userdata($this->flash_var,serialize($data));
		}
	}

	/**
	 * Fetch flashstatus array from session
	 *
	 * @access private
	 * @return array containing the flash data
	 */
	function _fetch()
	{
		$data = $this->CI->session->userdata($this->flash_var);
		if (empty($data))
		{
			return array();
		}
		else
		{
			return unserialize($data);
		}
	}
}

/* End of file Status.php */
/* Location: ./modules/status/libraries/Status.php */