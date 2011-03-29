<div id="pageleftcont">
<div id="create_edit">
<h2><?php echo $title;?></h2>
    <?php
 //   echo "lang_id is $lang_id and path is $path<br />";
//echo $checktrans;
//echo "Current config language is : ".$this->configlang;

?>
<?php

echo form_open_multipart('products/admin/langcreate');

echo "<p><label for='parent'>".$this->lang->line('kago_category')."</label><br/>\n";
echo form_dropdown('category_id',$categories) ."</p>\n";


echo "<p><label for='pname'>".$this->lang->line('kago_name')."</label><br/>";
echo "Original: ".$product['name'];
$data = array('name'=>'name','id'=>'pname','size'=>25);
echo form_input($data) ."</p>\n";

echo "<p><label for='short'>".$this->lang->line('kago_short_desc')."</label><br/>";
echo "Original: ".$product['shortdesc'];
$data = array('name'=>'shortdesc','id'=>'short','rows'=>5, 'cols'=>'80');
echo form_textarea($data) ."</p>\n";
?>
<a href="javascript:toggleEditor('short');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php
echo "<p><label for='long'>".$this->lang->line('kago_long_desc')."</label><br/>";
echo "Original: ".$product['longdesc'];
$data = array('name'=>'longdesc','id'=>'long','rows'=>10, 'cols'=>'80');
echo form_textarea($data) ."</p>\n";

?>
<a href="javascript:toggleEditor('long');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php
/*
echo "<p><label for='uimage'>Select Image</label><br/>";
$data = array('name'=>'image','id'=>'uimage','size'=>80);
echo form_textarea($data) ."</p>\n";
 * 
 */
echo form_hidden('image',$product['image']);
/*
echo "<p><label for='uthumb'>Select Thumbnail</label><br/>";
$data = array('name'=>'thumbnail','id'=>'uthumb','size'=>80);
echo form_textarea($data) ."</p>\n";
 */
echo form_hidden('thumbnail',$product['thumbnail']);
/*
echo "<p><label for='status'>Status</label><br/>";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options) ."</p>\n";
*/
echo form_hidden('status',$product['status']);
/*
echo "<p><label for='product_order'>Product Order</label><br/>";
$data = array('name'=>'product_order','id'=>'product_order','size'=>11);
echo form_input($data) ."</p>\n";
*/
echo form_hidden('product_order',$product['product_order']);
/*
echo "<p><label for='class'>Class</label><br/>";
$data = array('name'=>'class','id'=>'class','size'=>50);
echo form_input($data) ."</p>\n";

echo "<p><label for='group'>Grouping</label><br/>";
$data = array('name'=>'grouping','id'=>'group','size'=>50);
echo form_input($data) ."</p>\n";
*/

echo form_hidden('class',$product['class']);
echo form_hidden('grouping',$product['grouping']);

echo "<p><label for='price'>".$this->lang->line('kago_price')."</label><br/>";
$data = array('name'=>'price','id'=>'price','size'=>20);
echo form_input($data) ."</p>\n";
/*
echo "<p><label for='featured'>Featured?</label><br/>\n";
$options = array('none' => 'none', 'front' => 'Main frontpage', 'webshop' => 'Webshop frontpage');
echo form_dropdown('featured',$options) ."</p>\n";

echo "<p><label for='other_feature'>Other Feature?</label><br/>\n";
$options = array('none' => 'none', 'most sold' => 'Most sold', 'new product' => 'New Product');
echo form_dropdown('other_feature',$options) ."</p>\n";
*/
echo form_hidden('featured',$product['featured']);
echo form_hidden('other_feature',$product['other_feature']);
echo form_hidden('product_id',$product['id']);
echo form_hidden('lang_id',$selected_lang['id']);
echo form_submit('submit',$this->lang->line('kago_add_translation'));
echo form_close();

echo "<pre>languages";
print_r ($languages);
echo "</pre>";

echo "<pre>selected_lang";
print_r ($selected_lang);
echo "</pre>";

echo "<pre>product";
print_r ($product);
echo "</pre>";

echo "<pre>categories";
print_r ($categories);
echo "</pre>";
?>

</div>
 </div>
    <div id="pagerightcont">
  <?php $this->load->view($right);?>
    </div>
    <script>

    tinyMCE.init({
    	tinyMCE.execCommand('mceRemoveControl',false,'long');
    });


    </script>
