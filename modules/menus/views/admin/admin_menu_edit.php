<h2><?php echo $title;?></h2>
    <?php
  
//print_r ($translanguages);

// this can be used mytools_helper showtranslang(), but anchor part must be changed or use if statement
// show this only for english
if($menu['lang_id']==0){
   // echo "Current config language is : ". ucfirst($this->configlang) ;
    echo showtranslang($languages,$translanguages,$menu, $module);
}


?>
<?php
echo form_open('menus/admin/edit');
echo "\n<p><label for='menuname'>".$this->lang->line('kago_name')."</label><br/>\n";
$data = array('name'=>'name','id'=>'menuname','size'=>25, 'value' => $menu['name']);
echo form_input($data) ."</p>\n";

echo "<p><label for='short'>".$this->lang->line('kago_short_desc')."</label><br/>\n";
$data = array('name'=>'shortdesc','id'=>'short','size'=>40, 'value' => $menu['shortdesc']);
echo form_input($data) ."</p>\n";

echo "<p><label for='page_uri'>".$this->lang->line('kago_page_toshow')."</label><br/>\n";
echo form_dropdown('page_uri_id',$pages, $menu['page_uri_id']) ."</p>\n";

if($page_uri_id =='0'){
   // echo form_hidden('page_uri_id','0');
    echo form_hidden('parentid','0');
}else{
    echo "<p><label for='parent'>".$this->lang->line('kago_parent_menu')."</label><br/>\n";
    echo form_dropdown('parentid',$menus, $menu['parentid']) ."</p>\n";
}

echo "<p><label for='order'>".$this->lang->line('kago_order')."</label><br/>\n";
$data = array('name'=>'order', 'value' => $menu['order'], 'id'=>'order','size'=>10);
echo form_input($data) ."</p>\n";

//if($menu['lang_id']==0){
    echo "<p><label for='status'>".$this->lang->line('kago_status')."</label><br/>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options, $menu['status']) ."</p>\n";
echo form_hidden('menu_id',$menu['menu_id']);

//}  else {
    echo form_hidden('status',$menu['status']);
   // echo form_hidden('parentid',$menu['parentid']);
//    echo form_hidden('order',$menu['order']);
    
//}

echo form_hidden('id',$menu['id']);
echo form_submit('submit',$this->lang->line('kago_update_menu'));
echo form_close();

echo "<pre>";
echo "menu";
var_dump($menu);
echo "menus";
var_dump($menus);
echo "</pre>";
echo "<pre>languages";
print_r ($languages);
echo "</pre>";
echo "<pre>translanguages";
print_r ($translanguages);
echo "</pre>";
?>