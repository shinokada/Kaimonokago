<h2><?php 
echo anchor ('calendar/admin/index', 'See Calendar');
?></h2>

<?php

if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}

echo form_open('calendar/admin/update');?>
	<table align="center">
		<tr>
			<td colspan="2">
				<h2>Edit Event</h2>
			</td>
		</tr>
		<tr>
			<td>Date : </td>
			<td><input id="date" name="date" size="30" value="<?php echo $event[0]['eventDate'] ;?>" ></td>
		</tr>
		<tr>
			<td>Event Title : </td>
			<td><input id="eventTitle" name="eventTitle" value="<?php echo $event[0]['eventTitle'] ;?>" size="50"></td>
		</tr>
		<tr>
			<td>Event Details : </td>
			<td><textarea cols="40" rows="5" name="eventContent" id="eventContent"><?php echo $event[0]['eventContent'] ;?></textarea></td>
		</tr>
		<input type="hidden" name="id" value="<?php echo $event[0]['id'] ;?>" />
		<tr>
			<td colspan="2"><input type="submit" value="Update Event" name="add"></td>
		</tr>
		<tr>
		<td colspan="2">
	<?php 	echo anchor("calendar/admin/delete/".$event[0]['id'],'Delete');		?>				
									
		
		</td>
		</tr>
	</table>
	</form>
	
	
