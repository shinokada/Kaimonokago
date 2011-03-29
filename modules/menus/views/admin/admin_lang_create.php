<h2><?php echo $title;?></h2>
<?php
// echo "Current config language is : ".$this->configlang;
// The following works, but not showing for other languages
// echo showtranslang($languages,$translanguages,$menu, $module);

?>
<?php

echo form_open('menus/admin/langcreate');

echo "\n<p><label for='menuname'>".$this->lang->line('kago_name')."</label>\n";
echo $this->lang->line('kago_original').$menu['name']."</p><p>";
$data = array('name'=>'name','id'=>'menuname','size'=>25);
echo form_input($data) ."</p>\n";

echo "<p><label for='short'>".$this->lang->line('kago_short_desc')."</label>\n";
echo "Original: ".$menu['shortdesc']."</p><p>";
$data = array('name'=>'shortdesc','id'=>'short','size'=>40);
echo form_input($data) ."</p>\n";

// if $page_uri_id is 0, then they are language root, e.g. German, French etc
// so $page_uri_id and $parentid should be 0
if ($page_uri_id=='0'){
    echo form_hidden('page_uri_id','0');
    echo form_hidden('parentid','0');
}else{
    echo "<p><label for='page_uri'>".$this->lang->line('kago_page_toshow')."</label><br/>\n";
    echo form_dropdown('page_uri_id',$pages) ."</p>\n";

    echo "<p><label for='parent'>".$this->lang->line('kago_parent_menu')."</label><br/>\n";
    echo form_dropdown('parentid',$menus) ."</p>\n";
}


echo "<p><label for='order'>".$this->lang->line('kago_order')."</label><br/>\n";
$data = array('name'=>'order', 'value' => $menu['order'], 'id'=>'order','size'=>10);
echo form_input($data) ."</p>\n";
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
echo form_submit('submit',$this->lang->line('kago_add_trans'));
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
