<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Webshop Language Array
 * Norwegian
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
$lang['webshop_buy'] = 'Kjøp';


// modules/webshop/views/customerlogin.php
$lang['customer_login_enjoy_shopping'] = 'Nyt shopping!';
$lang['customer_login_plz_login'] = 'Vennligst logg inn. Dette vil fylle opp dine detaljer ved utsjekking automatisk.';


// modules/webshop/views/shoppingcart.php
$lang['webshop_update'] = 'Update';
$lang['webshop_delete'] = 'DELETE';
$lang['webshop_checkout'] = 'Gå til kassen';
$lang['webshop_no_items_to_show'] = 'Ingen element for å vise';
$lang['webshop_will_be_added'] = 'vil bli lagt';
$lang['webshop_shipping_charge'] = 'Frakt kostnader';
$lang['webshop_currency'] = 'kroner';
$lang['webshop_currency_symbol'] = 'Kr'; // &#36;
$lang['webshop_shoppingcart_empty'] = 'Handlekurven er tom';
$lang['webshop_search'] = 'søk';
$lang['webshop_click_here'] = 'Klikk her';
 $lang['webshop_if_registered'] = 'hvis du allerede er registrert.';


// modules/webshop/views/registration.php
$lang['webshop_email'] = 'E-post';
$lang['webshop_email_confirm'] = 'E-post Bekreftelse';
$lang['webshop_pass_word'] = 'Passord';
$lang['webshop_first_name'] = 'Første navn';
$lang['webshop_last_name'] = 'Siste Navn';
$lang['webshop_mobile_tel'] = 'Mobil/Telefon';
$lang['webshop_shipping_address'] = 'Leveringsadresse';
$lang['webshop_post_code'] = 'Postal Code';
$lang['webshop_city'] = 'Byen';
$lang['webshop_register'] = 'Register';
$lang['webshop_regist_plz_here'] = 'Vennligst registrer deg her. ';
$lang['webshop_price'] = 'Pris';
$lang['webshop_registed_before'] = 'Din e-post er i vår database. Vennligst logg inn.';
$lang['webshop_thank_registration'] = 'Takk for din registrering! Du kan logge inn nå.';
$lang['webshop_name'] = "Navn";


// modules/webshop/controllers/webshop.php for function messages
$lang['webshop_message_contact_us'] = 'Kontakt oss';
$lang['webshop_message_contact'] = 'Kontakt';
$lang['webshop_message_subject'] = 'E-postmelding from %s.';
$lang['webshop_message_sender'] = 'Sender ';
$lang['webshop_message_sender_email'] = 'Sender e-post ';
$lang['webshop_message_message'] = 'Melding ';
$lang['webshop_message_thank_for_message'] = 'Takk for meldingen din! Du har sendt e-post.';
$lang['message_message'] = 'Melding ';
$lang['general_login_msg'] = "Eller klikk <span class='login'>%s</span> hvis du allerede er registrert.";
$lang['general_logged_in'] = "Du er logget inn";
$lang['general_hello'] = "Hallo ";
$lang['general_web_shop'] = 'Nettbutikk';
$lang['general_check_out'] = 'Gå å sjekke ut';


/* Strings used on general page */
$lang['general_login'] = 'Logg inn';
$lang['general_logout'] = 'Logg ut';
$lang['general_not_logged_in'] = 'Du er ikke logget inn.';
$lang['general_cart'] = 'Cart';
$lang['general_shopping_cart'] ='Handlekurv';
$lang['general_search_results'] ='Søkeresultater';
$lang['general_pass_word'] = "Passord";
$lang['general_register'] = "Register";


/* orders */
$lang['orders_added_cart'] = "Vi har lagt dette produktet til handlekurven.";
$lang['orders_product_removed'] = "Produkt fjernet.";
$lang['orders_not_in_cart'] = "Produkt ikke i handlekurven!";
$lang['orders_no_records'] = "Ingen poster";
$lang['orders_record'] = "posten";
$lang['orders_records'] = "poster";
$lang['orders_updated'] = "updated";
$lang['orders_no_changes_detected'] = "Ingen endringer funnet";
$lang['orders_nothing_to_update'] = "Ingenting å oppdatere";
$lang['orders_nothing_in_cart'] = "Ingenting i handlevognen!";
$lang['orders_no_item_yet'] = "Du har ingen element ennå!";
$lang['orders_total_price'] = "Total pris";


/* view/confirmorder.php*/
$lang['orders_plz_confirm'] = "Vennligst bekreft din Order og fylle opp detaljer";
$lang['orders_confirm_before'] = "Vennligst bekreft din bestilling før du klikker på e-post Bestill ditt nå knappen nedenfor. Vis du Har endringer, ";
$lang['orders_go_to_cart'] = "gå tilbake til handlekurven";
$lang['orders_sub_total'] = "SUB-TOTAL : ";
$lang['orders_shipping'] = "Shipping: ";
$lang['orders_total_with_shipping'] = "TOTAL (with shipping): ";
$lang['orders_email'] = "Email";
$lang['orders_email_confirm'] = "E-post Bekreft";
$lang['orders_shipping_address'] = "Leveringsadresse";
$lang['orders_post_code'] = "Post nummer";
$lang['orders_city'] = "Byen";
$lang['orders_email_order'] = "Send e-post Bestill";


/*ordersuccess.php */
$lang['orders_thank_you'] = "Thank you for your order! We will get in touch as soon as possible. Please check your email. We have sent confirmation email.";
 
 
/* controllers/webshop/emailorder*/
$lang['email_here_is'] = "Here is the details of order submitted to www.webshop.com";
$lang['email_number_of_order'] = "Nummer of bestilling";
$lang['email_product_name'] = "Product navn";
$lang['email_product_price'] = "product pris";
$lang['email_we_will_call'] = "Thank you for your order. We will call you as soon as possible.";
$lang['email_order_conf'] = "Ordrebekreftelse";


/* views/contact.php */
$lang['contact_your_message']="Din melding";
$lang['contact_captcha']= "Skriv inn to ord.";
$lang['contact_send']= "Send";
$lang['contact_if_you_human'] = "Hvis du er menneskelig, legg inn seks bokstaver eller nummers. Vennligst prøv igjen!";
$lang['contact_all_field_required'] = "Alle feltene er påkrevd. Prøv ingen!";


// modules/webshop/controllers/subscribe function
$lang['subscribe_newsletter'] = 'Nyhetsbrev';
$lang['subscribe_subscribe'] = 'Abonner';
$lang['subscribe_unsubscribe'] = 'Avslutt abonnement';
$lang['subscribe_registed_before'] = 'Your email is already in our list.';
$lang['subscribe_thank_for_subscription'] = 'Thanks for subscribing our newsletter!';
$lang['subscribe_you_been_subscribed'] = 'You have been unsubscribed!';
$lang['subscribe_need_login'] = 'You need to login first';
$lang['subscribe_you_been_unsubscribed'] = 'You have been unsubscribed from Newsletter';


// modules/webshop/controllers/login function
$lang['login_logged_in'] = 'You are logged in!';
$lang['login_email_pw_incorrect'] = 'Sorry, your email or password is incorrect!';
$lang['webshop_mostsold'] = 'Mest Solgte';
$lang['webshop_newproduct'] = 'Nytt produkt';

// security
$lang['webshop_write_ans'] = "Type the answer.";
$lang['webshop_security_question'] = "Security question.";
$lang['webshop_security_wrong'] = "Your answer is wrong.";

/* End of file webshop_lang.php */
/* Location: ./modules/webshop/language/english/webshop_lang.php */