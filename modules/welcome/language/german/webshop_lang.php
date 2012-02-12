<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Webshop Language Array
 * German
 * Contains all language strings used by the webshop class.
 *
 * @subpackage		Languages
 * @author          Shin Okada
 * @copyright       Copyright (c) 2010
 * @license         http://www.gnu.org/licenses/lgpl.html
 * @link            http://www.okadadesign.no
 * @filesource
 */

// ---------------------------------------------------------------------------

/* Webshop field names */

// Change this according to your module folder name. 
$lang['webshop_shop_name'] = 'CI shop';
$lang['webshop_folder'] = 'webshop';
$lang['webshop_buy'] = 'Kaufen';


// modules/webshop/views/customerlogin.php
$lang['customer_login_enjoy_shopping'] = 'Viel Spaß beim Shoppen!';
$lang['customer_login_plz_login'] = 'Bitte loggen Sie sich. Dieser füllt sich Ihre Daten beim Check-out automatisch.';


// modules/webshop/views/shoppingcart.php
$lang['webshop_update'] = 'Update';
$lang['webshop_delete'] = 'Löschen';
$lang['webshop_checkout'] = 'Zur Kasse';
$lang['webshop_no_items_to_show'] = 'Kein artikel zu zeigen';
$lang['webshop_will_be_added'] = 'werden aufgenommen';
$lang['webshop_shipping_charge'] = 'Versand kostenlos';
$lang['webshop_currency'] = 'euro';
$lang['webshop_currency_symbol'] = '€'; // &#36;
$lang['webshop_shoppingcart_empty'] = 'Der warenkorb ist leer';
$lang['webshop_search'] = 'Suche';
$lang['webshop_click_here'] = 'Klicken sie hier';
$lang['webshop_if_registered'] = 'Sie sind bereits registriert.';


// modules/webshop/views/registration.php
$lang['webshop_email'] = 'E-Mail';
$lang['webshop_email_confirm'] = 'E-Mail Bestätigung';
$lang['webshop_pass_word'] = 'Passwort';
$lang['webshop_first_name'] = 'Vorname';
$lang['webshop_last_name'] = 'Nachname';
$lang['webshop_mobile_tel'] = 'Mobile/Telephone';
$lang['webshop_shipping_address'] = 'Shipping Address';
$lang['webshop_post_code'] = 'Postal Code';
$lang['webshop_city'] = 'City';
$lang['webshop_register'] = 'Register';
$lang['webshop_regist_plz_here'] = 'Please register here. ';
$lang['webshop_price'] = 'Preis';
$lang['webshop_registed_before'] = 'Your email is in our database. Please login.';
$lang['webshop_thank_registration'] = 'Thank you for your registration! You may log in now.';
$lang['webshop_name'] = "Name";


// modules/webshop/controllers/webshop.php for function messages
$lang['webshop_message_contact_us'] = 'Contact us';
$lang['webshop_message_contact'] = 'Contact';
$lang['webshop_message_subject'] = 'Email message from %s.';
$lang['webshop_message_sender'] = 'Sender ';
$lang['webshop_message_sender_email'] = 'Sender email ';
$lang['webshop_message_message'] = 'Message ';
$lang['webshop_message_thank_for_message'] = 'Thanks for your message! You have sent email.';
$lang['message_message'] = 'Message ';
$lang['general_login_msg'] = "Or click <span class='login'>%s</span> if you are already registered.";
$lang['general_logged_in'] = "You are logged in";
$lang['general_hello'] = "Hello ";
$lang['general_web_shop'] = 'Web shop';
$lang['general_check_out'] = 'Go to check out';


/* Strings used on general page */
$lang['general_login'] = 'Login';
$lang['general_logout'] = 'Log out';
$lang['general_not_logged_in'] = 'Sie sind nicht eingeloggt';
$lang['general_cart'] = 'Cart';
$lang['general_shopping_cart'] ='Warenkorb';
$lang['general_search_results'] ='Search Results';
$lang['general_pass_word'] = "Password";
$lang['general_register'] = "Register";


/* orders */
$lang['orders_added_cart'] = "We have added this product to the shopping cart.";
$lang['orders_product_removed'] = "Product removed.";
$lang['orders_not_in_cart'] = "Product not in shopping cart!";
$lang['orders_no_records'] = "No records";
$lang['orders_record'] = "record";
$lang['orders_records'] = "records";
$lang['orders_updated'] = "updated";
$lang['orders_no_changes_detected'] = "No changes detected";
$lang['orders_nothing_to_update'] = "Nothing to update";
$lang['orders_nothing_in_cart'] = "Nothing in cart!";
$lang['orders_no_item_yet'] = "You have no item yet!";
$lang['orders_total_price'] = "Total Price";


/* view/confirmorder.php*/
$lang['orders_plz_confirm'] = "Bitte bestätigen Sie Ihre Bestellung und füllen Sie Ihre Details";
$lang['orders_confirm_before'] = "Bitte bestätigen Sie Ihre Bestellung, bevor Sie auf die E-Mail Ihre Bestellung jetzt Button unten. Vis du har Änderungen, ";
$lang['orders_go_to_cart'] = "gehen Sie zurück zu Ihrem Warenkorb";
$lang['orders_sub_total_nor'] = "SUB-TOTAL :NOR ";
$lang['orders_shipping_nor'] = "Shipping: NOR ";
$lang['orders_total_with_shipping'] = "TOTAL (with shipping):NOR ";
$lang['orders_email'] = "Email";
$lang['orders_email_confirm'] = "Email Confirm";
$lang['orders_shipping_address'] = "Shipping Address";
$lang['orders_post_code'] = "Post number";
$lang['orders_city'] = "City";
$lang['orders_email_order'] = "Email Order";


/*ordersuccess.php */
$lang['orders_thank_you'] = "Thank you for your order! We will get in touch as soon as possible. Please check your email. We have sent confirmation email.";
 
 
/* controllers/webshop/emailorder*/
$lang['email_here_is'] = "Here is the details of order submitted to www.webshop.com";
$lang['email_number_of_order'] = "Nummer of bestilling";
$lang['email_product_name'] = "Product navn";
$lang['email_product_price'] = "product pris";
$lang['email_we_will_call'] = "Thank you for your order. We will call you as soon as possible.";
$lang['email_order_conf'] = "Order confirmation";


/* views/contact.php */
$lang['contact_your_message']="Ihre nachricht";
$lang['contact_captcha']= "Geben Sie die beiden Wörter bitte";
$lang['contact_send']= "Senden";
$lang['contact_if_you_human'] = "Wenn Sie ein Mensch sind, geben Sie bitte sechs Buchstaben oder nummers. Bitte versuchen Sie es erneut!";
$lang['contact_all_field_required'] = "Alle Felder sind Pflichtfelder. Bitte versuchen Sie es ingen!";


// modules/webshop/controllers/subscribe function
$lang['subscribe_newsletter'] = 'Newsletter';
$lang['subscribe_subscribe'] = 'Abonnieren';
$lang['subscribe_unsubscribe'] = 'Abmelden';
$lang['subscribe_registed_before'] = 'Your email is already in our list.';
$lang['subscribe_thank_for_subscription'] = 'Thanks for subscribing our newsletter!';
$lang['subscribe_you_been_subscribed'] = 'You have been unsubscribed!';
$lang['subscribe_need_login'] = 'You need to login first';
$lang['subscribe_you_been_unsubscribed'] = 'You have been unsubscribed from Newsletter';


// modules/webshop/controllers/login function
$lang['login_logged_in'] = 'You are logged in!';
$lang['login_email_pw_incorrect'] = 'Sorry, your email or password is incorrect!';
$lang['webshop_mostsold'] = 'Most Sold';
$lang['webshop_newproduct'] = 'New Product';

// security
$lang['webshop_write_ans'] = "Type the answer.";
$lang['webshop_security_question'] = "Security question.";
$lang['webshop_security_wrong'] = "Your answer is wrong.";

/* End of file webshop_lang.php */
/* Location: ./modules/webshop/language/english/webshop_lang.php */