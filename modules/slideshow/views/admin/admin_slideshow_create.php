
<div id="pageleftcont">
<div id="create_edit">
<h2><?php echo $title;?></h2>
<?php
echo form_open_multipart('slideshow/admin/create')."\n";

echo "<p><label for='pname'>".$this->lang->line('kago_name')."</label><br/>";
$data = array('name'=>'name','id'=>'pname','size'=>25);
echo form_input($data) ."</p>\n";

echo "<p><label for='short'>".$this->lang->line('kago_short_desc')."</label><br/>";
$data = array('name'=>'shortdesc','id'=>'short','rows'=>5, 'cols'=>'80');
echo form_textarea($data) ."</p>\n";
?>
<a href="javascript:toggleEditor('short');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php 
echo "<p><label for='long'>".$this->lang->line('kago_long_desc')."</label><br/>";
$data = array('name'=>'longdesc','id'=>'long','rows'=>10, 'cols'=>'80');
echo form_textarea($data) ."</p>\n";

?>
<a href="javascript:toggleEditor('long');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php 
echo "<p><label for='uimage'>".$this->lang->line('kago_select_img')."</label><br/>";
$data = array('name'=>'image','id'=>'uimage','size'=>80);
echo form_textarea($data) ."</p>\n";

echo "<p><label for='uthumb'>".$this->lang->line('kago_select_thumb')."</label><br/>";
$data = array('name'=>'thumbnail','id'=>'uthumb','size'=>80);
echo form_textarea($data) ."</p>\n";

echo "<p><label for='status'>".$this->lang->line('kago_status')."</label><br/>";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options) ."</p>\n";

echo "<p><label for='product_order'>".$this->lang->line('kago_slide_order')."</label><br/>";
$data = array('name'=>'slide_order','id'=>'product_order','size'=>11);
echo form_input($data) ."</p>\n";


echo form_submit('submit',$this->lang->line('kago_add_slide'));
echo form_close();


?>
</div>
 </div>

