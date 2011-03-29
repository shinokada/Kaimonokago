<div id="pageleftcont">
<div id="create_edit">
<h2><?php echo $title;?></h2>
<?php
echo form_open_multipart('products/admin/create')."\n";

echo "<p><label for='parent'>".$this->lang->line('kago_category')."</label><br/>\n";
echo form_dropdown('category_id',$categories) ."</p>\n";


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

echo "<p><label for='product_order'>".$this->lang->line('kago_order')."</label><br/>";
$data = array('name'=>'product_order','id'=>'product_order','size'=>11);
echo form_input($data) ."</p>\n";

echo "<p><label for='class'>".$this->lang->line('kago_class')."</label><br/>";
$data = array('name'=>'class','id'=>'class','size'=>50);
echo form_input($data) ."</p>\n";

echo "<p><label for='group'>".$this->lang->line('kago_grouping')."</label><br/>";
$data = array('name'=>'grouping','id'=>'group','size'=>50);
echo form_input($data) ."</p>\n";

echo "<p><label for='price'>".$this->lang->line('kago_price')."</label><br/>";
$data = array('name'=>'price','id'=>'price','size'=>20);
echo form_input($data) ."</p>\n";

echo "<p><label for='featured'>".$this->lang->line('kago_featured')."</label><br/>\n";
$options = array('none' => 'none', 'front' => 'Main frontpage', 'webshop' => 'Webshop frontpage');
echo form_dropdown('featured',$options) ."</p>\n";

echo "<p><label for='other_feature'>".$this->lang->line('kago_other_feature')."</label><br/>\n";
$options = array('none' => 'none', 'most sold' => 'Most sold', 'new product' => 'New Product');
echo form_dropdown('other_feature',$options) ."</p>\n";

echo form_hidden('lang_id', '0');
echo form_hidden('product_id', '0');
echo form_submit('submit',$this->lang->line('kago_create_product'));
echo form_close();


?>
</div>
 </div>
    <div id="pagerightcont">
  <?php $this->load->view($right);?>    
    </div>
<!--
    <script>
    tinyMCE.init({
    	tinyMCE.execCommand('mceRemoveControl',false,'long');
    });
    </script>
-->