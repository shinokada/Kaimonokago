<h2><?php echo $title;?></h2>
<?php
echo form_open_multipart($module.'/admin/create')."\n";

echo "\n<table id='preference_form'><tr><td class='label'><label for='category'>".$this->lang->line('kago_category')."</label></td>\n";
echo "<td>";
echo form_dropdown('category_id',$categories);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='pname'>".$this->lang->line('kago_name')."</label></td>\n";
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

echo "<tr><td class='label'><label for='product_order'>".$this->lang->line('kago_order')."</label></td>\n";
$data = array('name'=>'product_order','id'=>'product_order','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='class'>".$this->lang->line('kago_class')."</label></td>\n";
$data = array('name'=>'class','id'=>'class','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='group'>".$this->lang->line('kago_grouping')."</label></td>\n";
$data = array('name'=>'grouping','id'=>'group','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='price'>".$this->lang->line('kago_price')."</label></td>\n";
$data = array('name'=>'price','id'=>'price','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='featured'>".$this->lang->line('kago_featured')."</label></td>\n";
$options = array('none' => 'none', 'webshop' => 'Webshop frontpage');// you can add more here as you wish
echo "<td>";
echo form_dropdown('featured',$options);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='other_feature'>".$this->lang->line('kago_other_feature')."</label></td>\n";
$options = array('none' => 'none', 'most sold' => 'Most sold', 'new product' => 'New Product');
echo "<td>";
echo form_dropdown('other_feature',$options);
echo "</td></tr></table>\n";

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
//echo form_submit('submit',$this->lang->line('kago_create_product'));
echo form_close();


?>
