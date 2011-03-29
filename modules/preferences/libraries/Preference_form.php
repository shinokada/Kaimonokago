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
 * Preference Form
 *
 * Allows the creation of a preference page for a controller
 *
 * @package         BackendPro
 * @subpackage      Libraries
 */
class Preference_form
{
	var $form_name = 'Preferences';     // Default name of form
	var $form_link = NULL;
	var $field = array();               // Array containing all field information
	var $group = array();               // Array containing all field groups
	var $defaults = array(              // Default array containing mappings from field types => default rule
            'text'     => 'trim',
            'textarea' => 'trim'
            );

	function Preference_form($config = array())
	{
		// Get CI Instance
		$this->CI = &get_instance();

		// Initalize Class
		if(count($config) != 0)
		{
			$this->initalize($config);
		}

		// Load language files
		$this->CI->lang->load('preferences');
		$this->CI->load->helper('form');

		log_message('debug','BackendPro : Preference_form class loaded');
	}

	/**
	 * Initalize Class
	 *
	 * Setup the class using the config array
	 *
	 * @access public
	 * @param array $config Config array
	 */
	function initalize($config = array())
	{
		foreach($config as $key => $value)
		{
			$this->{$key} = $value;
		}
	}

	/**
	 * Setup fields
	 *
	 * Make sure that each field has a label, type, rule & param array
	 *
	 * @access private
	 */
	function _setup_fields()
	{
		// Make sure every field in $group has a $field entry
		foreach($this->group as $key => $value)
		{
			foreach(explode(',',$value['fields']) as $name)
			{
				if( ! isset($this->field[$name]))
				{
					$this->field[$name] = array();
				}
			}
		}

		foreach($this->field as $field => $data)
		{
			// Assign default label name
			if ( FALSE !== ($label = $this->CI->lang->line('preference_label_'.$field)))
			{
				$this->field[$field]['label'] = $label;
			}
			else
			{
				$this->field[$field]['label'] = ucwords(preg_replace('/_/',' ',$field));
			}

			// Check a type is given, if not set it to 'text'
			if ( ! isset($this->field[$field]['type']))
			{
				$this->field[$field]['type'] = 'text';
			}

			// Check a rule exists, if not set the default rule for that type
			if ( ! isset($this->field[$field]['rules']))
			{
				$this->field[$field]['rules'] = ( isset($this->defaults[$this->field[$field]['type']])) ? $this->defaults[$this->field[$field]['type']] : "";
			}

			// Check a params array exists
			if ( ! isset($this->field[$field]['params']))
			{
				$this->field[$field]['params'] = array();
			}
		}
	}

	/**
	 * Display Preference Form
	 *
	 * Display either the field groupings menu OR the actual field form
	 *
	 * @access public
	 * @param boolean $print Output to screen
	 * @return mixed
	 */
	function display($print = FALSE)
	{
		// Check a form base link is set
		if( is_null($this->form_link))
		{
			show_error("BackendPro->Preference_form->display : You must specify the full base url to the controller creating the preference form. E.g. ".$this->CI->uri->ruri_string());
		}

		// Set breadcrumb
		$this->CI->bep_site->set_crumb($this->form_name,$this->form_link);

		// Setup fields
		$this->_setup_fields();

		if(count($this->group) != 0)
		{
			$group_id = $this->CI->uri->segment($this->CI->uri->total_segments());
			if(array_key_exists($group_id,$this->group))
			{
				// Display group fields
				$this->CI->bep_site->set_crumb($this->group[$group_id]['name'],$this->form_link."/".$group_id);
				return $this->_display_fields($print, $group_id);
			}
			else
			{
				// Display group listings
				$data['group'] = $this->group;
				$data['form_link'] = $this->form_link;
				$data['header'] = $this->form_name;
				return $this->CI->load->view("field_groups",$data, !$print);
			}
		}

		// Display fields
		return $this->_display_fields($print);
	}

	/**
	 * Display Fields
	 *
	 * Display the form to edit the requested fields
	 *
	 * @access private
	 * @param boolean $print Output to screen
	 * @param string $group_id Group id
	 * @return mixed
	 */
	function _display_fields($print,$group_id = NULL)
	{
		if( ! is_null($group_id))
		{
			// Only show group fields
			foreach(explode(',',$this->group[$group_id]['fields']) as $key)
			{
				$key = trim($key);
				$fields_to_show[$key] = $this->field[$key];
			}
		}
		else
		{
			// Show all fields
			$fields_to_show = $this->field;
		}

		// Setup form validation
		$this->CI->load->library('validation');
		foreach($fields_to_show as $key => $value)
		{
			$form_fields[$key] = "'".$value['label']."'";
			$form_rules[$key] = $value['rules'];
		}
		$this->CI->validation->set_fields($form_fields);
		$this->CI->validation->set_rules($form_rules);

		// If this is the first load, get preference values from the DB
		if( ! $this->CI->input->post('submit'))
		{
			foreach($fields_to_show as $key => $value)
			{
				$this->CI->validation->$key = $this->CI->preference->item($key);
			}
		}

		if ($this->CI->validation->run() === FALSE)
		{
			// SHOW FORM
			// Show validation errors
			$this->CI->validation->output_errors();

			// Create the fields input and pass the data into an array ready for viewing
			foreach($fields_to_show as $key => $value)
			{
				// Call function for the given field type
				$this->field[$key]['input'] = call_user_func(array(&$this,"_field_".$this->field[$key]['type']),$key);
				// Pass field data over to view
				$data['field'][$key] = $this->field[$key];
			}

			// Display Page
			$data['header'] = ( is_null($group_id) ? $this->form_name : $this->group[$group_id]['name']);
			$data['form_link'] = $this->form_link . "/" . $group_id;
			$data['cancel_link'] = $this->form_link;
			return $this->CI->load->view("form_preference_fields",$data,!$print);
		}
		else
		{
			// SAVE FORM CONTENTS
			foreach($fields_to_show as $key=>$value)
			{
				$this->CI->preference->set_item($key,$this->CI->input->post($key));
			}

			// Show success message and redirect
			flashMsg('success',sprintf($this->CI->lang->line('preference_saved_successfully'),( is_null($group_id) ? $this->form_name : $this->group[$group_id]['name'])));
			redirect($this->form_link);
		}
	}

	/**
	 *        HTML FIELD CREATION FUNCTIONS
	 *
	 *     Below here are all functions used to create the inputs of the form
	 *     there is one for each type of form field supported
	 */

	function _field_text($key)
	{
		$params = $this->field[$key]['params'];
		$params['name'] = $key;
		$params['id'] = $key;
		$params['class'] = 'text';
		$params['value'] = $this->CI->validation->{$key};
		return form_input($params);
	}

	function _field_boolean($key)
	{
		$params = $this->field[$key]['params'];
		$params['name'] = $key;
		$params['id'] = $key;
		$params['value'] = 1;

		// Set checked status
		if ($this->CI->validation->{$key})
		{
			$params['checked'] = TRUE;
		}
		$field = $this->CI->lang->line('general_yes') . " " . form_radio($params);

		// Set checked status
		$params['checked'] = ( ! $this->CI->validation->{$key} ? TRUE : FALSE);

		$params['value'] = 0;
		$field .= " " . $this->CI->lang->line('general_no') . " " . form_radio($params);
		return $field;
	}

	function _field_dropdown($key)
	{
		$options = $this->field[$key]['params']['options'];
		unset($this->field[$key]['params']['options']);
		return form_dropdown($key,$options,$this->CI->validation->{$key},$this->field[$key]['params']);
	}

	function _field_textarea($key)
	{
		$params = $this->field[$key]['params'];
		$params['name'] = $key;
		$params['id'] = $key;
		$params['value'] = $this->CI->validation->{$key};
		return form_textarea($params);
	}
}

/* End of file Preference_form.php */
/* Location: ./modules/preferences/libraries/Preference_form.php */