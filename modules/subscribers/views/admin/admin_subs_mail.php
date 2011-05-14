<?php
echo form_open('subscribers/admin/sendemail');

echo "\n<table id='preference_form'><tr><td class='label'><label for='subject'>".$this->lang->line('kago_subject')."</label></td>\n";
echo "<td>";
$data = array('name' => 'subject', 'id' => 'subject','class'=>'text', 'value'=>$subject);
echo form_input($data);
echo "</td></tr>";

echo "<tr><td class='label'><label for='message'>".$this->lang->line('kago_message')."</label></td>\n";
echo "<td id='nopad' >";
$data = array('name' => 'message', 'id' => 'message', 'rows' => 20, 'cols' => 50, 'value'=>$msg);
echo form_textarea($data);
echo "</td></tr></table>";

echo "<tr><td>".form_checkbox('test', 'true', TRUE) . "</td><td><b>".$this->lang->line('kago_test')."</b></td></tr></table>\n";

?>
<div class="buttons">
	<button type="submit" class="positive" name="submit" value="submit">
    <?php print $this->bep_assets->icon('email');?>
    <?php print $this->lang->line('kago_send');?>
    </button>

    <a href="<?php print site_url($cancel_link);?>" class="negative">
    <?php print $this->bep_assets->icon('cross');?>
    <?php print $this->lang->line('general_cancel');?>
    </a>
</div>
<?php
//echo form_submit('submit',$this->lang->line('kago_sendemail'));
echo form_close();


?>
