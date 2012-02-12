<?php print displayStatus();?>
<h2><?php echo $title;?></h2>
    <?php
if($pagecontent['lang_id']==0 AND $multilang){
    //echo "Current config language is : ".$this->configlang;
    echo showtranslang($languages,$translanguages,$pagecontent, $module);
}

echo form_open('pages/admin/edit');
echo "\n<table id='preference_form'><tr><td class='label'><label for='menuname'>".$this->lang->line('kago_name')."</label></td>\n";
$data = array('name'=>'name','id'=>'pname', 'value' => $pagecontent['name'],'class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='short'>".$this->lang->line('kago_keyword')."</label></td>\n";
$data = array('name'=>'keywords','id'=>'short', 'value' => $pagecontent['keywords'],'class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='short'>".$this->lang->line('kago_desc')."</label></td>\n";
$data = array('name'=>'description','id'=>'desc', 'value' => $pagecontent['description'],'class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

//if($pagecontent['lang_id']==0){
    echo "<tr><td class='label'><label for='fpath'>".$this->lang->line('kago_path_furl')."</label></td>\n";
    $data = array('name'=>'path','id'=>'fpath', 'value' => $pagecontent['path'],'class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

/*
}else{
    echo "<td><h3>".$this->lang->line('kago_path_furl'). $pagecontent['path']."</h3></td>";
    echo form_hidden('path', $pagecontent['path']);
}
*/
echo "<tr><td class='label'><label for='long'>".$this->lang->line('kago_content')."</label></td>\n";
$data = array('name'=>'content','id'=>'long','rows'=>'30', 'cols'=>'80', 'value' => $pagecontent['content']);
echo "<td id='nopad' >";
echo form_textarea($data);
?>
    <br /><a href="javascript:toggleEditor('long');"><?php echo $this->lang->line('kago_add_remove') ;?></a>
<?php
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='status'>".$this->lang->line('kago_status')."</label></td>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo "<td>";
echo form_dropdown('status',$options,$pagecontent['status']);
echo "</td></tr>\n</table>\n";

echo form_hidden('lang_id', $pagecontent['lang_id']);
echo form_hidden('id',$pagecontent['id']);

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
//echo form_submit('submit',$this->lang->line('kago_create_menu'));
echo form_close();


?>
