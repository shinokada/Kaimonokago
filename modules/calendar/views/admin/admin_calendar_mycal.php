<link rel="stylesheet" href="<?php echo base_url();?>css/datepick/master.css" type="text/css" media="screen" charset="utf-8" />
<script src="<?php echo base_url();?>js/datepick/coda.js" type="text/javascript"> </script>
<div id="calleft">
<?php 
echo "<p>";
echo anchor('calendar/admin/create', 'Add Events to Calendar');
echo "</p>";
echo "<p>";
echo anchor('calendar/admin/index/', 'Show Site Calendar');
echo "</p>";
?>
 
</div>
 <div id="calmain">

<?php 
// this will outputs three times same thing. I need to create a new model to get the name only.
        echo "<h3>".$user['username']."'s calendar";
if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}
?>
	<h2><?php echo$current_month_text?></h2>
	<table cellspacing="0">
		<thead>
		<tr>
			<th>Sun</th>
			<th>Mon</th>
			<th>Tue</th>
			<th>Wed</th>
			<th>Thu</th>
			<th>Fri</th>
			<th>Sat</th>
		</tr>
		</thead>
		<tr>
			<?php
			for($i=0; $i< $total_rows; $i++)
			{
				for($j=0; $j<7;$j++)
				{
					$day++;					
					
					if($day>0 && $day<=$total_days_of_current_month)
					{
						//YYYY-MM-DD date format
						$date_form = "$current_year/$current_month/$day";
						
						echo '<td';
						
						//check if the date is today
						if($date_form == $today)
						{
							echo ' id="today"';
						}
						
						//check if any event stored for the date
						if(array_key_exists($day,$events))
						{
							//adding the date_has_event class to the <td> and close it
							echo ' class="date_has_event"> '.$day;
							
							//adding the eventTitle and eventContent wrapped inside <span> & <li> to <ul>
							echo '<div class="events"><ul>';
							
							foreach ($events as $key=>$event){
								if ($key == $day){
							  	foreach ($event as $single){					
								
							echo  '<li>';
							echo anchor("calendar/admin/edit/$single->id",'<span class="title">'.$single->eventTitle.'(by '.$single->user.')</span><span class="desc">'.$single->eventContent.'</span>');
							echo '</li>'; 
													} // end of for each $event
								}
  								
							} // end of foreach $events

							echo '</ul></div>';
						} // end of if(array_key_exists...)
						else 
						{
							//if there is not event on that date then just close the <td> tag
							echo '> '.$day;
						}
						echo "</td>";
					}
					else 
					{
						//showing empty cells in the first and last row
						echo '<td class="padding">&nbsp;</td>';
					}
				}
				echo "</tr><tr>";
			}
			
			?>
		</tr>
	
		<tfoot>		
			<th>
			<?php echo anchor('calendar/admin/mycal/'.$user_id."/".$previous_year,'&laquo;&laquo;', array('title'=>$previous_year_text));?>
			</th>
			<th>
			<?php echo anchor('calendar/admin/mycal/'.$user_id."/".$previous_month,'&laquo;', array('title'=>$previous_month_text));?>
			</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>
			<?php echo anchor('calendar/admin/mycal/'.$user_id."/".$next_month,'&raquo;', array('title'=>$next_month_text));?>
			</th>
			<th>
			<?php echo anchor('calendar/admin/mycal/'.$user_id."/".$next_year,'&raquo;&raquo;', array('title'=>$next_year_text));?>
			
			</th>		
		</tfoot>
	</table>
</div>
<div id="calright">
<?php 

foreach ($members->result_array() as $member){
	echo "<p>";
	echo anchor('calendar/admin/mycal/'.$member['id'],$member['username'].'\'s Calendar' );
	echo "</p>";
	
 }

?></div>
