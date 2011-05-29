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
class Analytics_widget
{
    function Analytics_widget()
    {
        $this->CI =& get_instance();
        // Load the dashboard library
       // $this->CI->load->module_library('dashboard','Analytics');
    }

    function create()
    {
    // analytics
    $this->CI->load->module_library('dashboard','Analytics', array(
                                           'username' => $this->CI->preference->item('ga_email'),
                                           'password' => $this->CI->preference->item('ga_password')
                                           
                                    ));

    // Set by GA Profile ID if provided, else try and use the current domain
    $ga_profile = $this->CI->preference->item('ga_profile');
    $this->CI->analytics->setProfileById('ga:'.$ga_profile);

    $end_date = date('Y-m-d');
    $start_date = date('Y-m-d', strtotime('-1 month'));

    $this->CI->analytics->setDateRange($start_date, $end_date);

    $visits = $this->CI->analytics->getVisitors();
    $views = $this->CI->analytics->getPageviews();

    /* build tables */
    if (count($visits))
    {
            foreach ($visits as $date => $visit)
            {
                    $year = substr($date, 0, 4);
                    $month = substr($date, 4, 2);
                    $day = substr($date, 6, 2);

                    $utc = mktime(date('h') + 1, NULL, NULL, $month, $day, $year) * 1000;

                    $flot_datas_visits[] = '[' . $utc . ',' . $visit . ']';
                    $flot_datas_views[] = '[' . $utc . ',' . $views[$date] . ']';
            }

            $flot_data_visits = '[' . implode(',', $flot_datas_visits) . ']';
            $flot_data_views = '[' . implode(',', $flot_datas_views) . ']';
    }

    $data['analytic_visits'] = $flot_data_visits;
    $data['analytic_views'] = $flot_data_views;

     return $this->CI->load->module_view('dashboard',$this->CI->config->item('backendpro_template_admin') . 'dashboard/analytics',$data,TRUE);
     
    }
}

/* End of file Statistic_Widget.php */
/* Location: ./modules/dashboard/libraries/Statistic_Widget.php */