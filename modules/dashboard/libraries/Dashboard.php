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

include_once("Widget.php");

/**
 * Dashboard
 *
 * This class is used to create a dashboard of widgets for the administration
 * control panel.
 *
 * @package			BackendPro
 * @subpackage		Libraries
 */
class Dashboard
{
	/**
	 * Dashboard widget object array
	 *
	 * @var widget_array
	 */
	var $widgets = array();

	function Dashboard()
	{
		$this->CI =& get_instance();

		$this->CI->lang->load('dashboard');
	}

	/**
	 * Assign Widget to Dashboard
	 *
	 * @access public
	 * @param Widget $widget Widget object to assign to dashboard
	 * @param string $location Location to assign widget to by default
	 * @return boolean
	 */
	function assign_widget($widget = NULL, $location = 'top')
	{
		if( is_null($widget))
		{
			return FALSE;
		}

		$this->widgets[$location][] = $widget;
		return TRUE;
	}

	/**
	 * Output dashboard code
	 *
	 * @access public
	 * @return string
	 */
	function output()
	{
		// Start dashboard
		$output = '<div id="dashboard">';

		// Loop over each section
		foreach(array('top','left','right') as $section)
		{
			$output.= '<div id="'.$section.'section" class="sortable">';

			// Add that sections widgets
			if( isset($this->widgets[$section]))
			{
				foreach($this->widgets[$section] as $widget)
				{
					$output.= $widget->output();
				}
			}

			$output.= '</div>';
		}

		$output.= '</div>';
		return $output;
	}
}

/* End of file Dashboard.php */
/* Location: ./modules/dashboard/libraries/Dashboard.php */