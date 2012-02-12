<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
* This is a PHP library that handles calling reCAPTCHA.
*    - Documentation and latest version
*          http://recaptcha.net/plugins/php/
*    - Get a reCAPTCHA API Key
*          http://recaptcha.net/api/getkey
*    - Discussion group
*          http://groups.google.com/group/recaptcha
*
* Copyright (c) 2007 reCAPTCHA -- http://recaptcha.net
* AUTHORS:
*   Mike Crawford
*   Ben Maurer
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*/

/**
* Recaptcha modified to integrate easily with Code Igniter
*
* @package     CodeIgniter
* @subpackage  Libraries
* @category    Captcha
* @author      Jon Trelfa <jtrelfa@gmail.com>
* @link        none yet
*/
class Recaptcha {
  
  //private
  var $_rConfig;
  var $_ci;
  
  //public
  var $is_valid;
  var $error;
  
  //set the default URLs for using Recaptcha
  function __construct() {
    log_message('debug', 'Recaptcha class Initialized');
    $this->_ci =& get_instance();
    $this->_ci->config->load('recaptcha');
    $this->_rConfig = $this->_ci->config->item('recaptcha');
    $this->is_valid = false;
    $this->error = '';
  }
    
    /**
   * Encodes the given data into a query string format
   * @param $data - array of string elements to be encoded
   * @return string - encoded request
   */
  function _recaptcha_qsencode($data) {
    return http_build_query($data);
  }

  /**
   * Submits an HTTP POST to a reCAPTCHA server
   * @param string $host
   * @param string $path
   * @param array $data
   * @param int port
   * @return array response
   */
  function _recaptcha_http_post($host, $path, $data, $port = 80) {
    
    $req = $this->_recaptcha_qsencode($data);
    $http_request = implode('',array(
      "POST $path HTTP/1.0\r\n",
      "Host: $host\r\n",
      "Content-Type: application/x-www-form-urlencoded;\r\n",
      "Content-Length:".strlen($req)."\r\n",
      "User-Agent: reCAPTCHA/PHP\r\n",
      "\r\n",
      $req));
    $response = '';
    if( false == ( $fs = @fsockopen($host, $port, $errno, $errstr, 10) ) ) {
      show_error('Could not open socket');
    }
    
    fwrite($fs, $http_request);
    while (!feof($fs)) {
      $response .= fgets($fs, 1160); // One TCP-IP packet
    }
    fclose($fs);
    $response = explode("\r\n\r\n", $response, 2);
    
    return $response;
  }

  /**
   * Gets the challenge HTML (javascript and non-javascript version).
   * This is called from the browser, and the resulting reCAPTCHA HTML widget
   * is embedded within the HTML form it was called from.
   * @param string $pubkey A public key for reCAPTCHA
   * @param string $error The error given by reCAPTCHA (optional, default is null)
   * @param boolean $use_ssl Should the request be made over ssl? (optional, default is false)
  
   * @return string - The HTML to be embedded in the user's form.
   */
  function recaptcha_get_html ($error = null, $use_ssl = false) {
      if ($this->_rConfig['public'] == '') {
      show_error("To use reCAPTCHA you must get an API key from <a href='http://recaptcha.net/api/getkey'>http://recaptcha.net/api/getkey</a>");
      }
      
      if ($use_ssl) {
        $server = $this->_rConfig['RECAPTCHA_API_SECURE_SERVER'];
      } else {
        $server = $this->_rConfig['RECAPTCHA_API_SERVER'];
      }

    $errorpart = "";
    if ($error) {
       $errorpart = "&amp;error=" . $error;
    }
    $data = array(
      'server'=>$server,
      'key'=>$this->_rConfig['public'],
      'theme'=>$this->_rConfig['theme'],
      'errorpart'=>$errorpart
    );
    return $this->_ci->load->view('recaptcha',$data,true);
  }

  /**
   * gets a URL where the user can sign up for reCAPTCHA. If your application
   * has a configuration page where you enter a key, you should provide a link
   * using this function.
   * @param string $domain The domain where the page is hosted
   * @param string $appname The name of your application
   */
  function recaptcha_get_signup_url ($domain = null, $appname = null) {
      return "http://recaptcha.net/api/getkey?".$this->_recaptcha_qsencode(array ('domain' => $domain, 'app' => $appname));
  }

  /**
    * Calls an HTTP POST function to verify if the user's guess was correct
    * @param string $privkey
    * @param string $remoteip
    * @param string $challenge
    * @param string $response
    * @param array $extra_params an array of extra variables to post to the server
    * @return ReCaptchaResponse
    */
  function recaptcha_check_answer ($remoteip, $challenge, $response, $extra_params = array()) {
      if ($this->_rConfig['private'] == '') {
          die ("To use reCAPTCHA you must get an API key from <a href='http://recaptcha.net/api/getkey'>http://recaptcha.net/api/getkey</a>");
      }
  
      if ($remoteip == null || $remoteip == '') {
          show_error("For security reasons, you must pass the remote ip to reCAPTCHA");
      }

    //discard spam submissions
    if ($challenge == null || strlen($challenge) == 0 || $response == null || strlen($response) == 0) {
      $this->is_valid = false;
      $this->error = 'incorrect-captcha-sol';
      return;
    }

    $response = $this->_recaptcha_http_post(
      $this->_rConfig['RECAPTCHA_VERIFY_SERVER'],
      "/verify",
      array (
        'privatekey' => $this->_rConfig['private'],
        'remoteip' => $remoteip,
        'challenge' => $challenge,
        'response' => $response
      ) + $extra_params
    );
    //show_error($response);

    $answers = explode ("\n", $response [1]);

    if (trim ($answers [0]) == 'true') {
      $this->is_valid = true;
    } else {
      $this->is_valid = false;
      $this->error = $answers [1];
    }
    return;
  }

}
?>