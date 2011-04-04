<div id="pageleftcont">
<div id="create_edit">

<h2><?php echo $title;?></h2>
<?php

echo form_open('pages/admin/create');
echo "\n<p><label for='pname'>".$this->lang->line('kago_name')."</label><br/>\n";
$data = array('name'=>'name','id'=>'pname','size'=>25);
echo form_input($data) ."</p>\n";

echo "<p><label for='short'>".$this->lang->line('kago_keyword')."</label><br/>\n";
$data = array('name'=>'keywords','id'=>'short','size'=>40);
echo form_input($data) ."</p>\n";

echo "<p><label for='desc'>".$this->lang->line('kago_desc')."</label><br/>\n";
$data = array('name'=>'description','id'=>'desc','size'=>40);
echo form_input($data) ."</p>\n";

echo "<p><label for='fpath'>".$this->lang->line('kago_path_furl')." Use one word or with under line _ .</label><br/>\n";
$data = array('name'=>'path','id'=>'fpath','size'=>50);
echo form_input($data) ."</p>\n";

echo "<p><label for='long'>".$this->lang->line('kago_content')."</label><br/>\n";
$data = array('name'=>'content','id'=>'long','rows'=>5, 'cols'=>'40');
echo form_textarea($data) ."</p>\n";
?>
<a href="javascript:toggleEditor('long');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php 
echo "<p><label for='status'>".$this->lang->line('kago_status')."</label><br/>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options) ."</p>\n";

echo form_hidden('lang_id', 0);// english
echo form_submit('submit',$this->lang->line('kago_create_page'));
echo form_close();


?>
</div>
  </div>