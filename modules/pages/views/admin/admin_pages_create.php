<h2><?php echo $title;?></h2>
<?php

echo form_open('pages/admin/create');
echo "\n<table id='preference_form'><tr><td class='label'><label for='menuname'>".$this->lang->line('kago_name')."</label></td>\n";
$data = array('name'=>'name','id'=>'pname','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='short'>".$this->lang->line('kago_keyword')."</label></td>\n";
$data = array('name'=>'keywords','id'=>'short','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='short'>".$this->lang->line('kago_desc')."</label></td>\n";
$data = array('name'=>'description','id'=>'desc', 'class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='short'>".$this->lang->line('kago_path_furl')." Use one word or with under line _ .</label></td>\n";
$data = array('name'=>'path','id'=>'fpath', 'class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='long'>".$this->lang->line('kago_content')."</label></td>\n";
$data = array('name'=>'content','id'=>'long','rows'=>'30', 'cols'=>'80');
echo "<td id='nopad' >";
echo form_textarea($data);
?>
    <a href="javascript:toggleEditor('long');"><?php echo $this->lang->line('kago_add_remove') ;?></a>
<?php
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='status'>".$this->lang->line('kago_status')."</label></td>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo "<td>";
echo form_dropdown('status',$options);
echo "</td></tr>\n</table>\n";

echo form_hidden('lang_id', 0);// english
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