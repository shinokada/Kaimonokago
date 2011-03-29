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
 * Widget class allows widgets to be created for the Dashboard class
 *
 * @package			BackendPro
 * @subpackage		Libraries
 */
class Widget
{
	/**
	 * Name of widget
	 *
	 * @var string
	 */
	var $name;

	/**
	 * Body contents of widget
	 *
	 * @var string
	 */
	var $body;

	var $CI;

	/**
	 * Constructor
	 *
	 * @access public
	 * @param string $name Name of widget
	 * @param string $body Body contents of widget
	 * @return boolean
	 */
	function widget($name = NULL, $body = NULL)
	{
		$this->CI = get_instance();
		if( is_null($name))
		{
			return FALSE;
		}

		$this->name = $name;
		$this->body = $body;
		return TRUE;
	}

	/**
	 * Output widget code
	 *
	 * @access public
	 * @return string
	 */
	function output()
	{
		$output = '<div class="widget" id="widget_' . md5($this->name) . '">';
		$output.= '<div class="action">' . $this->CI->bep_assets->icon('tick') . $this->CI->bep_assets->icon('cross') .'</div>';
		$output.= '<div class="header">'.$this->name.'</div>';
		$output.= '<div class="body">'.$this->body.'</div>';
		$output.= '</div>';
		return $output;
	}

	/**
	 * Covert Widget name
	 *
	 * Coverts the widget name so it dosn't contain any spaces and is lower case.
	 *
	 * @access private
	 * @return string
	 */
	function _name_convert()
	{
		return preg_replace("/ /","_",strtolower($this->name));
	}
}

/* End of file Widget.php */
/* Location: ./modules/dashboard/libraries/Widget.php */