<?php print displayStatus();?>
<?php
if ($this->session->flashdata('subscribe_msg')){
	echo "<div class='status_box'>";
	echo $this->session->flashdata('subscribe_msg');
	echo "</div>";
}
?>

<?php echo form_open($module."/subscribe"); ?>
<h1>
<?php echo form_fieldset('Subscribe To Our Newsletter'); ?>
</h1>
<h5>*Name</h5>
<input type="text" name="name" id="name" value="<?php echo set_value('name'); ?>" size="40" />

<h5>*Email</h5>
<input type="text" name="email" id="email" value="<?php echo set_value('email'); ?>" size="40" />
<?php

if($security_method=='recaptcha'){
    echo "<h5>*".$this->lang->line('contact_captcha')."</h5>";
    echo "<p>$cap_img</p>" ;

    }elseif($security_method=='question'){
    echo "<label for=\"write_ans\">*". $this->lang->line('webshop_write_ans')."</label><br />";
    echo $question;
    echo "<input type=\"text\" name=\"write_ans\" id=\"write_ans\" maxlength=\"30\" size=\"30\"  />";
    }

?>

<div><input type="submit" value="Subscribe" /></div>
<?php echo form_fieldset_close(); ?>

<?php echo form_close(); ?>
