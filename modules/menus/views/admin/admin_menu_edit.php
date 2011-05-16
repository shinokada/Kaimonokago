<h2><?php echo $title;?></h2>

    <?php
  
//print_r ($translanguages);

// this can be used mytools_helper showtranslang(), but anchor part must be changed or use if statement
// show this only for english
if($menu['lang_id']==0 AND $multilang){
   // echo "Current config language is : ". ucfirst($this->configlang) ;
    echo showtranslang($languages,$translanguages,$menu, $module);
}


?>
<?php
echo form_open('menus/admin/edit');
echo "\n<table id='preference_form'><tr><td class='label'><label for='menuname'>".$this->lang->line('kago_name')."</label></td>\n";
$data = array('name'=>'name','id'=>'menuname', 'value' => $menu['name'],'class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='short'>".$this->lang->line('kago_short_desc')."</label></td>\n";
$data = array('name'=>'shortdesc','id'=>'short', 'value' => $menu['shortdesc'],'class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='page_uri_id'>".$this->lang->line('kago_page_toshow')."</label></td>\n";
echo "<td>";
echo form_dropdown('page_uri_id',$pages, $menu['page_uri_id']) ;
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='status'>".$this->lang->line('kago_status')."</label></td>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo "<td>";
echo form_dropdown('status',$options, $menu['status']);
echo "</td></tr>\n";

if($page_uri_id =='0'){
   // echo form_hidden('page_uri_id','0');
    echo form_hidden('parentid','0');
}else{
    echo "<tr><td class='label'><label for='parent'>".$this->lang->line('kago_parent_menu')."</label></td>\n";
    echo "<td>";
    echo form_dropdown('parentid',$menus, $menu['parentid']);
    echo "</td></tr>\n";
}

echo "<tr><td class='label'><label for='order'>".$this->lang->line('kago_order')."</label></td>\n";
$data = array('name'=>'order', 'value' => $menu['order'], 'id'=>'order','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n</table>\n";



echo form_hidden('menu_id',$menu['menu_id']);

//}  else {
echo form_hidden('status',$menu['status']);
   // echo form_hidden('parentid',$menu['parentid']);
//    echo form_hidden('order',$menu['order']);
    
//}
echo form_hidden('lang_id',$menu['lang_id']);
echo form_hidden('id',$menu['id']);
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

//echo form_submit('submit',$this->lang->line('kago_update_menu'));
echo form_close();

?>
