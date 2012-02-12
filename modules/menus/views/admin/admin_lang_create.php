<h2><?php echo $title;?></h2>
<?php
// echo "Current config language is : ".$this->configlang;
// The following works, but not showing for other languages
// echo showtranslang($languages,$translanguages,$menu, $module);

?>
<?php

echo form_open('menus/admin/langcreate');

echo "\n<table id='preference_form'><tr><td class='label'><label for='menuname'>".$this->lang->line('kago_name')."</label></td>\n";
echo $this->lang->line('kago_original').$menu['name']."</td>";
$data = array('name'=>'name','id'=>'menuname','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='short'>".$this->lang->line('kago_short_desc')."</label><br />\n";
echo "Original: ".$menu['shortdesc']."</td>";
$data = array('name'=>'shortdesc','id'=>'short','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

// if $page_uri_id is 0, then they are language root, e.g. German, French etc
// so $page_uri_id and $parentid should be 0
if ($page_uri_id=='0'){
    echo form_hidden('page_uri_id','0');
    echo form_hidden('parentid','0');
}else{
    echo "<tr><td><label for='page_uri'>".$this->lang->line('kago_page_toshow')."</label></td>\n";
    echo "<td>";
    echo form_dropdown('page_uri_id',$pages)."</td></tr>";
    echo "</td>";

    echo "<tr><td><label for='parent'>".$this->lang->line('kago_parent_menu')."</label></td>";
    echo "<td>";
    echo form_dropdown('parentid',$menus);
    echo "</td></tr>";
}


echo "<tr><td><label for='order'>".$this->lang->line('kago_order')."</label></td>\n";
$data = array('name'=>'order', 'value' => $menu['order'], 'id'=>'order','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr></table>\n";
/*
echo "<h3>Page URI: ";
echo $menu['page_uri'];
echo "</h3>";
*/

echo form_hidden('status', $menu['status']);
//echo form_hidden('order', $menu['order']);
// menu_id is used to find translated languages in $data['translanguages'] =$this->MLangs->getTransLang($this->module,$menu_id);
echo form_hidden('menu_id', $menu['id']);
//echo form_hidden('parentid', $menu['parentid']);
echo form_hidden('lang_id', $lang_id);
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
//echo form_submit('submit',$this->lang->line('kago_add_trans'));
echo form_close();

echo "<pre>menu";
print_r ($menu);
echo "</pre>";

echo "<pre>languages";
print_r ($languages);
echo "</pre>";

echo "<pre>translanguages";
print_r ($translanguages);
echo "</pre>";

echo "<pre>selected_lang";
print_r ($selected_lang);
echo "</pre>";

?>
