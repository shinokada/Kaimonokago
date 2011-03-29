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
 * Base_model
 *
 * Sets up basic model functions. All user created model classes should
 * extend this to gain access to its basic database model functions.
 *
 * @package			BackendPro
 * @subpackage		Models
 */
class Base_model extends Model
{
	function Base_model()
	{
		parent::Model();

		// Create empty function array
		$this->_TABLES = array();

		log_message('debug','BackendPro : Base_model class loaded');
	}

	/**
	 * Fetch
	 *
	 * Fetch table rows from table related to $name. Check no custom
	 * fetch method exists before hand.
	 *
	 * @access public
	 * @param string $name Table Name
	 * @param mixed $fields Fields to return from table
	 * @param array $limit Rows to limit search to
	 * @param mixed $where Return rows that match this
	 * @return Query Object
	 */
	function fetch($name, $fields=null, $limit=null, $where=null)
	{
		$func = '_fetch_'.$name;
		if(method_exists($this,$func))
		{
			// There is an overide function
			return call_user_func_array(array($this,$func), array($fields,$limit,$where));
		}
		else
		{
			// No override function, procede with fetch
			($fields!=null) ? $this->db->select($fields) : '';
			($where!=null) ? $this->db->where($where) : '';
			($limit!=null) ? $this->db->limit($limit['rows'],$limit['offset']) : '';

			return $this->db->get($this->_TABLES[$name]);
		}
	}

	/**
	 * Insert
	 *
	 * Insert new table data into table related to by $name
	 * Check no custom insert method exists before hand.
	 *
	 * @access public
	 * @param string $name Table Name
	 * @param array $data Data to insert
	 * @return Query Object
	 */
	function insert($name, $data)
	{
		$func = '_insert_' . $name;
		if(method_exists($this,$func))
		{
			// There is an overide function
			return call_user_func_array(array($this,$func), array($data));
		}
		else
		{
			// No override function, procede with insert
			return $this->db->insert($this->_TABLES[$name],$data);
		}
	}

	/**
	 * Update
	 *
	 * Update data in table related to by $name
	 * Check no custom update method exists before hand.
	 *
	 * @access public
	 * @param string $name Table Name
	 * @param array $values Data to change
	 * @param mixed $where Rows to update
	 * @return Query Object
	 */
	function update($name, $values, $where)
	{
		$func = '_update_' . $name;
		if(method_exists($this,$func))
		{
			// There is an overide function
			return call_user_func_array(array($this,$func), array($values,$where));
		}
		else
		{
			// No overside function, procede with general insert
			$this->db->where($where);
			return $this->db->update($this->_TABLES[$name],$values);
		}
	}

	/**
	 * Delete
	 *
	 * Delete rows from table related to by $name
	 * Check no custom delete method exists before hand.
	 *
	 * @access public
	 * @param string $name Table Name
	 * @param mixed $where Rows to delete
	 * @return Query Object
	 */
	function delete($name, $where)
	{
		$func = '_delete_' . $name;
		if(method_exists($this, $func))
		{
			// There is an overide function
			return call_user_func_array(array($this,$func), array($where));
		}
		else
		{
			// No overside function, procede with general insert
			$this->db->where($where);
			return $this->db->delete($this->_TABLES[$name]);
		}
	}
}
/* End of file base_model.php */
/* Location: ./system/application/models/base_model.php */