<?php echo form_open("subscribers/admin/create_sub"); 

echo "\n<table id='preference_form'><tr><td class='label'><label for='name'>".$this->lang->line('kago_name')."</label></td>\n";
$namevalue=set_value('name');
$data = array('name'=>'name','id'=>'name','class'=>'text', 'value'=>$namevalue);
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='email'>".$this->lang->line('kago_email')."</label></td>\n";
$emailvalue=set_value('email');
$data = array('name'=>'email','id'=>'email','class'=>'text', 'value' => $emailvalue);
echo "<td>";
echo form_input($data);
echo "</td></tr></table>\n";
?>
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


<?php
echo form_close();
?>



