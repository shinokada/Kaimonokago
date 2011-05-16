<h2><?php echo $title;?></h2>
<div class="buttons">
    <a href="<?php print  site_url('calendar/admin/index')?>">
    <?php print $this->bep_assets->icon('television');?>
    <?php print $this->lang->line('kago_show')." ".$this->lang->line('kago_calendar'); ?>
    </a>
    <a href="<?php print  site_url('calendar/admin/delete/'.$event[0]['id'])?>">
    <?php print $this->bep_assets->icon('delete');?>
    <?php print $this->lang->line('kago_delete'); ?>
    </a>
    <?php 	//echo anchor("calendar/admin/delete/".$event[0]['id'],'Delete');		?>
</div>
<div class="clearboth">&nbsp;</div>

<?php

if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}

echo form_open('calendar/admin/edit');?>
	<table align="center" id="preference_form">
		
		<tr>
			<td>Date : </td>
			<td><input id="date" name="date" class="text" value="<?php echo $event[0]['eventDate'] ;?>" ></td>
		</tr>
		<tr>
			<td>Event Title : </td>
			<td><input id="eventTitle" name="eventTitle" value="<?php echo $event[0]['eventTitle'] ;?>" class="text"></td>
		</tr>
		<tr>
			<td>Event Details : </td>
			<td><input name="eventContent" class="text" value="<?php echo $event[0]['eventContent'] ;?>"></td>
		</tr>
		<input type="hidden" name="id" value="<?php echo $event[0]['id'] ;?>" />
		
	
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
/*
echo "<pre>";
print_r ($event);
echo "</pre>";
*/
?>