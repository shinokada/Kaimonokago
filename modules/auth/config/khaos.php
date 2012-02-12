<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Khaos :: KhACL
 *
 * @package 	Khaos
 * @subpackage  Khacl
 * @author      David Cole <neophyte@sourcetutor.com>
 * @version     0.1-alpha5
 * @copyright   2008
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * ACL Config Array
 *
 * Contains any settings for the KhACL library
 *
 * @package		BackendPro
 * @subpackage 	Configurations
 * @author 		Adam Price
 */
$config['acl']['tables'] = array(
        'aros'           => 'be_acl_groups',
        'acos'           => 'be_acl_resources',
        'axos'           => 'be_acl_actions',
        'access'         => 'be_acl_permissions',
        'access_actions' => 'be_acl_permission_actions'
        );

/* End of file khaos.php */
/* Location: ./modules/auth/config/khaos.php */