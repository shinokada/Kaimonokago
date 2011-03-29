
<div id="pageleftcont">
<h2><?php echo $title;?></h2>
<div id="create_edit">
<?php
if($info['lang_id']==0){
    echo showtranslang($languages,$translanguages,$info, $module);
}

echo form_open($module.'/admin/edit');

//echo form_hidden('name', $info['name']);
/*
echo "<p><label for='update'>Update</label><br/>";
echo form_checkbox('update', 'update', TRUE);
*/
echo "<p><label for='name'>".$this->lang->line('kago_name')."</label><br/>";
$data = array('name'=>'name','id'=>'catname','size'=>25,'value' => $info['name']);
echo form_input($data) ."</p>\n";
//echo "<h2>".$info['name']."</h2>";

echo "<p><label for='short'>".$this->lang->line('kago_short_desc')."</label><br/>";
$data = array('name'=>'shortdesc','id'=>'short','size'=>40, 'value' => $info['shortdesc']);
echo form_textarea($data) ."</p>";
?>
<a href="javascript:toggleEditor('short');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php
echo "<p><label for='long'>".$this->lang->line('kago_long_desc')."</label><br/>";
$data = array('name'=>'longdesc','id'=>'long','rows'=>5, 'cols'=>'40', 'value' => $info['longdesc']);
echo form_textarea($data) ."</p>";
?>
<a href="javascript:toggleEditor('long');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php
echo "<p><label for='uimage'>Select Image</label><br/>";
$data = array('name'=>'image','id'=>'image','size'=>80, 'value' => $info['image']);
echo form_textarea($data) ."</p>\n";

echo "<p><label for='status'>".$this->lang->line('kago_status')."</label><br/>";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options, $info['status']) ."</p>";

echo "<p><label for='parent'>".$this->lang->line('kago_parent')."</label><br/>";
echo form_dropdown('parentid',$items,$info['parentid']) ."</p>";

echo form_hidden('id',$info['id']);
echo form_hidden('lang_id',$info['lang_id']);
echo form_hidden('table_id',$info['table_id']);
echo form_submit('submit',$this->lang->line('kago_update'));
echo form_close();

echo "<pre>languages";
print_r ($languages);
echo "</pre>";
echo "<pre>translanguages";
print_r ($translanguages);
echo "</pre>";

echo "<pre>info";
print_r ($info);
echo "</pre>";
echo "<pre>module";
print_r ($module);
echo "</pre>";



?>
</div>
 </div>
   