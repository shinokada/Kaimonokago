<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Preferences Language Array
 *
 * Contains all language strings used by the Preference class.
 *
 * @package         BackendPro
 * @subpackage      Languages
 * @author          Adam Price
 * @copyright       Copyright (c) 2008
 * @license         http://www.gnu.org/licenses/lgpl.html
 * @link            http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ---------------------------------------------------------------------------

$lang['preference_saved_successfully'] = "The '%s' preferences have been saved successfully";

/** -------------------------------------- CONTROL PANEL SETTING STRINGS */
// General Configuration
$lang['preference_label_site_name'] = "Name of your site";

// Member Settings
$lang['preference_desc_account_activation_time'] = 'Number of days before a user must have activated their account';
$lang['preference_desc_autologin_period'] = 'Number of days for which the user will be logged in automaticaly';
$lang['preference_desc_login_field'] = 'What way to allow users to login to the system using';

$lang['preference_field_activation_method_none'] = 'No activation required';
$lang['preference_field_activation_method_email'] = 'Self activation by email';
$lang['preference_field_activation_method_admin'] = 'Manual activation by an administrator';

// Security Preferences
$lang['preference_label_use_login_captcha'] = 'Use Login Captcha?';
$lang['preference_label_use_registration_captcha'] = 'Use Registration Captcha?';

// Email Configuration
$lang['preference_label_automated_from_name'] = 'Return name for auto-generated emails';
$lang['preference_label_automated_from_email'] = 'Return email address for auto-generated emails';
$lang['preference_desc_automated_from_email'] = 'If you leave this blank, many email servers will consider your email spam';
$lang['preference_label_email_mailpath'] = 'Sendmail path';
$lang['preference_desc_email_mailpath'] = 'Server path to the Sendmail application';
$lang['preference_label_smtp_host'] = 'SMTP Server';
$lang['preference_desc_smtp_host'] = 'Use this only if you choose SMTP';
$lang['preference_label_smtp_user'] = 'SMTP Username';
$lang['preference_desc_smtp_user'] = 'Use this only if you choose SMTP';
$lang['preference_label_smtp_pass'] = 'SMTP Password';
$lang['preference_desc_smtp_pass'] = 'Use this only if you choose SMTP';
$lang['preference_label_smtp_port'] = 'SMTP Port';
$lang['preference_label_smtp_timeout'] = 'SMTP Timeout';
$lang['preference_desc_smtp_timeout'] = 'Number in seconds';
$lang['preference_label_email_mailtype'] = 'Default Email Format';
$lang['preference_label_email_charset'] = 'Email Character Encoding';
$lang['preference_label_email_wordwrap'] = 'Enable Wordwrap?';
$lang['preference_label_email_wrapchars'] = 'Character count to wrap at';
$lang['preference_desc_email_wrapchars'] = 'Number of characters to wrap at';
$lang['preference_label_bcc_batch_mode'] = 'BCC Batch Mode?';
$lang['preference_desc_bcc_batch_mode'] = 'Batch Mode breaks up large mailings into smaller groups, which get sent at intervals. Recommended if your site is hosted on a shared-hosting account.';
$lang['preference_label_bcc_batch_size'] = 'Number of Emails Per Batch';
$lang['preference_desc_bcc_batch_size'] = 'For average servers, 200 is a safe number';

// Maintenance & Debuging Settings
$lang['preference_label_page_debug'] = 'Enable System Debugging?';
$lang['preference_desc_page_debug'] = 'Show important infomation about code execution';
$lang['preference_label_keep_error_logs_for'] = 'Archive Error Logs?';
$lang['preference_desc_keep_error_logs_for'] = 'Number of days to archive error logs for';


/**
 *     BELOW HERE DEFINE ANY LANGUAGE STRINGS FOR YOUR APPLICATIONS
 *
 *     Format:
 *     For a preference label name:
 *     $lang['preference_label_{preference_name}'] = '';
 *
 *     For a preference description:
 *     $lang['preference_desc_{preference_desc}'] = '';
 */

/* End of file preferences_lang.php */
/* Location: ./modules/preferences/language/english/preferences_lang.php */