 <div id="calmain">

	<h2><?php echo $current_month_text?></h2>

        <div class="buttons">
	<a href="<?php print  site_url('calendar/admin/create')?>">
    <?php print $this->bep_assets->icon('add');?>
    <?php print $this->lang->line('kago_add')." ".$this->lang->line('kago_event'); ?>
    </a>

</div>
<div class="clearboth">&nbsp;</div>
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
							  		echo '<li>'; 					
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
			<?php echo anchor('calendar/admin/index/'.$previous_year,'&laquo;&laquo;', array('title'=>$previous_year_text));?>
			</th>
			<th>
			<?php echo anchor('calendar/admin/index/'.$previous_month,'&laquo;', array('title'=>$previous_month_text));?>
			</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>
			<?php echo anchor('calendar/admin/index/'.$next_month,'&raquo;', array('title'=>$next_month_text));?>
			</th>
			<th>
			<?php echo anchor('calendar/admin/index/'.$next_year,'&raquo;&raquo;', array('title'=>$next_year_text));?>
			
			</th>		
		</tfoot>
	</table>
</div>
<div id="calright">
<?php 
/*
foreach ($members->result_array() as $member){
	echo "<p>";
	echo anchor('calendar/admin/mycal/'.$member['id'],$member['username'].'\'s Calendar' );
	echo "</p>";
 }
 * 
 */
?>

</div>
	
