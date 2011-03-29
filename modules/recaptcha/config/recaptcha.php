<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ReCAPTCHA Config Array
 *
 * Contains the ReCAPTCHA config array
 *
 * @package			BackendPro
 * @subpackage		Configurations
 * @author			Adam Price
 * @copyright		Copyright (c) 2008
 * @license			http://www.gnu.org/licenses/lgpl.html
 */

// ---------------------------------------------------------------------------

$config['recaptcha'] = array(
	'public'=>'6LdSQ8ASAAAAAEn5Vhn9p6FLC6IORWFMlBP2kEOw ',
    'private'=>'6LdSQ8ASAAAAABhANrGQeVKVit8xj835dJcH2Pab ',
    'RECAPTCHA_API_SERVER' =>'http://api.recaptcha.net',
    'RECAPTCHA_API_SECURE_SERVER'=>'https://api-secure.recaptcha.net',
    'RECAPTCHA_VERIFY_SERVER' =>'api-verify.recaptcha.net',
    'theme' => 'white'
); 



/* End of file recaptcha.php */
/* Location: ./modules/recaptcha/config/recaptcha.php */