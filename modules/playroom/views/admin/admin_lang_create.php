<h2><?php echo $title;?></h2>
    <?php
 //   echo "lang_id is $lang_id and path is $path<br />";
//echo $checktrans;
//echo "Current config language is : ".$this->configlang;
//echo showtranslang($languages,$translanguages,$info, $module);

?>
<?php

echo form_open($module.'/admin/langcreate');

//echo "<h3>Page name: ". $pagecontent['name']."</h3>\n";
echo "\n<p><label for='name'>".$this->lang->line('kago_name')."</label>\n";
echo $this->lang->line('kago_original').$info['name'];
$data = array('name'=>'name','id'=>'pname','size'=>25);
echo form_input($data) ."</p>\n";

echo "<p><label for='short'>".$this->lang->line('kago_short_desc')."</label>\n";
echo "Original: ".$info['shortdesc'];
$data = array('name'=>'shortdesc','id'=>'short','rows'=>5, 'cols'=>'40');
echo form_textarea($data) ."</p>\n";
?>
<a href="javascript:toggleEditor('short');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php
echo "<p><label for='long'>".$this->lang->line('kago_long_desc')."</label><br/>\n";
echo "Original: ".$info['longdesc'];
$data = array('name'=>'longdesc','id'=>'long','rows'=>5, 'cols'=>'40');
echo form_textarea($data) ."</p>\n";
?>
<a href="javascript:toggleEditor('long');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php
echo "<p><label for='status'>".$this->lang->line('kago_status')."</label><br/>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options) ."</p>\n";

echo "<p><label for='parent'>Parent</label><br/>\n";
echo form_dropdown('parentid',$plays) ."</p>\n";

//echo form_hidden('name', $pagecontent['name']);
echo form_hidden('image', $info['image']);
echo form_hidden('table_id', $info['id']);
echo form_hidden('lang_id', $lang_id);
echo form_submit('submit',$this->lang->line('kago_add_trans'));
echo form_close();

echo "<pre>languages";
print_r ($languages);
echo "</pre>";

echo "<pre>selected_lang";
print_r ($selected_lang);
echo "</pre>";

echo "<pre>category";
print_r ($info);
echo "</pre>";
?>


