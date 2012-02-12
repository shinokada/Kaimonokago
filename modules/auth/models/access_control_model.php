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

include_once(APPPATH . 'models/Nested_sets_model.php');

/**
 * Access Control Model
 *
 * Provides functionaly to interact with the access control tables
 * in the database
 *
 * @package         BackendPro
 * @subpackage      Models
 */
class access_control_model extends Base_Model
{
	var $resource;
	var $group;

	function access_control_model()
	{
		parent::Base_model();

		// Setup allowed tables
		$this->load->config('khaos', true, true);
		$options = $this->config->item('acl', 'khaos');
		$this->_TABLES = $options['tables'];

		$this->_TABLES['groups'] = $this->config->item('backendpro_table_prefix')."groups";
		$this->_TABLES['resources'] = $this->config->item('backendpro_table_prefix')."resources";

		// Setup ACO Model
		$this->resource = new Nested_sets_model();
		$this->resource->setControlParams($this->_TABLES['acos']);
		$this->resource->setPrimaryKeyColumn('id');

		// Setup ARO Model
		$this->group = new Nested_sets_model();
		$this->group->setControlParams($this->_TABLES['aros']);
		$this->group->setPrimaryKeyColumn('id');

		log_message('debug','BackendPro : Access_control_model class loaded');
	}


	/**
	 * Get Tree Array
	 *
	 * @access public
	 * @param object $obj Reference to a Nested_sets_model object, ie $this->resource OR $this->group
	 * @return array
	 */
	/*function getTreeArray($obj)
	 {
	 // Tree array to return
	 $tree_array = array();

	 $tree = $obj->getTreePreorder($obj->getRoot());
	 while($obj->getTreeNext($tree))
	 {
	 if( $obj->checkNodeIsRoot($tree['row']))
	 {
	 // This is the root node
	 $tree_array[$tree['row']['name']] = $tree['row'];
	 $tree_array[$tree['row']['name']]['children'] = array();
	 }
	 else
	 {
	 // We have a child
	 // Lets get its parent
	 $parent = $obj->getAncestor($tree['row']);

	 // Work out root from here back to the root
	 $route_link = array($parent['name']);
	 while( ! $obj->checkNodeIsRoot($parent))
	 {
	 $parent = $obj->getAncestor($parent);
	 $route_link[] = $parent['name'];
	 }
	 $route_link = array_reverse($route_link);

	 // We now have route from root down to this node.
	 $target =& $tree_array[array_shift($route_link)];

	 if( ! empty($route_link))
	 {
	 foreach($route_link as $route)
	 {
	 $target =& $target['children'][$route];
	 }
	 }
	 $target['children'][$tree['row']['name']] = $tree['row'];
	 $target['children'][$tree['row']['name']]['children'] = array();
	 }
	 }

	 return $tree_array;
	 }*/

	/**
	 * Create Pretty Offset
	 *
	 * Creates a pretty text offset to display nested items using basic text
	 *
	 * @access public
	 * @param object $obj Reference to a Nested_sets_model object, e.g. $this->group, $this->resource
	 * @param array $tree Current Tree array
	 * @param string $next_ancestor_sibling String prepended to offset if there is a next sibling after the current ancestor
	 * @param string $no_next_ancestor_sibling String prepended to offset if there is no next sibling after the current ancestor
	 * @param string $last_sibling String appended to offset if this is the last node of the current level
	 * @param string $not_last_siling String appended to offset if this is not the last node of the current level
	 */
	function buildPrettyOffset($obj, $tree,
		$next_ancestor_sibling = "|&nbsp;&nbsp; ",
		$no_next_ancestor_sibling = "&nbsp;&nbsp;&nbsp; ",
		$last_sibling = "`- ",
		$not_last_sibling = "|- ")
	{
		$lvl = $obj->getTreeLevel($tree);

		// Nest the tree
		$offset = '';
		if($lvl > 1)
		{
			$ancestor = $obj->getAncestor($tree['row']);
			while( ! $obj->checkNodeIsRoot($ancestor))
			{
				if($obj->checkNodeHasNextSibling($ancestor))
				{
					// Ancestor has sibling so put a | in offset
					$offset = $next_ancestor_sibling . $offset;
				}
				else
				{
					// No next sibling just put space
					$offset = $no_next_ancestor_sibling . $offset;
				}
				$ancestor = $obj->getAncestor($ancestor);
			}
		}

		// If this is the last node add branch terminator
		if($obj->checkNodeHasNextSibling($tree['row']))
		{
			$offset .= $not_last_sibling;
		}
		elseif($lvl != 0)
		{
			$offset .= $last_sibling;
		}
		return $offset;
	}

	/**
	 * Build Pretty array for dropdown
	 *
	 * Constructs an array of the given tree to be used for a dropdown menu
	 *
	 * @access public
	 * @param string $tree_id Tree ID, either 'resource' OR 'group'
	 * @param string $value_field Table field to use as the option value
	 * @return array
	 */
	function buildACLDropdown($tree_id = NULL,$value_field = 'name')
	{
		if( $tree_id != 'group' AND $tree_id != 'resource')
		{
			show_error("BackendPro->Access_control_model->buildACLDropDown : The tree_id for the dropdown must be either 'group' OR 'resource'.");
		}

		$obj =& $this->{$tree_id};
		$tree = $obj->getTreePreorder($obj->getRoot());

		$dropdown = array();
		while($obj->getTreeNext($tree))
		{
			// Get offset
			$offset = $this->buildPrettyOffset($obj,$tree);

			$dropdown[$tree['row'][$value_field]] = $offset . $tree['row']['name'];
		}
		return $dropdown;
	}

	/**
	 * Get Permissions
	 *
	 * This is used to display the table of all the permissions
	 *
	 * @access public
	 * @param
	 * @return array
	 */
	function getPermissions($limit=NULL,$where=NULL)
	{
		// Run Query
		$this->db->select("acl.id, acl.allow, aros.name AS aro, acos.name AS aco, axos.name AS axo, actions.axo_id, actions.allow AS axo_allow");
		$this->db->from($this->_TABLES['access'].' AS acl');
		$this->db->join($this->_TABLES['access_actions'].' AS actions', 'acl.id=actions.access_id', 'left');
		$this->db->join($this->_TABLES['aros'].' AS aros','acl.aro_id=aros.id');
		$this->db->join($this->_TABLES['acos'].' AS acos','acl.aco_id=acos.id');
		$this->db->join($this->_TABLES['axos'].' AS axos','actions.axo_id=axos.id','left');
		$this->db->order_by('aro asc, aco, axo');

		if( ! is_null($where))
		{
			$this->db->where($where);
		}

		if(is_array($limit))
		{
			$this->db->limit($limit['limit'],$limit['offset']);
		}

		$query = $this->db->get();

		$data = array();

		foreach($query->result_array() as $row)
		{
			$id = $row['id'];
			$data[$id]['aro'] = $row['aro'];
			$data[$id]['aco'] = $row['aco'];
			$data[$id]['allow'] = ($row['allow']=='Y') ? TRUE : FALSE;

			if( ! is_null($row['axo']))
			{
				$allow = ($row['axo_allow']=='Y') ? TRUE : FALSE;
				$data[$id]['actions'][] = array('allow'=>$allow,'axo'=>$row['axo'],'id'=>$row['axo_id']);
			}
		}
		return $data;
	}

	/**
	 * Build Action Selector
	 *
	 * Constructs the interface to be used when creating/modifying a permission.
	 * It allows the user to select what actions if any the permission has.
	 *
	 * @access public
	 * @return string
	 */
	function buildActionSelector()
	{
		$value = '';
		$query = $this->fetch('axos');
		foreach($query->result() as $action)
		{
			$checkbox = 'action_'.$action->id;
			$radio = 'allow_'.$action->id;
			$value .= form_checkbox($checkbox,$action->name,$this->validation->set_checkbox($checkbox,$action->name));
			$value .= $action->name . "<br>\n";

			$value .= '<div id="'.$radio.'" class="action_item">';
			$value .= form_radio($radio,'Y',$this->validation->set_radio($radio,'Y')) . $this->lang->line('access_allow');
			$value .= form_radio($radio,'N',$this->validation->set_radio($radio,'N')) . $this->lang->line('access_deny') . '</div>';
		}
		return $value;
	}

	/**
	 * Build Resource Selector
	 *
	 * Used to build the tree like radio button interface to select a resource
	 *
	 * @access public
	 * @param boolean $disabled Whether the radio buttons should be clickable
	 * @return string
	 */
	function buildResourceSelector($disabled = FALSE)
	{
		return $this->_buildSelector($disabled,'aco');
	}

	/**
	 * Build Group Selector
	 *
	 * Used to build the tree like radio button interface to select a group
	 *
	 * @access public
	 * @param boolean $disabled Whether the radio buttons should be clickable
	 * @return string
	 */
	function buildGroupSelector($disabled = FALSE)
	{
		return $this->_buildSelector($disabled,'aro');
	}

	/**
	 * Build Selector
	 *
	 * Abstract method to construct a generic tree like radio button interface
	 *
	 * @access private
	 * @param boolean $disabled Whether the radio buttons should be clickable
	 * @param string $type Table ID to use, either 'aro' => 'group', or 'aco' => 'resource'
	 * @return string
	 */
	function _buildSelector($disabled,$type)
	{
		// Value to return
		$value = '';

		// Set the table type
		switch($type)
		{
			case 'aco': $obj = & $this->resource; break;
			case 'aro': $obj = & $this->group; break;
		}

		$disabled = ($disabled) ? ' disabled' : '';

		// Create Selector
		$tree = $obj->getTreePreorder($obj->getRoot());
		$lvl = 0;
		while($obj->getTreeNext($tree))
		{
			// Nest the tree
			$newLvl = $obj->getTreeLevel($tree);
			if ($lvl > $newLvl)
			{
				// Just gone up some levels
				$value .= str_repeat("</ul></li>",$lvl-$newLvl);
			}
			$lvl = $newLvl;

			$set = $this->validation->set_radio($type,$tree['row']['name']);

			// If no node is set and this is the root, set it
			if( ! is_null($set) AND $obj->checkNodeIsRoot($tree['row']))
			$set = ' checked';

			$open = ( ! is_null($set)) ? ' class="open"' : '';
			$value .='<li id="'.$tree['row']['id'].'"'.$open.'>'.form_radio($type,$tree['row']['name'],$set,$disabled).'<span>'.$tree['row']['name'].'</span>';

			if($obj->checkNodeHasChildren($tree['row']))
			{
				$value .= "<ul>";
			}
			else
			{
				$value .= "</li>";
			}
		}

		// Close Tree
		$value .= str_repeat("</ul></li>",$lvl);

		return $value;
	}
}
/* End of file: access_control_model.php */
/* Location: ./modules/auth/models/access_control_model.php */