<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BackendPro
 *
 * A website backend system for developers for PHP 4.3.2 or newer
 *
 * @package         BackendPro
 * @author          Adam Price
 * @copyright       Copyright (c) 2009
 * @license         http://www.gnu.org/licenses/lgpl.html
 * @link            http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ---------------------------------------------------------------------------

/**
 * BackendPro Browser Class
 * 
 * Allows comparisons to be done between a certain browser version
 * and that of the users browser
 * 
 * @package			BackendPro
 * @subpackage		Libraries
 * @author			Adam Price
 * @copyright		Copyright (c) 2009
 */
class Bep_browser
{		
	/**
	 * CodeIgniter Instance
	 * 
	 * @var object
	 */
	var $CI;
	
	/**
	 * Browser Mappings
	 * 
	 * An array of browser name mappings to
	 * browser shorthand names
	 * 
	 * @var array
	 */
	var $browser_mappings = array();

	function Bep_browser()
	{
		log_message('info','BackendPro->Browser : Browser Class loaded');
		$this->CI = &get_instance();
		
		$this->CI->load->config('bep_browser',TRUE);
		
		$this->browser_mappings = $this->CI->config->item('cond_css_browsers','bep_browser');
	}
	
	/**
	 * Load User Agent
	 * 
	 * Loads the CI user_agent class. This has to be done outside
	 * of the constructor since it dosn't work otherwise.
	 * 
	 * Only happens in PHP4
	 */
	function LoadUserAgent()
	{
		$this->CI = &get_instance();		
		$this->CI->load->library('user_agent');
	}
	
	/**
	 * Does Browser Name + Version Match
	 * 
	 * Checks the browser details given against the users browser.
	 * 
	 * @return bool
	 * @param string $operator Version operator
	 * @param string $browser Browser ID
	 * @param int $version Browser version number
	 */
	function DoesNameAndVersionMatch($operator, $browser, $version)
	{
		$matches = false;
		
		// Does the browser type match?
		if($this->DoesNameMatch($browser))
		{
			if($version != null)
			{
				if($this->DoesVersionMatch($operator,$version))
				{
					$matches = true;
				}	
			}
			else
			{
				// No further checks to do, return true
				$matches = true;
			}
		}
		
		
		return $matches;
	}
	
	/**
	 * Does Version Match
	 * 
	 * Check the version of the users browser against
	 * a given version using an operator
	 * 
	 * @return bool 
	 * @param string $operator Operator to test the versions by
	 * @param string $version
	 */
	function DoesVersionMatch($operator,$version)
	{
		// Replace with valid operator
		switch($operator)
		{
			case 'lt':
				$operator = "<";
				break;
			
			case 'lte':
				$operator = "<=";
				break;
				
			case 'gt':
				$operator = ">";
				break;
				
			case 'gte':
				$operator = ">=";
				break;
				
			case 'lt':
				$operator = "!=";
				break;
				
			default:
				$operator = "==";
		}
		
		// Get the browser version and seperate the parts
		$real_parts = explode('.',$this->CI->agent->version());
		
		// Get the test version and seperate the parts
		$test_parts = explode('.',$version);
		
		// Make sure both are the same length
		while(count($real_parts) > count($test_parts))
		{
			array_pop($real_parts);
		}
		
		// Perform the test and return result
		$expr = "(" . implode('',$real_parts) . $operator . implode('',$test_parts) . ")";
		eval("\$result = $expr;");
		return $result;
	}
	
	/**
	 * Does Name Match
	 * 
	 * Check if the given browser name matches that
	 * of the users browser
	 * 
	 * @return bool 
	 * @param string $browser
	 */
	function DoesNameMatch($browser)
	{
		$matches = false;
		if($this->browser_mappings[$this->CI->agent->browser()] == $browser)
		{
			$matches = true;
		}

		return $matches;
	}
}

/* End of Bep_Browser.php */
/* Location: ./modules/site/libraries/Bep_Browser.php */