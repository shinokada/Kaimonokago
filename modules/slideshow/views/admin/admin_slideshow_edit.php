<?php print displayStatus();?>
<div id="pageleftcont">
<div id="create_edit">
<h2><?php echo $title;?></h2>
<?php


//echo showtranslang($languages,$translanguages,$product, $module);


echo form_open_multipart('slideshow/admin/edit/'.$slide['id']);

echo "<p><label for='pname'>".$this->lang->line('kago_name')."</label><br/>";
$data = array('name'=>'name','id'=>'pname','size'=>25,'value' => $slide['name']);
echo form_input($data) ."</p>\n";


echo "<p><label for='short'>".$this->lang->line('kago_short_desc')."</label><br/>\n";
$data = array('name'=>'shortdesc','id'=>'short','rows'=>5, 'cols'=>'80', 'value' => $slide['shortdesc']);
echo form_textarea($data) ."</p>\n";
?>
<a href="javascript:toggleEditor('short');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php 
echo "<p><label for='long'>".$this->lang->line('kago_long_desc')."</label><br/>\n";
$data = array('name'=>'longdesc','id'=>'long','rows'=>10, 'cols'=>'80', 'value' => $slide['longdesc']);
echo form_textarea($data) ."</p>\n";
?>
<a href="javascript:toggleEditor('long');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php 
echo "<p><label for='uimage'>".$this->lang->line('kago_select_img')."</label><br/>\n";
$data = array('name'=>'image','id'=>'uimage','size'=>100, 'value' => $slide['image']);
echo form_textarea($data) . "</p>\n";

echo "<p><label for='uthumb'>".$this->lang->line('kago_select_thumb')."</label><br/>\n";
$data = array('name'=>'thumbnail','id'=>'uthumb','size'=>100, 'value' => $slide['thumbnail']);
echo form_textarea($data) ."</p>\n";

echo "<p><label for='status'>".$this->lang->line('kago_status')."</label><br/>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options, $slide['status']) ."</p>\n";

echo "<p><label for='product_order'>".$this->lang->line('kago_slide_order')."</label><br/>";
$data = array('name'=>'slide_order','id'=>'product_order','size'=>11,'value' => $slide['slide_order']);
echo form_input($data) ."</p>\n";


echo form_hidden('id',$slide['id']);
echo form_submit('submit',$this->lang->line('kago_update_slide'));
echo form_close();



echo "<pre>slide";
print_r($slide);
echo "</pre>";


?>
</div>
 </div>
   