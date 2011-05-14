<h2><?php echo $title;?></h2>

<?php
echo form_open('category/admin/create');
echo "\n<table id='preference_form'><tr><td class='label'><label for='catname'>".$this->lang->line('kago_name')."</label></td>\n";
$data = array('name'=>'name','id'=>'catname','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='short'>".$this->lang->line('kago_short_desc')."</label></td>\n";
$data = array('name'=>'shortdesc','id'=>'short','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='long'>".$this->lang->line('kago_long_desc')."</label></td>\n";
$data = array('name'=>'longdesc','id'=>'long','rows'=>'30', 'cols'=>'80');
echo "<td id='nopad' >";
echo form_textarea($data);
?>
    <a href="javascript:toggleEditor('long');"><?php echo $this->lang->line('kago_add_remove') ;?></a>
<?php
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='parent'>".$this->lang->line('kago_parent')."</label></td>\n";
echo "<td>";
echo form_dropdown('parentid',$categories) ;
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='status'>".$this->lang->line('kago_status')."</label></td>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo "<td>";
echo form_dropdown('status',$options);
echo "</td></tr>\n</table>\n";

echo form_hidden('lang_id', '0');
echo form_hidden('table_id', '0');

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

//echo form_submit('submit',$this->lang->line('kago_create'));
echo form_close();
/*
echo "<pre>category";
print_r ($categories);
echo "</pre>";
 * 
 */
?>
