<h2><?php echo $title;?></h2>
<?php


//echo showtranslang($languages,$translanguages,$product, $module);


echo form_open_multipart('slideshow/admin/edit/'.$slide['id']);

echo "\n<table id='preference_form'><tr><td class='label'><label for='pname'>".$this->lang->line('kago_name')."</label></td>\n";
$data = array('name'=>'name','id'=>'pname','class'=>'text','value' => $slide['name']);
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='short'>".$this->lang->line('kago_short_desc')."</label></td>\n";
$data = array('name'=>'shortdesc','id'=>'short','class'=>'text', 'value' => $slide['shortdesc']);
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='long'>".$this->lang->line('kago_long_desc')."</label></td>\n";
$data = array('name'=>'longdesc','id'=>'long','rows'=>'10', 'cols'=>'80', 'value' => $slide['longdesc']);
echo "<td id='nopad' >";
echo form_textarea($data) ;

?>
<a href="javascript:toggleEditor('long');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='uimage'>".$this->lang->line('kago_select_img')."</label></td>\n";
$data = array('name'=>'image','id'=>'uimage','rows'=>'10', 'cols'=>'80', 'value' => $slide['image']);
echo "<td id='nopad' >";
echo form_textarea($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='uthumb'>".$this->lang->line('kago_select_thumb')."</label></td>\n";
$data = array('name'=>'thumbnail','id'=>'uthumb','rows'=>'10', 'cols'=>'80', 'value' => $slide['thumbnail']);
echo "<td id='nopad' >";
echo form_textarea($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='status'>".$this->lang->line('kago_status')."</label></td>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo "<td>";
echo form_dropdown('status',$options, $slide['status']);
echo "</td></tr>\n";



echo "<tr><td class='label'><label for='slide_order'>".$this->lang->line('kago_order')."</label></td>\n";
$data = array('name'=>'slide_order','id'=>'slide_order','class'=>'text','value' => $slide['slide_order']);
echo "<td>";
echo form_input($data);
echo "</td></tr></table>\n";

echo form_hidden('id',$slide['id']);
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
//echo form_submit('submit',$this->lang->line('kago_update_slide'));
echo form_close();
/*
echo "<pre>slide";
print_r($slide);
echo "</pre>";
*/

?>

   