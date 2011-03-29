<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Userlib Helper
 *
 * Contains shortcuts to well used Userlib functions
 *
 * @package         BackendPro
 * @subpackage		Helpers
 * @author          Adam Price
 * @copyright       Copyright (c) 2008
 * @license         http://www.gnu.org/licenses/lgpl.html
 * @link            http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ---------------------------------------------------------------------------

if( ! function_exists('check'))
{
	function check($resource,$action=NULL,$redirect=TRUE)
	{
		$CI = & get_instance();
		return $CI->userlib->check($resource,$action,$redirect);
	}
}

if( ! function_exists('is_user'))
{
	function is_user()
	{
		$CI = & get_instance();
		return $CI->userlib->is_user();
	}
}
/* End of file userlib_helper.php */
/* Location: ./modules/helpers/userlib_helper.php */