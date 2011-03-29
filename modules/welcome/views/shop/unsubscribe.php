<?php print displayStatus();?>
<?php
if ($this->session->flashdata('subscribe_msg')){
	echo "<div class='status_box'>";
	echo $this->session->flashdata('subscribe_msg');
	echo "</div>";
}
?>

<?php echo form_open($module."/unsubscribe"); ?>
<h1>
<?php echo form_fieldset('Unsubscribe from Our Newsletter'); ?>
</h1>


<h5>*Email</h5>
<input type="text" name="email" id="email" value="<?php echo set_value('email'); ?>" size="40" />

<h5>*Are you human?</h5>
<?php echo "<p>$cap_img</p>" ;?>

<div><input type="submit" value="Unsubscribe" /></div>
<?php echo form_fieldset_close(); ?>

<?php echo form_close(); ?>
