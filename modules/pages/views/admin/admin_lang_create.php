<h2><?php echo $title;?></h2>
    <?php
 //   echo "lang_id is $lang_id and path is $path<br />";
//echo "Current config language is : ".$this->configlang;
//The following works, but not showing in other languages
//echo showtranslang($languages,$translanguages,$pagecontent, $module);
?>
<?php

echo form_open('pages/admin/langcreate');

echo "\n<table id='preference_form'><tr><td class='label'><label for='pname'>".$this->lang->line('kago_name')."</label><br />\n";
echo $this->lang->line('kago_original').$pagecontent['name']."</td>";
$data = array('name'=>'name','id'=>'pname','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='short'>".$this->lang->line('kago_keyword')."</label><br />\n";
echo $this->lang->line('kago_original').$pagecontent['keywords']."</td>";
$data = array('name'=>'keywords','id'=>'short','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='desc'>".$this->lang->line('kago_desc')."</label><br />\n";
echo $this->lang->line('kago_original').$pagecontent['description']."</td>";
$data = array('name'=>'description','id'=>'desc','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";


echo "<tr><td>".$this->lang->line('kago_path_furl')."</td>";
echo "<td>".$pagecontent['path']."</td></tr>\n";

echo "<tr><td class='label'><label for='long'>".$this->lang->line('kago_content')."</label><br />\n";
echo $this->lang->line('kago_original').$pagecontent['content']."</td>";
echo "<td id='nopad' >";
$data = array('name'=>'content','id'=>'long','rows'=>'30', 'cols'=>'80');
echo form_textarea($data);

?>
<a href="javascript:toggleEditor('long');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='status'>".$this->lang->line('kago_status')."</label></td>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo "<td>";
echo form_dropdown('status',$options) ."</p>\n";
echo "</td></tr></table>\n";

//echo form_hidden('name', $pagecontent['name']);
echo form_hidden('path', $pagecontent['path']);
echo form_hidden('lang_id', $lang_id);
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
//echo form_submit('submit',$this->lang->line('kago_create_page'));
echo form_close();

echo "<pre>selected_lang";
print_r ($selected_lang);
echo "</pre>";
?>
