<div id="pageleftcont">
<div id="create_edit">
<?php

if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}

echo form_open('subscribers/admin/sendemail');

echo "<p><label for='subject'>".$this->lang->line('kago_subject')."</label><br/>";
$data = array('name' => 'subject', 'id' => 'subject', 'size' => 50, 'value'=>$subject);
echo form_input($data);
echo "</p>";

echo "<p><label for='message'>".$this->lang->line('kago_message')."</label><br/>";
$data = array('name' => 'message', 'id' => 'message', 'rows' => 20, 'cols' => 50, 'value'=>$msg);
echo form_textarea($data);
echo "</p>";

echo "<p>".form_checkbox('test', 'true', TRUE) . " <b>".$this->lang->line('kago_test')."</b></p>";
echo form_submit('submit',$this->lang->line('kago_sendemail'));
echo form_close();


?>
</div>
</div>