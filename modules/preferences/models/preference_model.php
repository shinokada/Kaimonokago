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
 * Preference_model
 *
 * Model used to retrive webite options
 *
 * @package			BackendPro
 * @subpackage		Models
 */
class Preference_model extends Base_model
{
	/**
	 * Preference Cache
	 * 
	 * @var array
	 */
	var $preferenceCache = array();
	
	/**
	 * Object Keyword
	 * 
	 * This is the keyword which prepends a serialize object
	 * Using this the system knows when to unserialize a string
	 * or to use it raw.
	 * 
	 * Don't change this unless you have a very good reason. It
	 * is needed otherwise it will spam the logs with errors.
	 * 
	 * @var string
	 */
 	var $object_keyword = "BeP::Object::";
 	
	function Preference_model()
	{
		parent::Base_model();		

		define("PREFERENCES", $this->config->item('backendpro_table_prefix') . 'preferences');

		log_message('debug','BackendPro : Preference_model class loaded');
	}

	/**
	 * Get Option
	 *
	 * Get a option with name $name from the database
	 * If the item is serialized, unserialize it and return object
	 *
	 * @param string $name Option name
	 * @return mixed
	 */
	function item($name)
	{
		// See if we have already got the setting
		if( isset($this->preferenceCache[$name]))
		{
			return $this->preferenceCache[$name];
		}

		// Get all preferences and fill the cache
		$this->db->select('name, value');
		$this->db->from(PREFERENCES);
		$query = $this->db->get();
		
		foreach($query->result() as $row)
		{
			if($this->object_keyword == substr($row->value,0,strlen($this->object_keyword)-1))
			{
				// Return object
				$object = substr($row->value,strlen($this->object_keyword));
				$this->preferenceCache[$row->name] = unserialize($object);
			}
			else
			{
				// Return string
				$this->preferenceCache[$row->name] = $row->value;
			}			
		}

		if( isset($this->preferenceCache[$name]))
		{
			return $this->preferenceCache[$name];
		}
		else
		{
			log_message("error","BackendPro->Preference_model->item : Preference is not valid: " . $name);
			return false;
		}		
	}

	/**
	 * Set Option
	 *
	 * Updates an option value in the database
	 *
	 * @param string $name Option name
	 * @param mixed $value Option value
	 * @return boolean
	 */
	function set_item($name, $value)
	{
		if( is_null($name))
        	{
            	return false;
        	}

        	$this->preferenceCache[$name] = $value;

        	if( is_array($value))
        	{
            	$value = $this->object_keyword . serialize($value);
        	}
        
        	$this->db->where('name', $name);
        	return $this->db->update(PREFERENCES, array('value'=>$value)); 
	}
}

/* End of file preference_model.php */
/* Location: ./modules/preferences/models/preference_model.php */