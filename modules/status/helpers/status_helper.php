<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Status Helper
 *
 * Contains shortcuts to well used Status library commands
 *
 * @package		BackendPro
 * @subpackage	Helpers
 * @author		Adam Price
 * @copyright	Copyright (c) 2008, Adam Price
 * @license		http://www.gnu.org/licenses/lgpl.html
 * @link		http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

/**
 * Set Flash Message
 *
 * Set a new flash message for the system
 *
 * @param string $type Message type, either info,sucess,error,warning
 * @param string $message Message
 * @return bool
 */
if( ! function_exists('flashMsg'))
{
	function flashMsg($type = NULL, $message = NULL)
	{
		$obj = &get_instance();
		return $obj->status->set($type, $message);
	}
}

/**
 * Display status messages
 *
 * If no type has been given it will display every message,
 * otherwise it will only show and remove that certain type of
 * message
 *
 * @param string $type Error type to display
 * @return string
 */
if( ! function_exists('displayStatus'))
{
	function displayStatus($type = NULL)
	{
		$obj = &get_instance();
		return $obj->status->display($type);
	}
}
/* End of file status_helper.php */
/* Location: ./modules/status/helpers/status_helper.php */