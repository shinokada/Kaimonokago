<h2><?php echo $title;?></h2>
<?php
echo form_open_multipart('slideshow/admin/create')."\n";

echo "\n<table id='preference_form'><tr><td class='label'><label for='pname'>".$this->lang->line('kago_name')."</label></td>\n";
$data = array('name'=>'name','id'=>'pname','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='short'>".$this->lang->line('kago_short_desc')."</label></td>\n";
$data = array('name'=>'shortdesc','id'=>'short','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='long'>".$this->lang->line('kago_long_desc')."</label></td>\n";
$data = array('name'=>'longdesc','id'=>'long','rows'=>'10', 'cols'=>'80');
echo "<td id='nopad' >";
echo form_textarea($data) ;

?>
<a href="javascript:toggleEditor('long');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='uimage'>".$this->lang->line('kago_select_img')."</label></td>\n";
$data = array('name'=>'image','id'=>'uimage','rows'=>'10', 'cols'=>'80');
echo "<td id='nopad' >";
echo form_textarea($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='uthumb'>".$this->lang->line('kago_select_thumb')."</label></td>\n";
$data = array('name'=>'thumbnail','id'=>'uthumb','rows'=>'10', 'cols'=>'80');
echo "<td id='nopad' >";
echo form_textarea($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='status'>".$this->lang->line('kago_status')."</label></td>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo "<td>";
echo form_dropdown('status',$options);
echo "</td></tr>\n";



echo "<tr><td class='label'><label for='slide_order'>".$this->lang->line('kago_order')."</label></td>\n";
$data = array('name'=>'slide_order','id'=>'slide_order','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr></table>\n";

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
//echo form_submit('submit',$this->lang->line('kago_add_slide'));
echo form_close();


?>


