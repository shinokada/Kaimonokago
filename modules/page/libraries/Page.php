<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BackendPro
 *
 * An open source development control panel written in PHP
 *
 * @package		BackendPro
 * @author		Adam Price
 * @copyright	Copyright (c) 2008, Adam Price
 * @license		http://www.gnu.org/licenses/lgpl.html
 * @link		http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Page Class
 *
 * Asset management and optimisation library. Allows the programmer
 * a simple way to load default assets (js/css files) for both the public
 * and admin areas of a site. Also allows passing php variables into
 * javascript variables.
 *
 * @package   	BackendPro
 * @subpackage  Libraries
 */
class Page
{
	var $javascript = array();		// Javascript array
	var $meta_tags = array();		// Meta tag array
	var $variables = array();		// PHP -> JS variable array
	var $default_assets = array();	// Default page assets
	var $extra_assets = array();	// On-the-fly assets
	var $breadcrumb = array();		// Breadcrumb trail

	function Page()
	{
		// Create CI instance
		$this->CI = &get_instance();

		// Load needed files
		$this->CI->load->config('page');

		// Setup default, js_vars & on-fly asset arrays
		$this->default_assets = $this->CI->config->item('default_assets');
		$this->variables = $this->CI->config->item('default_page_variables');

		// Setup output string
		$this->output = "";

		log_message('debug', "BackendPro : Page Class loaded");
	}

	/**
	 * Set meta tag
	 *
	 * Save a meta tag ready for it to be outputed later
	 *
	 * @access public
	 * @param string $name Tag name
	 * @param string $value Tag content
	 * @param bool $http Tag type, TRUE means an http-equiv tag, FALSE for a name tag
	 * @return bool
	 */
	function set_metatag($name = NULL, $content = NULL, $http = FALSE)
	{
		if ($name == NULL)
		{
			return FALSE;
		}

		$this->meta_tags[$name] = array('content' => $content, 'type' => ($http?'equiv':'name'));
		return TRUE;
	}

	/**
	 * Load Asset file
	 *
	 * Quick load an asset file for inclusion straight away
	 * Checks the given asset is valid, if so adds it to an array ready
	 * for inclusion later.
	 *
	 * @access public
	 * @param string $area     Asset type
	 * @param string $type     Asset file type
	 * @param string $file     Asset file name
	 * @return bool
	 */
	function set_asset($area = NULL,$type = NULL,$file = NULL)
	{
		$file_tmp = $this->CI->config->item($area . "_assets") . $type . "/" . $file;
		if ( ! file_exists($file_tmp))
		{
			// Lets check the asset exists and is valid
			log_message("error","BackendPro->Page->set_asset : Asset is not valid or does not exist: " . $file_tmp);
			return FALSE;
		}

		// Otherwise add file to $this->extra_assets
		$this->extra_assets[$area][$type][] = $file;
		log_message('debug','BackendPro->Page->set_asset : Quick load of asset successful: ' . $file_tmp);
		return TRUE;
	}

	/**
	 * Setup transfer variable
	 *
	 * Transfer a variable from php to javascript
	 *
	 * @access public
	 * @param string $name Variable name
	 * @param mixed $value Variable value
	 * @return bool
	 */
	function set_variable($name = NULL,$value = NULL)
	{
		if ($name == NULL)
		{
			log_message("error","BackendPro->Page->set_variable : When transfering a variable a name must be given.");
			return;
		}

		$this->variables[$name] = $value;
		log_message('debug','BackendPro->Page->set_variable : PHP variable transfer successful: ' . $name);
		return;
	}

	/**
	 * Set Breadcrumb
	 *
	 * @access public
	 * @param string $name Name of crumb
	 * @param string $link CI Controller link e.g. auth/login
	 */
	function set_crumb($name, $link = '')
	{
		$this->breadcrumb_trail[$name] = $link;
		log_message('debug','BackendPro->Page->set_crumb : Breadcrumb link "'.$name.'" pointing to "'.$link.'" created');
	}

	/**
	 * Output meta tags
	 *
	 * @access public
	 * @param bool $print Print tags to page or return them
	 * @return string
	 */
	function output_metatags($print = TRUE)
	{
		if (count($this->meta_tags) == 0)
		{
			return '';
		}

		$output = '';
		foreach($this->meta_tags as $name => $tag)
		{
			$output .= meta($name, $tag['content'], $tag['type']);
		}

		if ($print)
		{
			print $output;
		}
		else
		{
			return $output;
		}
	}

	/**
	 * Output Breadcrumb Trail
	 *
	 * @access public
	 * @param bool $print Prints string to page instead of returning it
	 * @return string
	 */
	function output_breadcrumb($print = TRUE)
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

		// Print/Output trail
		if ($print)
		{
			print $output;
		}
		else
		{
			return $output;
		}
	}

	/**
	 * Output PHP to JS variable conversion code
	 *
	 * @access public
	 * @param bool $print If true output is printed, otherwise it is returned
	 * @return string
	 */
	function output_variables($print = TRUE)
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

			// Output HTML
			if($print)
			{
				print $output;
			}
			else
			{
				return $output;
			}
		}
	}

	/**
	 * Add a Javascript string to output to the page
	 *
	 * @access public
	 * @param string $js
	 */
	function set_js( $js )
	{
		$this->javascript[] = $js;
	}

	/**
	 * Output Page JavaScript
	 *
	 * @return string
	 */
	function output_js()
	{
		$out = '';
		if(count($this->javascript) != 0)
		{
			$out = "<script type=\"text/javascript\">\n";
			$out .= implode( "\n", $this->javascript) . "\n" ;
			$out .= '</script>';
		}
		return $out;
	}

	/**
	 * Icon Image
	 *
	 * Outputs code to show an icon image tag
	 *
	 * @access public
	 * @param string $name Icon name
	 * @param string $title Icon title
	 * @return mixed
	 */
	function icon($name = NULL, $title = NULL)
	{
		if($name == NULL)
		{
			log_message('error','Backendpro->Page->icon : Cannot output an icon if no name is given');
			return FALSE;
		}

		$icon = array(
			'src'   => $this->CI->config->item('shared_assets') . $this->CI->config->item('asset_icons') . $name . '.png',
			'alt'   => $name,
			'title' => $title);

		return img($icon);
	}

	/**
	 * Output Page Assets & Variables
	 *
	 * Create HTML code to include css/js files and transfer php variables
	 * to javscript ones.
	 *
	 * @access public
	 * @param string $area Specifies which assets to output, either 'public' OR 'admin'
	 * @param bool $print Whether to print the output or return it
	 * @return string Valid HTML code for including the needed css/js files into the HEAD tags
	 */
	function output_assets ($area = 'public',$print = TRUE)
	{
		if ($area != 'public' AND $area != 'admin')
		{
			// Just check a valid area has been given
			log_message("error","BackendPro->Page->output_assets : Cannot link asset area: " . $area);
			return;
		}

		// PREPARE ASSET OUTPUT
		$this->CI->load->helper('file');
		foreach(array('shared',$area) as $type)
		{
			foreach(array('js','css','cond_css') as $asset)
			{
				// Asset path
				if($asset == 'cond_css')
				{
					$dir = $this->CI->config->item($type . "_assets") . "css/";
				}
				else
				{
					$dir = $this->CI->config->item($type . "_assets") . $asset . "/";
				}

				// Get all files in asset path
				$asset_files = get_filenames($dir);

				// First lets check if there is a cache
				if($this->CI->config->item('asset_cache_length') != 0 && $asset != 'cond_css')
				{
					$is_cache = FALSE;
					foreach($asset_files as $file)
					{
						if( preg_match("/".$this->CI->config->item('asset_cache_file_pfx')."([0-9]+).*/",$file,$match))
						{
							// Check if the cache file has not expired
							if($match[1] >= time())
							{
								// Cache is valid
								$is_cache = TRUE;
								$this->{'_include_' . $asset}($dir . $file);
							}
							else
							{
								// Remove old cache file
								unlink($dir . $file);
							}
							break;
						}
					}

					// We couldn't find a valid cache file so create one
					if( ! $is_cache)
					{
						$this->_write_cache($dir,$type,$asset);
					}
				}
				else
				{
					// Caching is not used link files normally
					foreach($this->default_assets[$type][$asset] as $file)
					{
						if( file_exists ($dir . $file))
						{
							$this->{'_include_' . $asset}($dir . $file);
						}
					}
				}

				// Link any extra asset files loaded on the fly
				if( isset($this->extra_assets[$type][$asset]) && count($this->extra_assets[$type][$asset]) != 0)
				{
					foreach($this->extra_assets[$type][$asset] as $file)
					{
						$this->{'_include_' . $asset}($dir . $file);
					}
				}
			}
		}

		// Output HTML
		if($print)
		{
			print $this->output;
		}
		else
		{
			return $this->output;
		}
	}

	/**
	 * Include Conditional CSS File
	 *
	 * @access private
	 * @author ddrury
	 * @param string $file Filename
	 */
	function _include_cond_css($file)
	{
		if ($this->_test_conditions(basename($file,'.css')))
		{
			$this->_include_css($file);
		}
	}

	/**
	 * Test Browser Version
	 *
	 * When given a file name, check whether it should be displayed
	 * for this browser.
	 *
	 * @access private
	 * @author ddrury
	 * @param string $str Filename
	 * @return bool
	 */
	function _test_conditions($str)
	{
		// HACK: This is only a temp fix until I can find out why the origonal code didn't work
		$this->CI->load->library('user_agent');
		$CI = &get_instance();
		static $feature;
		if ( ! isset($feature))
		{
			switch($CI->agent->browser())
			{
				case('Internet Explorer'):
					$feature = 'ie';
					break;
				case('Firefox'):
					$feature = 'ff';
					break;
				case('Opera'):
					$feature = 'op';
					break;
				case('Safari'):
					$feature = 'sf';
					break;
				default:
					log_message('error','BackendPro->Page->_test_conditions : Unknown browser type: ' . $CI->agent->browser());
					$feature = '??';
			}
		}

		$elements=explode('_',$str);

		switch (count($elements))
		{
			case(1): // only browser
				$condition = (strtolower($elements[0]) == $feature);
				break;
			case(2): // browser and it's version
				$condition = (strtolower($elements[0]) == $feature);
				if ($condition)
				$condition = $this->_compare_versions($elements[1], '');
				break;
			case(3): // operator, browser & version
				$condition = (strtolower($elements[1]) == $feature);
				if ($condition)
				$condition = $this->_compare_versions($elements[2],$elements[0]);
				break;
		}
		return $condition;
	}

	/**
	 * Compare Browser Versions
	 *
	 * @access private
	 * @author ddrury
	 * @param string $value
	 * @param string $operator Operater value
	 * @return unknown
	 */
	function _compare_versions($value, $operator)
	{
		// HACK: Again this is related to the code in the above function, just a short fix for now
		$CI = &get_instance();
		static $major;
		static $minor = '0';
		if (! isset($major))
		{
			/* Build an array containing the major & minor
			 * browser versions. e.g array(2),(0014)
			 */
			$elements = explode('.',$CI->agent->version());
			$num = count($elements);
			$major = $elements[0];
			if ($num > 1)
			{
				$minor ='';
				for ($i=1; $i<$num;$i++)
				{
					$minor .= $elements[$i];
				}
			}
		}
		switch ($operator)
		{
			case('lt'):
				$op = '<';
				break;
			case('gt'):
				$op = '>';
				break;
			case('lte'):
				$op = '<=';
				break;
			case('gte'):
				$op = '>=';
				break;
			case('ne'):
				$op = '!=';
				break;
			default:
				$op = '==';
		}
		$parts = explode('#',$value);
		if (count($parts)>1)
		{
			$str = "($major.$minor $op $parts[0].$parts[1])";
		}
		else
		{
			$str = "($major $op $parts[0])";
		}
		eval("\$result = $str;");
		return $result;

	}

	/**
	 * Write cache file
	 *
	 * Write the given asset files to a cache file
	 *
	 * @access private
	 * @param string $path Cache file path
	 * @param string $area Choosen area, either public/admin/shared
	 * @param string $type Asset type, either css/js
	 * @return bool TRUE if cache file created, FALSE otherwise
	 */
	function _write_cache ($asset_path, $asset_area, $asset_type)
	{
		// Check dir is valid and writeable
		if ( ! is_dir ($asset_path) OR ! is_writable ($asset_path))
		{
			log_message('error','BackendPro->Page->_write_cache : Cache path is not a directory or is not writable: ' . $asset_path);
			return FALSE;
		}

		if(count($this->default_assets[$asset_area][$asset_type]) == 0)
		{
			// Don't create cache if there are no files to cache
			return FALSE;
		}

		// Create cache path with filename
		$asset_path = $asset_path . $this->CI->config->item('asset_cache_file_pfx') . ceil($this->CI->config->item('asset_cache_length')*3600 + time()) . "." . $asset_type;

		//Take what's in the buffer now and give it to ci
		$this->CI->output->append_output(ob_get_contents());
		ob_end_clean();

		// Foreach file belonging to $area & $type add it to the cache file
		$cache_output = "";
		$tmp_path = BASEPATH . "../" . $this->CI->config->item($asset_area . "_assets") . $asset_type . "/";
		foreach($this->default_assets[$asset_area][$asset_type] as $asset_file)
		{
			ob_start();
			include $tmp_path . $asset_file;
			$cache_output .= ob_get_contents();
			ob_end_clean();
		}
		//Restart the buffer so ci doesn't know anything happened
		ob_start();

		// Compress the cache data
		$cache_output = $this->_cache_compress($cache_output, $asset_type);

		// Write the cache file and link it
		$this->{'_include_' . $asset_type}($asset_path);
		return write_file($asset_path,$cache_output);
	}

	/**
	 * Compress Cache
	 *
	 * @access private
	 * @param string $data File contents
	 * @param string $type Asset type
	 * @return string
	 */
	function _cache_compress($data, $type)
	{
		if($type == 'css')
		{
			// CSS output, use csstidy
			if ( ! class_exists('csstidy'))
			{
				// Load class
				$csstidy = BASEPATH.$this->CI->config->item('csstidy_path');
				if (file_exists($csstidy))
				{
					require_once($csstidy);
				}
				else
				{
					log_message('error','BackendPro->Page->_cache_compress : Could not find CSS tidy class at: ' . $csstidy);
					return $data;
				}
			}

			// Create new instance of CSSTidy
			$this->csstidy = new csstidy();
			$this->csstidy->load_template('highest_compression');

			// Parse code
			$this->csstidy->parse($data);

			return $this->csstidy->print->plain();
		}

		return $data;
	}

	/**
	 * Output Script Code
	 *
	 * @access private
	 * @param string $file Filename of script to include
	 * @return string Generated script include code
	 */
	function _include_js($file)
	{
		$this->output .= '<script type="text/javascript" src="' . base_url() . $file . '"></script>';
		$this->output .= "\n";
	}

	/**
	 * Output Style Code
	 *
	 * @access private
	 * @param string $file Filename of style to include
	 * @return string Generated style include code
	 */
	function _include_css($file)
	{
		$this->output .= link_tag($file) . "\n";
	}

	/**
	 * Handle Variable
	 *
	 * @access private
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
/* End of file Page.php */
/* Location: ./modules/page/libraries/Page.php */