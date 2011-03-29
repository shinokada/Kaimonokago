<div id="pageleftcont">
<h2><?php echo $title;?></h2>
<?php
echo form_open($module.'/admin/create');
echo "\n<p><label for='name'>".$this->lang->line('kago_name')."</label><br/>\n";
$data = array('name'=>'name','id'=>'name','size'=>25);
echo form_input($data) ."</p>\n";

echo "<p><label for='short'>".$this->lang->line('kago_short_desc')."</label><br/>\n";
$data = array('name'=>'shortdesc','id'=>'short','rows'=>5, 'cols'=>'40');
echo form_textarea($data) ."</p>\n";
?>
<a href="javascript:toggleEditor('short');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php
echo "<p><label for='long'>".$this->lang->line('kago_long_desc')."</label><br/>\n";
$data = array('name'=>'longdesc','id'=>'long','rows'=>5, 'cols'=>'40');
echo form_textarea($data) ."</p>\n";
?>
<a href="javascript:toggleEditor('long');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php
echo "<p><label for='uimage'>Select Image</label><br/>";
$data = array('name'=>'image','id'=>'image','size'=>80);
echo form_textarea($data) ."</p>\n";

echo "<p><label for='status'>".$this->lang->line('kago_status')."</label><br/>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options) ."</p>\n";

echo "<p><label for='parent'>".$this->lang->line('kago_parent')."</label><br/>\n";
echo form_dropdown('parentid',$plays) ."</p>\n";

echo form_hidden('lang_id', '0');
echo form_hidden('table_id', '0');
echo form_submit('submit',$this->lang->line('kago_create'));
echo form_close();

echo "<pre>";

echo "</pre>";
?>

</div>
