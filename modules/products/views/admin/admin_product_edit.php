<?php print displayStatus();?>
<div id="pageleftcont">
<div id="create_edit">
<h2><?php echo $title;?></h2>
<?php

if($product['lang_id']=='0'){
    echo showtranslang($languages,$translanguages,$product, $module);
}

echo form_open_multipart('products/admin/edit/'.$product['id']);

echo "\n<p><label for='parent'>".$this->lang->line('kago_category')."</label><br/>\n";
echo form_dropdown('category_id',$categories,$product['category_id']) ."</p>\n";

echo "<p><label for='pname'>".$this->lang->line('kago_name')."(This will be used in alt)</label><br/>\n";
$data = array('name'=>'name','id'=>'pname','size'=>25, 'value' => $product['name']);
echo form_input($data) ."</p>\n";

echo "<p><label for='short'>".$this->lang->line('kago_short_desc')."</label><br/>\n";
$data = array('name'=>'shortdesc','id'=>'short','rows'=>5, 'cols'=>'80', 'value' => $product['shortdesc']);
echo form_textarea($data) ."</p>\n";
?>
<a href="javascript:toggleEditor('short');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php 
echo "<p><label for='long'>".$this->lang->line('kago_long_desc')."</label><br/>\n";
$data = array('name'=>'longdesc','id'=>'long','rows'=>10, 'cols'=>'80', 'value' => $product['longdesc']);
echo form_textarea($data) ."</p>\n";
?>
<a href="javascript:toggleEditor('long');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php 
echo "<p><label for='uimage'>".$this->lang->line('kago_select_img')."</label><br/>\n";
$data = array('name'=>'image','id'=>'uimage','size'=>100, 'value' => $product['image']);
echo form_textarea($data) . "</p>\n";

echo "<p><label for='uthumb'>".$this->lang->line('kago_select_thumb')."</label><br/>\n";
$data = array('name'=>'thumbnail','id'=>'uthumb','size'=>100, 'value' => $product['thumbnail']);
echo form_textarea($data) ."</p>\n";

echo "<p><label for='status'>".$this->lang->line('kago_status')."</label><br/>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options, $product['status']) ."</p>\n";

echo "<p><label for='product_order'>".$this->lang->line('kago_order')."</label><br/>";
$data = array('name'=>'product_order','id'=>'product_order','size'=>11);
echo form_input($data) ."</p>\n";

echo "<p><label for='class'>".$this->lang->line('kago_class')."(This will be used for html class and filtable.)</label><br/>";
$data = array('name'=>'class','id'=>'class','size'=>50, 'value' => $product['class']);
echo form_input($data) ."</p>\n";

echo "<p><label for='group'>".$this->lang->line('kago_grouping')."(This will be used for light box grouping and added to rel.)</label><br/>\n";
$data = array('name'=>'grouping','id'=>'group','size'=>50, 'value' => $product['grouping']);
echo form_input($data) ."</p>";

echo "<p><label for='price'>".$this->lang->line('kago_price')."</label><br/>\n";
$data = array('name'=>'price','id'=>'price','size'=>20, 'value' => $product['price']);
echo form_input($data) ."</p>\n";

echo "<p><label for='featured'>".$this->lang->line('kago_featured')."</label><br/>\n";
$options = array('none' => 'none', 'front' => 'Main frontpage', 'webshop' => 'Webshop frontpage');
echo form_dropdown('featured',$options, $product['featured']) ."</p>\n";

echo "<p><label for='other_feature'>".$this->lang->line('kago_other_feature')."</label><br/>\n";
$options = array('none' => 'none', 'most sold' => 'Most sold', 'new product' => 'New Product');
echo form_dropdown('other_feature',$options, $product['other_feature']) ."</p>\n";

echo form_hidden('id',$product['id']);
echo form_submit('submit',$this->lang->line('kago_update'));
echo form_close();

echo "<pre>languages";
print_r($languages);
echo "</pre>";

echo "<pre>translanguages";
print_r($translanguages);
echo "</pre>";

echo "<pre>product";
print_r($product);
echo "</pre>";

echo "<pre>categories";
print_r($categories);
echo "</pre>";




?>
</div>
 </div>
    <div id="pagerightcont">
  <?php $this->load->view($right);?>    
    </div>