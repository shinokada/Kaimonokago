<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MCalendar extends Model{

	function MCalendar(){
		parent::Model();
	}

	function getEvents($time){
		
		$today = date("Y/n/j", time());
		$current_month = date("n", $time);
		$current_year = date("Y", $time);
		$current_month_text = date("F Y", $time);
		$total_days_of_current_month = date("t", $time);
		
		$events = array();
		
		$query = $this->db->query("
		SELECT DATE_FORMAT(eventDate,'%d') AS day,
		eventContent,eventTitle,id,user,user_id 
		FROM eventcal 
		WHERE eventDate BETWEEN  '$current_year/$current_month/01' 
						AND '$current_year/$current_month/$total_days_of_current_month'");
		
		foreach ($query->result() as $row_event)
		{					
			$events[intval($row_event->day)][] = $row_event;
		}
		$query->free_result();  
		return $events;						
	}
	
function getMyEvents($time, $user_id=0){
		
		$today = date("Y/n/j", time());
		$current_month = date("n", $time);
		$current_year = date("Y", $time);
		$current_month_text = date("F Y", $time);
		$total_days_of_current_month = date("t", $time);
		
		$events = array();
		
		$query = $this->db->query("
		SELECT DATE_FORMAT(eventDate,'%d') AS day,
		eventContent,
		eventTitle,id,user,user_id 
		FROM eventcal 
		WHERE  eventDate BETWEEN  '$current_year/$current_month/01' 
						AND '$current_year/$current_month/$total_days_of_current_month' 
		AND user_id = '$user_id' ");
		foreach ($query->result() as $row_event)
		{					
			$events[intval($row_event->day)][] = $row_event;
		}
		$query->free_result();  
		return $events;						
	}

	function getEventsById($id){
	
	$this->db->where('id', $id);
	$query = $this->db->get('eventcal');
	foreach ($query->result_array() as $event)
		{					
			$data[] = $event;
		}
	$query->free_result();  
	 return $data;						
	}
	
	
	function addEvents(){
		$user_id = id_clean($_POST['user_id']);
      	$user = db_clean($_POST['user']);
		$query = "INSERT INTO eventcal
		(eventDate,eventTitle,eventContent,user, user_id)
		VALUES('".$_POST['date']."','".addslashes($_POST['eventTitle'])."','".
		addslashes($_POST['eventContent'])."', '$user', $user_id)";		
		$result = $this->db->query($query);
		
		//check if the insertion is ok
		if($result)
			$alert = "New Event successfully added";
		else 
			$alert = "Something is wrong. Try Again.";
		
	}
	
	function updateEvent(){
		
		$data = array(
               'eventDate' => db_clean($_POST['date']),
               'eventTitle' => db_clean($_POST['eventTitle']),
               'eventContent' => db_clean($_POST['eventContent'])
            );
		$this->db->where('id', id_clean($_POST['id']));
		$this->db->update('eventcal', $data); 
	}
	
	function deleteEvent($id){
		$this->db->delete('eventcal', array('id' => $id)); 
	}
	
// end of Model/MCalendar.php	
}
