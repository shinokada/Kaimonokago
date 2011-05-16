<h2><?php echo $title;?></h2>
<?php
if($category['lang_id']==0 AND $multilang ){
    echo showtranslang($languages,$translanguages,$category, $module);
}

echo form_open('category/admin/edit');

echo "\n<table id='preference_form'><tr><td class='label'><label for='catname'>".$this->lang->line('kago_name')."</label></td>\n";
$data = array('name'=>'name','id'=>'catname','class'=>'text','value' => $category['name']);
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='short'>".$this->lang->line('kago_short_desc')."</label></td>\n";
$data = array('name'=>'shortdesc','id'=>'short','class'=>'text', 'value' => $category['shortdesc']);
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='long'>".$this->lang->line('kago_long_desc')."</label></td>\n";
$data = array('name'=>'longdesc','id'=>'long','rows'=>'30', 'cols'=>'80', 'value' => $category['longdesc']);
echo "<td id='nopad' >";
echo form_textarea($data);
?>
<a href="javascript:toggleEditor('long');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php
echo "</td></tr>\n";
echo "<tr><td class='label'><label for='parent'>".$this->lang->line('kago_parent')."</label></td>\n";
echo "<td>";
echo form_dropdown('parentid',$categories,$category['parentid']) ;
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='status'>".$this->lang->line('kago_status')."</label></td>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo "<td>";
echo form_dropdown('status',$options, $category['status']);
echo "</td></tr>\n</table>\n";


echo form_hidden('id',$category['id']);
echo form_hidden('lang_id',$category['lang_id']);
echo form_hidden('table_id',$category['table_id']);

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

//echo form_submit('submit',$this->lang->line('kago_update'));
echo form_close();

?>

 