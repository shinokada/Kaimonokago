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

include_once('Bep_assetfile.php');

/**
 * BackendPro Asset Class
 * 
 * Allows assets to be loaded and the outputed depending upon the users
 * browser.
 * 
 * @package			BackendPro
 * @subpackage		Libraries
 * @author			Adam Price
 * @copyright		Copyright (c) 2009
 */
class Bep_assets
{		
	/**
	 * CodeIgniter Instance
	 * 
	 * @var object
	 */
	var $CI;
	
	/**
	 * Asset names to load
	 * @var array
	 */
	var $assets_to_load = array();
	
	/**
	 * Assets from Config
	 * 
	 * 'asset_name' => BeP_AssetFile() object
	 * 
	 * @var array
	 */
	var $assets = array();
	
	/**
	 * Asset groups from Config
	 * 
	 * 'group_name' => array('asset_name','asset_name');
	 * 
	 * @var array
	 */
	var $asset_groups = array();
	
	/**
	 * A list of all JS assets which
	 * must be loaded at the top of the document
	 * @var array
	 */
	var $top_js_assets = array();
	
	/**
	 * Asset caching options from config
	 * 
	 * @var array
	 */
	var $caching_options = array();
	
	/**
	 * CSS Tidy Class
	 * @var object
	 */
	var $csstidy = null;
	
	/**
	 * Packer Class
	 * @var object
	 */
	var $packer = null;
	
	function Bep_assets()
	{
		log_message('info','BackendPro->BeP_Assets : Class loaded');
		$this->CI = &get_instance();
		
		$this->CI->load->config('bep_assets',TRUE);
		
		// Load assets from config and transform them
		// into something more searchable
		$assets = $this->CI->config->item('asset','bep_assets');
		$this->assets = $this->_transform_assets($assets);
		
		// Load asset groups from config and transform
		// them into something more searchable and useable
		$groups = $this->CI->config->item('asset_group','bep_assets');
		$this->asset_groups = $this->_transform_groups($groups);
		
		$this->caching_options = $this->CI->config->item('asset_caching','bep_assets');
	}
	
	/**
	 * Get Icon Image
	 *
	 * Create a img tag linking to a given icon image
	 *
	 * @param string $name Icon name
	 * @param string $title Icon title
	 * @return mixed
	 */
	function icon($name, $title = false)
	{
		if($name == NULL)
		{
			log_message('error','Backendpro->bep_assets->icon : Cannot output an icon if no name is given');
			return FALSE;
		}

		// TODO: This asset path should be set in config
		// TODO: Should be able to load icons of type gif
		$icon['src'] = 'assets/icons/' . $name . '.png';
		$icon['alt'] = $name;
		
		if($title)
		{
			$icon['title'] = $title;
		}

		return img($icon);
	}
	
	/**
	 * Load Asset
	 * 
	 * Load an asset as specified in the config file
	 * 
	 * @param string $name Asset name
	 */
	function load_asset($name)
	{
		if($name == NULL)
		{
			return;
		}
		
		log_message('debug','BackendPro->Bep_Assets->load_asset : Attempting to load an asset with name : ' . $name);
		
		if($this->_is_loadable($name))
		{
			$this->_load_dependencies($name);			
			$this->assets_to_load[] = $name;
		}
	}
	
	/**
	 * Load Specific Browser Asserts
	 * 
	 * Look over all currently loaded assets and see
	 * if any have cond asset files. If they match
	 * the users browser then load them. 
	 *
	 * @access private
	 */
	function _load_browser_assets()
	{	
		// HACK: This is a hack for PHP4, since the main CI variable hasn't loaded correctly
		if(substr(phpversion(),0,1) == '4')
		{
			$this->CI = &get_instance();
		}
		
		// Load the browser class along with user_agent
		$this->CI->load->library('Bep_browser');		
		$this->CI->bep_browser->LoadUserAgent();
				
		if($this->CI->agent->is_browser() === FALSE)
		{
			// Not a known browser so don't continue
			return;
		}
		
		// TODO: Use config set location
		$dir = 'assets/css/';

		if(is_dir($dir))
		{
			if($dh = opendir($dir))
			{
				while(($file = readdir($dh)) !== FALSE)
				{
					$matches = array();
					if(preg_match('|(\w+)(?:\[(?:([a-z]+)_)?([a-z]{2})(?:_([0-9\.]+))?\])\.[a-z]+|i',$file,$matches))
					{
						// See if the file matches any we know about
						foreach($this->assets as $name => $asset)
						{
							// Does it need loading for this browser
							if(	in_array($name,$this->assets_to_load) && // Are we loading this asset
								$asset->name == $matches[1] && // Does the filename match the start of the cond css file
								$this->CI->bep_browser->DoesNameAndVersionMatch($matches[2],$matches[3],$matches[4])) // Does this browser need this file
							{
								// Add the asset to the $this->asset list
								// and then call load asset
								$md5 = md5($matches[0]);
								$this->assets[$md5] =  new BeP_AssetFile(base_url() . $dir . $matches[0]);
								
								$this->load_asset($md5);
								break;
							}
						}
					}
				}
				closedir($dh);
			}
		}
	}
	
	/**
	 * Load Asset Group
	 * 
	 * Load a group of assets as specified in the config
	 * 
	 * @param string $group Group name
	 */
	function load_asset_group($group)
	{
		if($group == NULL)
		{
			return;
		}
		
		log_message('debug','BackendPro->Bep_Assets->load_asset_group : Attempting to load an asset group with name : ' . $group);
		
		if(array_key_exists($group,$this->asset_groups))
		{
			foreach($this->asset_groups[$group] as $asset)
			{
				$this->load_asset($asset);
			}
		}
	}
	
	/**
	 * Get Header Assets
	 * 
	 * Get all assets which have to be put in the <head>
	 * tags. This will be things like CSS files and a few
	 * JS files which need the use of document.write
	 * 
	 * @return string
	 */
	function get_header_assets()
	{
		$this->_load_browser_assets();
		return $this->_get_asset_section('header');
	}
	
	/**
	 * Get Footer Assets
	 * 
	 * Get all assets which have to be put at the end of the
	 * <body> tag. This will be things like JS files which
	 * don't use the document.write function. By default
	 * all JS files will be outputed here.
	 * 
	 * @return string
	 */
	function get_footer_assets()
	{
		return $this->_get_asset_section('footer');
	}
	
	/**
	 * Get Asset Section
	 * 
	 * Generate asset links for all CSS and JS for a certain
	 * section, either 'header' or 'footer'
	 * 
	 * @access private
	 * @return string 
	 * @param string $section[optional] Section to generate assets for
	 */
	function _get_asset_section($section = 'header')
	{
		log_message('info','BackendPro->Bep_Assets->_get_asset_section : Getting all ' . $section . ' assets');
		
		// Setup some variables we will need
		$css_assets = array();
		$js_assets = array();
		$output = "";
		
		// Get all assets which can be outputed in this section
		foreach($this->assets_to_load as $name)
		{
			if($section == 'header' && $this->assets[$name]->type == 'css')
			{
				// Only load CSS asset into header
				log_message('debug','BackendPro->Bep_Assets->_get_asset_section : Adding CSS asset to load list : ' . $name);
				$css_assets[] = $name;
			}
			elseif($this->assets[$name]->type == 'js')
			{
				if(($section == 'header' && in_array($name,$this->top_js_assets)) || ($section == 'footer' && !in_array($name,$this->top_js_assets)))
				{
					// Only include this JS asset if
					// 		This is the header section and its in the header asset list
					//		This is the footer section and its not in the header asset list
					log_message('debug','BackendPro->Bep_Assets->_get_asset_section : Adding JS asset to load list : ' . $name);
					$js_assets[] = $name;
				}
			}
		}

		// Check if we need to optimise
		if($this->CI->config->item('optimise_assets','bep_assets'))
		{
			log_message('debug','BackendPro->Bep_Assets->_get_asset_section : Optimise assets selected, checking if previous cache exists');
			
			foreach(array($css_assets,$js_assets) as $key => $assets)
			{
				// If some assets are in this list
				if(count($assets) > 0)
				{
					// Create an md5 of them and see if an asset cache exists
					$md5 = md5(implode('|',$assets));
					if(($file_name = $this->_cache_exists($md5)) !== FALSE)
					{
						// Output the asset file
						$output .= $this->_output_cache_asset($file_name);
					}
					else
					{
						// Create a new cache for the assts, then output
						$type = ($key == 0) ? 'css' : 'js';
						$file_name = $this->_create_cache($assets,$type);
						$output .= $this->_output_cache_asset($file_name);
					}
				}
			}
		}
		else
		{
			log_message('debug','BackendPro->Bep_Assets->_get_asset_section : Optimise not selected, output assets');
			
			// No optimisation, just get all the files
			foreach(array($css_assets,$js_assets) as $assets)
			{
				foreach($assets as $name)
				{
					$output .= $this->_output_asset($name);
				}
			}
		}
		
		log_message('debug','BackendPro->Bep_Assets->_get_asset_section : Finished getting ' . $section . ' section');
		return $output;
	}
	
	/**
	 * Output Asset
	 * 
	 * Output an asset depending on what type it is.
	 *
	 * @access private
	 * @param string $name Asset name
	 * @return string Asset link/script tag
	 */
	function _output_asset($name)
	{
		// Lets see what type of asset it is
		$asset = $this->assets[$name];
		
		switch($asset->type)
		{
			case 'css':
				return $this->_output_css_asset($asset->full_path);
				break;
			
			case 'js':
				return $this->_output_js_asset($asset->full_path);
				break;
			
			default:
				log_message('debug','BackendPro->Bep_Assets->_output_asset : Unknown asset type : ' . $asset->type);
				return NULL;
		}
	}
	
	/**
	 * Output CSS asset
	 * 
	 * @access private
	 * @param string $path Full url path to asset
	 * @return string CSS link tag
	 */
	function _output_css_asset($path)
	{		
		log_message('debug','BackendPro->Bep_Assets->_output_css_asset : Outputing asset with path : ' . $path);
		return link_tag($path,'stylesheet','text/css') . "\n";
	}
	
	/**
	 * Output JS asset
	 * 
	 * @access private
	 * @param string $path Full url path to asset
	 * @return string JS script tag
	 */
	function _output_js_asset($path)
	{		
		log_message('debug','BackendPro->Bep_Assets->_output_js_asset : Outputing asset with path : ' . $path);
		return '<script type="text/javascript" src="' . $path . '"></script>' . "\n";
	}
	
	/**
	 * Check Cache Exists
	 * 
	 * Check if an asset cache file exists and that it
	 * has not expired
	 * 
	 * @access private
	 * @param string $file_name Cache filename without ext
	 * @return mixed Full filename if found, False otherwise
	 */
	function _cache_exists($file_name)
	{		
		if(is_dir($this->caching_options['path']))
		{
			if($dh = opendir($this->caching_options['path']))
			{
				while (($file = readdir($dh)) !== FALSE)
				{
					$matches = array();
					if(preg_match('/([a-zA-Z0-9]+).(css|js)/',$file,$matches))
					{
						list(,$name,) = $matches;
						
						if($name == $file_name)
						{
							// We found a matching asset file
							$created_time = filectime($this->caching_options['path'] . $file);
							$expire_time = $created_time + ($this->caching_options['expire_time']*60*60);						
							
							if($expire_time > time())
							{
								// Asset is still valid
								log_message('debug','BackendPro->Bep_Assets->_cache_exists : Cache file found : ' . $file);
								closedir($dh);
								return $file;
							}
							else
							{
								// Cache has expired, lets clear the cache folder
								log_message('debug','BackendPro->Bep_Assets->_cache_exists : Cache found but expired, performing clean');
								$this->_clean_cache();
								closedir($dh);
								return FALSE;
							}
						}
					}
				}
				closedir($dh);
			}
		}
		
		log_message('debug','BackendPro->Bep_Assets->_cache_exists : Cache file not found : ' . $file_name);
		return false;
	}
	
	/**
	 * Clean out the Asset cache directory of all
	 * expired asset files 
	 *
	 * @access private
	 */
	function _clean_cache()
	{
		$expire_count = 0;
		$dir = $this->caching_options['path'];
		
		log_message('debug','BackendPro->BeP_Assets->_clean_cache : Cleaning out asset cache : ' . $this->caching_options['path']);
		
		if(is_dir($dir))
		{
			if($dh = opendir($dir))
			{
				while (($file = readdir($dh)) !== FALSE)
				{
					// TODO: Put a regex expression here so only certain files are found
					if($file == '.' || $file == '..')
					{
						// Don' try to delete the dir links
						continue;
					}
					
					// Whats the files expire time
					$created_time = filectime($dir . $file);
					$expire_time = $created_time + ($this->caching_options['expire_time']*60*60);
					
					if($expire_time <= time())
					{
						// TODO: Check this can work on the Apache Server
						// Its expired, delete it
						if(@unlink($dir . $file))
						{
							log_message('debug',"BackendPro->BeP_Assets->_clean_cache : File deleted '" . $dir . $file . "'");
							$expire_count++;
						}
						else
						{
							log_message('error',"BackendPro->BeP_Assets->_clean_cache : Could not delete file '" . $dir . $file . "'");
						}				
					}					
				}
				closedir($dh);
			}
		}
	}

	/**
	 * Output Cache Asset
	 * 
	 * Output a cache asset file
	 * 
	 * @access private
	 * @param string $file_name Asset cache full filename
	 * @return string Asset link/script tag
	 */
	function _output_cache_asset($file_name)
	{
		// Extract the details of the file
		list($name,$ext) = $this->_get_file_details($file_name);
		
		switch($ext)
		{
			case 'css':
				return $this->_output_css_asset(base_url() . $this->caching_options['path'] . $file_name);
				break;
			
			case 'js':
				return $this->_output_js_asset(base_url() . $this->caching_options['path'] . $file_name);
				break;
			
			default:
				log_message('error','BackendPro->Bep_Assets->_output_cache_asset : Unknown asset type : ' . $ext);
				return NULL;
		}
	}
	
	/**
	 * Create Cache
	 * 
	 * Create a cache for a single type of asset.
	 * Depending on the optimise options
	 * 
	 * @access private
	 * @param array $assets Array of asset names to include in cache
	 * @param string $type Type of cache file to create, CSS/JS
	 * @return string Cache file created
	 */
	function _create_cache($assets, $type)
	{
		log_message('debug','BackendPro->Bep_Assets->_create_cache : Creating cache');
		
		// First concatenate all assets into
		// a single string
		$output = "";
		$cache_output = true;
		foreach($assets as $name)
		{
			if($this->assets[$name]->ext != 'php')
			{
				if($this->assets[$name]->is_external)
				{
					// We have no other way to get the file contents other than this
					// but for it to work allow_url_fopen must be true on the target server
					$output .= file_get_contents($this->assets[$name]->full_path);
				}
				else
				{
					// TODO: This assets folder should be configurable
					// Since it is local lets try to load it not using the full URL
					$output .= file_get_contents('assets/' . $this->assets[$name]->type . '/' . $this->assets[$name]->name . '.' . $this->assets[$name]->ext);
				}				
			}
			else
			{
				// BUG: This will fail if the asset is an external php file
				ob_start();
				include str_replace(base_url(),'',$this->assets[$name]->full_path);
				$output .= ob_get_contents();
				ob_end_clean();
			}			
		}
		
		// Optimise the output
		$output = $this->_optimise_output($output, $type);
		
		// Write the output to file
		$md5 = md5(implode('|',$assets));
		
		// TODO: Check this both works localy and on linex file system
		if($fh = fopen($this->caching_options['path'] . $md5 . "." . $type,'w'))
		{
			fwrite($fh,$output);
			fclose($fh);
		}
		
		return $md5 . "." . $type;
	}
	
	/**
	 * Optimise Output String
	 * 
	 * Takes either a CSS or JS string and compacts it using
	 * external plugins CSSTidy/Packer.
	 * 
	 * @access private
	 * @return string
	 * @param string $string String to compact
	 * @param string $type Type, either 'css' or 'js'
	 */
	function _optimise_output($string, $type)
	{
		switch($type)
		{
			case 'css':
				// Do we have a CSS Tidy plugin
				$csstidy_options = $this->CI->config->item('csstidy','bep_assets');

				if($csstidy_options['path'] != "" && file_exists($csstidy_options['path']))
				{
					// Do we need to load the plugin
					if($this->csstidy == null)
					{
						include_once($csstidy_options['path']);
						
						$this->csstidy = new CSSTidy();
						
						//load template and configure
			            $this->csstidy->load_template($csstidy_options['template']);
			            foreach ($csstidy_options['config'] as $key => $val)
						{
			                $this->csstidy->set_cfg($key, $val);
			            }
					}				
					
					// Parse the text
					$this->csstidy->parse($string);
					$string = $this->csstidy->print->plain();
				}
				break;
				
			case 'js':
				// Do we have a JS packer
				$packer_options = $this->CI->config->item('packer','bep_assets');

				if($packer_options['path'] != "" && file_exists($packer_options['path']))
				{
					// Do we need to load the plugin
					if($this->packer == null)
					{
						include_once($packer_options['path']);					
					}				
					
					// Parse the text
					$this->packer = new JavaScriptPacker($string);
					$string = $this->packer->pack();
				}
				break;
		}
		
		return $string;
	}
	
	/**
	 * Load Asset Dependencies
	 * 
	 * Load all asset dependencies recursivly
	 * 
	 * @access private
	 * @param string $asset Asset name
	 */
	function _load_dependencies($asset)
	{
		if(isset($this->assets[$asset]))
		{
			if(count($this->assets[$asset]->needs) != 0)
			{
				// Do we need to recurse the position
				$recurse_position = (in_array($asset, $this->top_js_assets));
				
				foreach($this->assets[$asset]->needs as $needed_asset)
				{
					// If the asset we are loading has requested to be
					// in the header, then make sure each dependant asset
					// is also load in the header, otherwise we won't have
					// the correct assets to run this one
					if($recurse_position)
					{
						$this->top_js_assets[] = $needed_asset;
					}
					
					$this->load_asset($needed_asset);
				}
			}
		}
	}
	
	/**
	 * Transform the asset string specified in the config
	 * so an asset name is extracted (either from the name value
	 * or from the filename). Also fill any blank values with default
	 * values
	 * 
	 * [file_ext, type, needs, file, position, name]
	 * 
	 * @access private
	 * @param array $assets Assets array from config
	 * @return array
	 */
	function _transform_assets($assets)
	{
		$transformed = array();
		
		foreach($assets as $asset)
		{			
			list($file_name,$ext) = $this->_get_file_details($asset['file']);
		
		 	// Create an asset file object
			$new_asset = new Bep_assetfile($asset['file']);
			
			// Transfer the needs accross
			if(isset($asset['needs']))
			{
				$new_asset->set_needs($asset['needs'],'|');
			}
			
			// Transfer the type across
			if(isset($asset['type']))
			{
				$new_asset->type = $asset['type'];
			}

			// Transform the file name/path so its a full url
			if(strpos($asset['file'],'http://') === FALSE)
			{
				// TODO: Use path from config
				// Can't find an http so it must be just a file
				// name, create full url path
				$new_asset->full_path = base_url() . "assets/" . $new_asset->type . "/" . $asset['file'];
			}
			
			// If a position is specified & is JS, record it
			if(isset($asset['position']) && $new_asset->type == 'js')
			{
				$this->top_js_assets[] = (isset($asset['name']) ? $asset['name'] : $file_name);
			}
			
			// Save the asset for loading with the correct name
			if(isset($asset['name']))
			{
				$transformed[$asset['name']] = $new_asset;
			}	
			else
			{
				$transformed[$file_name] = $new_asset;
			}
		}
		
		return $transformed;
	}
	
	/**
	 * Transform Asset Groups
	 * 
	 * Transform the asset groups from the config so the
	 * assets are in an array rather than a | delimited string
	 * 
	 * @access private
	 * @param array $groups Asset groups array from config
	 * @return array
	 */
	function _transform_groups($groups)
	{
		$transformed = array();
		
		foreach($groups as $name => $value)
		{
			$transformed[$name] = explode('|',$value);
		}
		
		return $transformed;
	}
	
	/**
	 * Get File Details
	 * 
	 * Extract details from a file path including file name,
	 * and extension
	 * 
	 * @access private
	 * @param string $file Either file name/path
	 * @return array Array with name follwed by extension
	 */
	function _get_file_details($file)
	{
		// First lets get the ext
		$ext = substr(strrchr($file,'.'),1);
		
		// Now get the full filename
		$name = substr(strrchr($file,'/'),1);
		if(!$name)
		{
			// No path found, return file name
			$name = $file;
		}
		
		// Get rid of extension
		$name = substr($name,0,-(strlen($ext)+1));
		
		return array($name,$ext);
	}
	
	/**
	 * IsLoadable
	 * 
	 * Check if an asset is loadable, this makes
	 * sure assets are not loaded twice, can be found
	 * etc.
	 * 
	 * @access private
	 * @param string $name Asset name
	 * @return bool
	 */
	function _is_loadable($asset)
	{
		// Check no asset with the same name is already loaded		
		if(in_array($asset,$this->assets_to_load))
		{
			return false;
		}		
		
		// If not lets see if we have an asset with that name in our list
		foreach($this->assets as $name => $values)
		{
			if($asset == $name)
			{
				//TODO: Is the asset file findable?
				return true;
			}
		}
		
		// Can't find asset
		log_message('error','BackendPro->Bep_Assets->_is_loadable : Cannot find any asset with given name : ' . $asset);
		return false;
	}
}

/* End of Bep_Assets.php */
/* Location: ./modules/site/libraries/Bep_Assets.php */