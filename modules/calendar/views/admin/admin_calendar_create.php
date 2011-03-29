<h2><?php 
echo anchor ('calendar/admin/index', 'See Calendar');
?></h2>

<?php 
if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}

echo form_open('calendar/admin/create');?>
	<table align="center">
		<tr>
			<td colspan="2">
				<h2>Add a New Event</h2>
			</td>
		</tr>
		<tr>
			<td>Date : </td>
			<td><input id="date" name="date" size="30"></td>
		</tr>
		<tr>
			<td>Event Title : </td>
			<td><input id="eventTitle" name="eventTitle" size="50"></td>
		</tr>
		<tr>
			<td>Event Details : </td>
			<td><textarea cols="40" rows="5" name="eventContent" id="eventContent"></textarea></td>
		</tr>
		<tr>
		<td><input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>" /></td>
		<td><input type="hidden" name="user" id="nick" value="<?php echo $user;?>" />		</td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="Add Event" name="add"></td>
		</tr>
	</table>
	</form>
	
	
	<?php
//check if there is any alert message set
if(isset($alert) && !empty($alert))
{
	//message alert
	echo $alert;
}
?>
	