<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Shop_Admin_Controller {

    private $module;

  function Admin(){
    parent::Shop_Admin_Controller();
    $this->load->model('MCalendar');
    $this->bep_assets->load_asset('master');
    // Check for access permission. Only if you have permission, you can access to Calendar
	check('Calendar');
	// We are going to use form helper. So load it.
        $this->module=basename(dirname(dirname(__FILE__)));
	$this->load->helper('form');
	// Set breadcrumb for the top level
	$this->bep_site->set_crumb($this->lang->line('backendpro_calendar'),'calendar/admin');	
  }
  
  
    function index(){
        // The forth segment will be used as timeid
        $timeid = $this->uri->segment(4);
        if($timeid==0)
                $time = time();
        else
                $time = $timeid;

        // we call _date function
        $data = $this->_date($time);

        // Set all other variables here
        $data['title'] = "Manage Calendar";
        // Calling this will display links to everyone's calendar. If you don't use it delete it in the view
        $data['members'] = $this->user_model->getUsers();
        // You can use this variable to tell that this is your calendar at the top.
        $data['user'] = $this->session->userdata('username');
        $data['user_id'] = $this->session->userdata('id');
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_calendar_home";
        // we are using calendar module
        $data['module'] = $this->module;
        $this->load->view($this->_container,$data);
    }
  

  
    function create(){
	
	$data['title'] = "Add Events to Calendar";
	$data['user'] = $this->session->userdata('username');
	$data['user_id'] = $this->session->userdata('id');
	if(isset($_POST['submit']))
	{
            //check for empty inputs
            if((isset($_POST['date']) && !empty($_POST['date'])) && (isset($_POST['eventTitle']) && !empty($_POST['eventTitle'])) && (isset($_POST['eventContent']) && !empty($_POST['eventContent'])))
            {
                //add new event to the database
                $this->MCalendar->addEvents();
                flashMsg('success','Calendar created');
                redirect('calendar/admin/index','refresh');
            }
            else
            {
                //alert message for empty input
                $data['alert'] = "No empty input please";
            }
	}
        // Set breadcrumb for the second level after Calendar. It will show like Calendar
        // You have to add in language userlib
        $this->bep_site->set_crumb($this->lang->line('userlib_calendar_add'),'calendar/admin/create');

        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_calendar_create";
        $data['cancel_link']= $this->module."/admin/index/";
        $data['module'] = $this->module;
        $this->load->view($this->_container,$data);
        }
		
		
     function edit($id=0){
		
	  $data['title'] = "Edit Events";
	
	  if(isset($_POST['submit']))
	  {
              //check for empty inputs
              if((isset($_POST['date']) && !empty($_POST['date'])) && (isset($_POST['eventTitle']) && !empty($_POST['eventTitle'])) && (isset($_POST['eventContent']) && !empty($_POST['eventContent'])))
              {
                      //add new event to the database
                      $this->MCalendar->updateEvent();
                      //$this->session->set_flashdata('message','Event created!');
                      flashMsg('success','Event updated');
                      redirect('calendar/admin/index','refresh');
              }
              else
              {
                      //alert message for empty input
                      $data['alert'] = "No empty input please";
              }
	  }
		
	  $data['event']= $this->MCalendar->getEventsById($id);
	
		// Set breadcrumb
		$this->bep_site->set_crumb($this->lang->line('userlib_calendar_edit'),'calendar/admin/edit');	
		$data['header'] = $this->lang->line('backendpro_access_control');
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_calendar_edit";
                $data['cancel_link']= $this->module."/admin/index/";
		$data['module'] = $this->module;
		$this->load->view($this->_container,$data);
	}

        /*
         * not used since same as edit()
	function update($id=0){
	
		if(isset($_POST['add']))
		{
			//check for empty inputs
			if((isset($_POST['date']) && !empty($_POST['date'])) && (isset($_POST['eventTitle']) && !empty($_POST['eventTitle'])) && (isset($_POST['eventContent']) && !empty($_POST['eventContent'])))	
			{
				//update event to the database
				$this->MCalendar->updateEvent();
				$this->session->set_flashdata('message', 'Event updated!');
				redirect('calendar/admin/');
			}
			else 
			{
				//alert message for empty input
				$data['alert'] = "No empty input please";
			}
		}
		$this->session->set_flashdata('message', 'Please fill up the information');
		redirect('calendar/admin/update');
		
	}

         * 
         */
	function delete($id=0){
		$this->MCalendar->deleteEvent($id);
		$this->session->set_flashdata('message', 'Event deleted successfully.');
                flashMsg('success','Event deleted successfully.');
		redirect('calendar/admin/index');
	}
	
	function mycal($user_id=0){
		
		$timeid = $this->uri->segment(5);
		if($timeid==0)
			$time = time();
		else
			$time = $timeid;
			
		// we call _date function 	
		$data = $this->_date($time, $user_id);
		
		// get members from backendpro
		$data['members'] = $this->user_model->getUsers();
		$user_id = $this->uri->segment(4);
		$data['user_id']=$user_id;
		
		// Get user's name/details
		$this->load->module_model('auth','user_model');
		$user = $this->user_model->getUsers(array('users.id'=>$user_id));
		$data['user'] = $user->row_array();
		
		
		// Set breadcrumb
		$this->bep_site->set_crumb($this->lang->line('userlib_calendar_personal','calendar/admin/mycal/$user_id'));	
		$data['title'] = "Manage Calendar";
		
		$data['header'] = $this->lang->line('backendpro_access_control');
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_calendar_mycal";
                $data['cancel_link']= $this->module."/admin/index/";
		$data['module'] = $this->module;
		$this->load->view($this->_container,$data);
  	}
 
 function _date($time, $user_id=0){
 	if($user_id<1){
 		$data['events']=$this->MCalendar->getEvents($time);
 	}else{
 		$data['events']=$this->MCalendar->getMyEvents($time, $user_id);
 	}
	

	$today = date("Y/n/j", time());
	$data['today']= $today;
	
	$current_month = date("n", $time);
	$data['current_month'] = $current_month;
	
	$current_year = date("Y", $time);
	$data['current_year'] = $current_year;
	
	$current_month_text = date("F Y", $time);
	$data['current_month_text'] = $current_month_text;
	
	$total_days_of_current_month = date("t", $time);
	$data['total_days_of_current_month']= $total_days_of_current_month;
	
	$first_day_of_month = mktime(0,0,0,$current_month,1,$current_year);
	$data['first_day_of_month'] = $first_day_of_month;
	
	//geting Numeric representation of the day of the week for first day of the month. 0 (for Sunday) through 6 (for Saturday).
	$first_w_of_month = date("w", $first_day_of_month);
	$data['first_w_of_month'] = $first_w_of_month;
	
	//how many rows will be in the calendar to show the dates
	$total_rows = ceil(($total_days_of_current_month + $first_w_of_month)/7);
	$data['total_rows']= $total_rows;
	
	//trick to show empty cell in the first row if the month doesn't start from Sunday
	$day = -$first_w_of_month;
	$data['day']= $day;
	
	$next_month = mktime(0,0,0,$current_month+1,1,$current_year);
	$data['next_month']= $next_month;
	
	$next_month_text = date("F \'y", $next_month);
	$data['next_month_text']= $next_month_text;
	
	$previous_month = mktime(0,0,0,$current_month-1,1,$current_year);
	$data['previous_month']= $previous_month;
	
	$previous_month_text = date("F \'y", $previous_month);
	$data['previous_month_text']= $previous_month_text;
	
	$next_year = mktime(0,0,0,$current_month,1,$current_year+1);
	$data['next_year']= $next_year;
	
	$next_year_text = date("F \'y", $next_year);
	$data['next_year_text']= $next_year_text;
	
	$previous_year = mktime(0,0,0,$current_month,1,$current_year-1);
	$data['previous_year']=$previous_year;
	
	$previous_year_text = date("F \'y", $previous_year);
	$data['previous_year_text']= $previous_year_text;
	
	return $data;
  
 }
}//end class
?>