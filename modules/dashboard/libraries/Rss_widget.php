<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * New Order Widget for BackendPro
 *
 *
 * @author          Shin Okada
 * @copyright       Copyright (c) 2010
 * @license         http://www.gnu.org/licenses/lgpl.html
 * @link            http://www.okadadesign.no
 *
 */

// ---------------------------------------------------------------------------

/**
 * neworder_widget Class
 *
 * This class contains the code to create the statistic widget.
 */
class Rss_widget
{
    function Rss_widget()
    {
        $this->CI =& get_instance();
        // Load the dashboard library
       // $this->CI->load->module_library('dashboard','Analytics');
    }

    function create()
    {

    // Dashboard RSS feed (using SimplePie)
        $this->CI->load->module_library('dashboard','simplepie');
        $this->CI->simplepie->set_cache_location($this->CI->config->item('simplepie_cache_dir'));
        $this->CI->simplepie->set_feed_url($this->CI->preference->item('dashboard_rss'));
        $this->CI->simplepie->init();
        $this->CI->simplepie->handle_content_type();

        // Store the feed items
        $data['rss_items'] = $this->CI->simplepie->get_items(0, $this->CI->preference->item('dashboard_rss_count'));
      //  $data['rss_items'] = $this->CI->simplepie;


     return $this->CI->load->module_view('dashboard',$this->CI->config->item('backendpro_template_admin') . 'dashboard/rssfeed',$data,TRUE);

    }
}

/* End of file Statistic_Widget.php */
/* Location: ./modules/dashboard/libraries/Statistic_Widget.php */