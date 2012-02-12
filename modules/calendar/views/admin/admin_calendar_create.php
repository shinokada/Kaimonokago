<h2><?php echo $title;?></h2>
<div class="buttons">
    <a href="<?php print  site_url('calendar/admin/index')?>">
    <?php print $this->bep_assets->icon('television');?>
    <?php print $this->lang->line('kago_show')." ".$this->lang->line('kago_calendar'); ?>
    </a>
</div>
<div class="clearboth">&nbsp;</div>
<?php 
if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}

echo form_open('calendar/admin/create');?>
	<table align="center" id="preference_form">
		
		<tr>
			<td>Date : </td>
			<td><input id="date" name="date" class="text"></td>
		</tr>
		<tr>
			<td>Event Title : </td>
			<td><input id="eventTitle" name="eventTitle" class="text"></td>
		</tr>
		<tr>
			<td>Event Details : </td>
			<td><input  name="eventContent" class="text"></td>
		</tr>
		<tr>
		<td><input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>" /></td>
		<td><input type="hidden" name="user" id="nick" value="<?php echo $user;?>" />		</td>
		</tr>

                </table>

<div class="buttons">
	<button type="submit" class="positive" name="submit" value="submit">
    <?php print $this->bep_assets->icon('disk');?>
    <?php print $this->lang->line('general_save');?>
    </button>

    <a href="<?php print site_url($cancel_link);?>" class="negative">
    <?php print $this->bep_assets->icon('cross');?>
    <?php print $this->lang->line('general_cancel');?>
    </a>
</div>
	
	</form>
	
	
	<?php
//check if there is any alert message set
if(isset($alert) && !empty($alert))
{
	//message alert
	echo $alert;
}
?>
	