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
 * Site Class
 * 
 * Allows
 * 
 * @package			BackendPro
 * @subpackage		Libraries
 * @author			Adam Price
 * @copyright		Copyright (c) 2009
 */
class BeP_site
{	
	/**
	 * Site Meta Tags array
	 * @var array
	 */
	var $meta_tags = array();

	/**
	 * Site Transfer variables array
	 * @var array
	 */
	var $variables = array();

	/**
	 * Breadcrumb Trail array
	 * @var array
	 */
	var $breadcrumb_trail = array();

	/**
	 * Javascript Code Blocks Array
	 * @var array
	 */
	var $javascript_code_blocks = array();

	function BeP_site()
	{
		log_message('info','BackendPro->BeP_Site : Class loaded');
		$CI = &get_instance();
		
		$CI->load->config('bep_site',true);
		
		$this->variables = $CI->config->item("default_site_variables","bep_site");
	}

	/**
	 * Set a metatag for the page
	 * 
	 * @param string $name Metatag name
	 * @param string $content Metatag content
	 * @param bool $http[optional] Option to make a 'equiv' metatag
	 */
	function set_metatag($name, $content, $http = false)
	{
		if ($name == NULL || $content == NULL)
		{
			log_message("error","BackendPro->BeP_Site->set_metatag : When setting a metatag a name must be given");
			return false;
		}

		$this->meta_tags[$name] = array('content' => $content, 'type' => ($http?'equiv':'name'));
	}
	
	/**
	 * Set a variable for transfer
	 * 
	 * @param string $name Variable name
	 * @param object $value Object to set as the value
	 */
	function set_variable($name,$value)
	{
		if ($name == NULL)
		{
			log_message("error","BackendPro->BeP_Site->set_variable : When transfering a variable a name must be given.");
			return false;
		}

		$this->variables[$name] = $value;
		log_message('debug','BackendPro->BeP_Site->set_variable : PHP variable transfer successful: ' . $name);
	}
	
	/**
	 * Set a site breakcrumb
	 * @return 
	 * @param object $name
	 * @param object $link[optional]
	 */
	function set_crumb($name, $link = '')
	{
		if($name == NULL)
		{
			log_message("error","BackendPro->BeP_Site->set_crumb : When setting a breadcrumb a name must be given");
			return false;
		}
		
		$this->breadcrumb_trail[$name] = $link;
		log_message('debug','BackendPro->BeP_Site->set_crumb : Breadcrumb link "'.$name.'" pointing to "'.$link.'" created');
	}
	
	/**
	 * Add a Javascript Code BLock
	 * 
	 * Adds a javascript code section to the page
	 *
	 * @param string $js
	 */
	function set_js_block($js)
	{
		$this->javascript_code_blocks[] = $js;
	}
	
	/**
	 * Get Metatags
	 * 
	 * Returns a string with all the metatags for the current page
	 * 
	 * @return string 
	 */
	function get_metatags()
	{
		if (count($this->meta_tags) == 0)
		{
			return null;
		}

		$output = '';
		foreach($this->meta_tags as $name => $tag)
		{
			$output .= meta($name, $tag['content'], $tag['type']) . "\n";
		}

		return $output;
	}

	/**
	 * Get Breadcrumbs
	 * 
	 * Return a string contain the full breadcrumb trail
	 * 
	 * @return string 
	 */
	function get_breadcrumb()
	{
		$output = '';
		$i = 1;
		foreach ( $this->breadcrumb_trail as $name => $link )
		{
			if ( $i == count($this->breadcrumb_trail) )
			{
				// On last item, only show text
				$output .= $name;
			}
			else
			{
				$output .= anchor($link, $name);
				$output .= " &#187; ";
			}
			$i++;
		}
		
		return $output;
	}
	
	/**
	 * Get Site Variables
	 * 
	 * Return a JS script tag containing all
	 * PHP to JS variable transfers
	 * 
	 * @return string 
	 */
	function get_variables()
	{
		if (count($this->variables) != 0)
		{
			$output = "<script type=\"text/javascript\">\n<!--\n";
			foreach($this->variables as $name => $value)
			{
				$output .= "var " . $name . " = ";
				$output .= $this->_handle_variable($value);
				$output .= ";\n";
			}
			$output .= "// -->\n</script>\n";

			return $output;
		}
		
		return null;
	}

	/**
	 * Get Javascript Code Blocks
	 *
	 * @return string
	 */
	function get_js_blocks()
	{
		$out = '';
		if(count($this->javascript_code_blocks) != 0)
		{
			$out = "<script type=\"text/javascript\">\n";
			$out .= implode( "\n", $this->javascript_code_blocks) . "\n" ;
			$out .= '</script>';
		}
		return $out;
	}

	/**
	 * Handle Variable
	 *
	 * @param mixed $value
	 * @return string
	 */
	function _handle_variable($value)
	{
		$output = '';
		switch(gettype($value))
		{
			case 'bool':
			case 'boolean':
				$output .= ($value===TRUE) ? "true" : "false";
				break;

			case 'integer':
			case 'double':
				$output .= $value;
				break;

			case 'string':
				$output .= "\"".$value."\"";
				break;

			case 'array':
				$output .= "new Array(";
                foreach($value as $item)
                {
                    $output .= $this->_handle_variable($item);
                    $output .= ",";
                }
                $output = substr($output,0,-1);
                $output .= ")";
                break;

			default:
				// Otherwise assume its NULL
				$output .= "null";
				break;
		}
		return $output;
	}
}

/* End of BeP_Site.php */
/* Location: ./modules/site/libraries/BeP_Site.php */