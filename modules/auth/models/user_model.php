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
 * User_model
 *
 * Provides functionaly to query all tables related to the
 * user.
 *
 * @package   	BackendPro
 * @subpackage  Models
 */
class User_model extends Base_model
{
	function User_model()
	{
		parent::Base_model();

		$this->_prefix = $this->config->item('backendpro_table_prefix');
		$this->_TABLES = array(    'Users' => $this->_prefix . 'users',
                                    'UserProfiles' => $this->_prefix . 'user_profiles');

		log_message('debug','BackendPro : User_model class loaded');
	}

	/**
	 * Validate Login
	 *
	 * Verify that the given login_field and password
	 * are correct
	 *
	 * @access public
	 * @param string $login_field Email/Username
	 * @param string $password Users password
	 * @return array('valid'=>bool,'query'=>Query)
	 */
	function validateLogin($login_field, $password)
	{
		if( !$password OR !$login_field)
		{
			// If there is no password
			return array('valid'=>FALSE,'query'=>NULL);
		}

		switch($this->preference->item('login_field'))
		{
			case'email':
				$this->db->where('email',$login_field);
				break;

			case 'username':
				$this->db->where('username',$login_field);
				break;

			default:
			    $this->db->where('(email = '.$this->db->escape($login_field).' OR username = '.$this->db->escape($login_field).')');
			    break;
		}

		$this->db->where('password',$password);

		$query = $this->fetch('Users','id,active');
		
		$found = ($query->num_rows() == 1);
		return array('valid'=>$found,'query'=>$query);
	}

	/**
	 * Update Login Date
	 *
	 * Updates a users last_visit record to the current time
	 *
	 * @access public
	 * @param integer $user_id Users user_id
	 */
	function updateUserLogin($id)
	{
		$this->update('Users',array('last_visit'=>date ("Y-m-d H:i:s")),array('id'=>$id));
	}

	/**
	 * Valid Email
	 *
	 * Checks the given email is one that belongs to a valid email
	 *
	 * @access public
	 * @param string $email Email to validate
	 * @return boolean
	 */
	function validEmail($email)
	{
		$query = $this->fetch('Users',NULL,NULL,array('email'=>$email));
		return ($query->num_rows() == 0) ? FALSE : TRUE;
	}

	/**
	 * Activate User Account
	 *
	 * When given an activation_key, make that user account active
	 *
	 * @access public
	 * @param string $key Activation Key
	 * @return boolean
	 */
	function activateUser($key)
	{
		$this->update('Users', array('active'=>'1','activation_key'=>NULL), array('activation_key'=>$key));

		return ($this->db->affected_rows() == 1) ? TRUE : FALSE;
	}

	/**
	 * Get Users
	 *
	 * @access public
	 * @param mixed $where Where query string/array
	 * @param array $limit Limit array including offset and limit values
	 * @return object
	 */
	function getUsers($where = NULL, $limit = array('limit' => NULL, 'offset' => ''))
	{
		// Load the khacl config file so we can get the correct table name
		$this->load->config('khaos', true, true);
		$options = $this->config->item('acl', 'khaos');
		$acl_tables = $options['tables'];

		// If Profiles are enabled load get their values also
		$profile_columns = '';
		if($this->preference->item('allow_user_profiles'))
		{
			// Select only the column names of the profile fields
			$profile_fields_array = array_keys($this->config->item('userlib_profile_fields'));

			// Implode and seperate with comma
			$profile_columns = implode(', profiles.',$profile_fields_array);
			$profile_columns = (empty($profile_fields_array)) ? '': ', profiles.'.$profile_columns;
		}

		$this->db->select('users.id, users.username, users.email, users.password, users.active, users.last_visit, users.created, users.modified, groups.name `group`, groups.id group_id'.$profile_columns);
		$this->db->from($this->_TABLES['Users'] . " users");
		$this->db->join($this->_TABLES['UserProfiles'] . " profiles",'users.id=profiles.user_id');
		$this->db->join($acl_tables['aros'] . " groups",'groups.id=users.group');
		if( ! is_null($where))
		{
			$this->db->where($where);
		}
		if( ! is_null($limit['limit']))
		{
			$this->db->limit($limit['limit'],( isset($limit['offset'])?$limit['offset']:''));
		}
		return $this->db->get();
	}

	/**
	 * Delete Users
	 *
	 * Extend the delete users function to make sure we delete all data related
	 * to the user
	 *
	 * @access private
	 * @param mixed $where Delete user where
	 * @return boolean
	 */
	function _delete_Users($where)
	{
		// Get the ID's of the users to delete
		$query = $this->fetch('Users','id',NULL,$where);
		foreach($query->result() as $row)
		{
			$this->db->trans_begin();
			// -- ADD USER REMOVAL QUERIES/METHODS BELOW HERE

			// Delete main user details
			$this->db->delete($this->_TABLES['Users'],array('id'=>$row->id));

			// Delete user profile
			$this->delete('UserProfiles',array('user_id'=>$row->id));

			// -- DON'T CHANGE BELOW HERE
			// Check all the tasks completed
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
				return FALSE;
			} else
			{
				$this->db->trans_commit();
			}
		}
		return TRUE;
	}
}

/* End of file: user_model.php */
/* Location: ./modules/auth/controllers/admin/user_model.php */