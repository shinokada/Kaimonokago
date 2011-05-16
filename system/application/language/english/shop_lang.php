<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Shop Language Array
 *
 * This file contains the language strings for Kaimono Kago webshop.
 * This file is included by default with the Shop_Admin_Controller library.
 *
 * Any language string you need for shop backend or front end
 * should be placed in here. IE controller names for menus etc
 *
 * @package         Kaimono Kago
 * @subpackage		Languages
 * @author          Shin Okada
 * @copyright       Copyright (c) 2010
 * @license         GNU General Public License version 3.0 (GPLv3)
 * @link            http://www.okadadesign.no/kaimonokago
 * @filesource
 */

// ---------------------------------------------------------------------------


/* CI Shoping cart */
$lang['general_login'] = 'Log in';
$lang['general_logout'] = 'Log out';
$lang['general_not_logged_in'] = 'You are not logged in';
$lang['general_cart'] = 'Cart';
$lang['general_shopping_cart'] ='Shopping Cart';
$lang['general_search_results'] ='Search Results';
$lang['general_name'] = "Name";
$lang['general_pass_word'] = "Password";
$lang['general_register'] = "Register";
$lang['genral_login_msg'] = "Or click <span class='login'>%s</span> if you are already registered.";
$lang['genral_logged_in'] = "You are logged in";
$lang['general_hello'] = "Hello ";
$lang['general_web_shop'] = 'Web shop';
$lang['general_check_out'] = 'Go to check out';


/* All Main Controller Names and menu items */
$lang['backendpro_general'] = 'General';
$lang['backendpro_admins'] = 'Admins';
$lang['backendpro_calendar'] = 'Calendar';
$lang['backendpro_category'] = 'Category';
$lang['backendpro_slideshow'] = 'Slideshow';
$lang['backendpro_customers'] = 'Customers';
$lang['backendpro_menus'] = 'Menus';
$lang['backendpro_messages'] = 'Messages';
$lang['backendpro_orders'] = 'Orders';
$lang['backendpro_pages'] = 'Pages';
$lang['backendpro_products'] = 'Products';
$lang['backendpro_subscribers'] = 'Subscribers';
$lang['backendpro_file_manager'] = 'File Manager';
$lang['backendpro_langages'] = 'Languages';


/* For Webshop */
$lang['preference_website_configuration'] = "Website Configuration";

/* For slideshows */
$lang['preference_frontpage_slideshow_settings'] = "Slideshow Settings";


/**
 * Transferred from modules\auth\language\english\userlib_lang.php
 * 
 * 
 */

/* Calendar */
$lang['userlib_calendar'] = 'Calendar';
$lang['userlib_calendar_add'] = 'Add event';
$lang['userlib_calendar_edit'] = 'Edit event';
$lang['userlib_calendar_personal'] = 'Personal calendar';

/* Subscribers messages */
$lang['userlib_all_fields_required'] = 'All fields are required . Please try again!';
$lang['userlib_sub_added'] = 'New subscriber is added!';

/* Categories module */
$lang['userlib_category_created'] = 'Category created';
$lang['userlib_create'] = 'Create';
$lang['userlib_category_updated'] = 'Category updated';
$lang['userlib_category_deleted'] = 'Category deleted';
$lang['userlib_category_reassigned'] = 'Category deleted and products reassigned';
$lang['userlib_category_status'] = 'Category status changed';


/* Slideshow options */
$lang['userlib_nivo_slider'] = 'NIVO SLIDER';
$lang['userlib_coin_slider'] = 'COIN SLIDER';
$lang['userlib_interfade'] = 'INTERFADE';
$lang['userlib_cu3er'] = 'CU3ER';
$lang['userlib_none'] = 'None';

/**
 * Transferred from modules/preferences/language/english/preferences_lang.php 
 * 
 */

// for Webshop label and description
$lang['preference_label_main_module_name'] = 'Name of main module in your website';
$lang['preference_desc_main_module_name'] = 'Enter the path name of index page. Such as welcome, webshop etc.';
$lang['preference_label_multi_language'] = 'Multiple Languages';
$lang['preference_desc_multi_language'] = 'Is your website multi-language?';
$lang['preference_label_website_language'] = 'Website Languages';
$lang['preference_desc_website_language'] = 'The defaulte language is english. Write a language name which you added in Languages module.';
$lang['preference_label_categories_parent_id'] = 'Category ID for website';
$lang['preference_desc_categories_parent_id'] = 'Enter an ID for your website on the left column. Find it in the Categories';
$lang['preference_label_playroom_parent_id'] = 'Playroom Parent ID';
$lang['preference_desc_playroom_parent_id'] = 'Enter an ID for the playroom module. Find it in the Playroom';
$lang['preference_label_admin_email'] = 'Admin Email to receive email messages';
$lang['preference_desc_admin_email'] = 'Enter admin email address to receive email messages from customers';


// for Slideshow Settings label and description
$lang['preference_label_webshop_slideshow'] = 'Slideshow type for webshop front page';
$lang['preference_desc_webshop_slideshow'] = 'Select a slideshow type for webshop front page';
$lang['preference_label_slideshow_two'] = 'Slideshow type for other page';
$lang['preference_desc_slideshow_two'] = 'Select a slideshow type for other pages';

// modulemanagement
$lang['preference_label_calendar'] = 'Calendar';
$lang['preference_desc_calendar'] = 'Do you want display in the side menu?';


/* End of file shop_lang.php */
/* Location: ./system/application/language/english/shop_lang.php */