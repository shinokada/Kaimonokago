<h2><?php echo $title;?></h2>
    <?php
 //   echo "lang_id is $lang_id and path is $path<br />";
//echo "Current config language is : ".$this->configlang;
//The following works, but not showing in other languages
//echo showtranslang($languages,$translanguages,$pagecontent, $module);
?>
<?php

echo form_open('pages/admin/langcreate');

echo "\n<p><label for='pname'>".$this->lang->line('kago_name')."</label><br/>\n";
$data = array('name'=>'name','id'=>'pname','size'=>25);
echo form_input($data) ."</p>\n";

echo "<p><label for='short'>".$this->lang->line('kago_keyword')."</label>\n";
$data = array('name'=>'keywords','id'=>'short','size'=>40);
echo form_input($data) ."</p>\n";

echo "<p><label for='desc'>".$this->lang->line('kago_desc')."</label>\n";
$data = array('name'=>'description','id'=>'desc','size'=>40);
echo form_input($data) ."</p>\n";


echo "<h3>".$this->lang->line('kago_path_furl'). $pagecontent['path']."</h3>";


echo "<p><label for='long'>".$this->lang->line('kago_content')."</label><br/>\n";
$data = array('name'=>'content','id'=>'long','rows'=>5, 'cols'=>'40');
echo form_textarea($data) ."</p>\n";
?>
<a href="javascript:toggleEditor('long');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php
echo "<p><label for='status'>".$this->lang->line('kago_status')."</label><br/>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options) ."</p>\n";

//echo form_hidden('name', $pagecontent['name']);
echo form_hidden('path', $pagecontent['path']);
echo form_hidden('lang_id', $lang_id);
echo form_submit('submit',$this->lang->line('kago_create_page'));
echo form_close();

echo "<pre>selected_lang";
print_r ($selected_lang);
echo "</pre>";
?>
