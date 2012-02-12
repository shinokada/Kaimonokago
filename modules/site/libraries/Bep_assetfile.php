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
 * Asset File Class
 * 
 * Represents an asset file used by the system
 * 
 * @package			BackendPro
 * @subpackage		Class
 * @author			Adam Price
 * @copyright		Copyright (c) 2009
 */
class Bep_assetfile
{
	/**
	 * File name
	 * 
	 * @var string
	 */
	var $name = NULL;
	
	/**
	 * Full file path
	 * 
	 * @var string
	 */
	var $full_path = NULL;
	
	/**
	 * File extension
	 * 
	 * @var string
	 */
	var $ext = NULL;
	
	/**
	 * File type
	 * 
	 * @var string
	 */
	var $type = NULL;
	
	/**
	 * Asset file dependencies
	 * 
	 * @var array
	 */
	var $needs = array();
	
	/**
	 * Is Asset file external to the local server
	 * 
	 * @var bool
	 */
	var $is_external = false;
	
	function Bep_assetfile($full_path)
	{		
		$this->full_path = $full_path;
		
		$this->_compile_data();
	}
	
	/**
	 * Compile class values from the full
	 * path
	 */
	function _compile_data()
	{		
		// Compile name & ext
		$base_name = basename($this->full_path);
		
		$dot = strrpos($base_name, '.');
		
		$this->name = substr($base_name,0,$dot);
		$this->ext = substr($base_name, $dot + 1);
		
		// Set the default type to that of the ext
		$this->type = $this->ext;
		
		// Set whether the asset is internal/external
		$this->is_external = ($base_name != $this->full_path);
	}
	
	/**
	 * Set the asset needs using a string. 
	 * Seperator is optional
	 * 
	 * @param string $str
	 * @param string $separator[optional]
	 */
	function set_needs($str, $separator = "|")
	{		
		$this->needs = explode($separator, $str);
	}
}

/* End of Bep_AssetFile.php */
/* Location: ./modules/site/libraries/BeP_AssetFile.php */