<div id="pageleftcont">
<div id="create_edit">
<h2><?php echo $title;?></h2>

<?php
echo form_open('menus/admin/create');
echo "\n<p><label for='menuname'>".$this->lang->line('kago_name')."</label><br/>\n";
$data = array('name'=>'name','id'=>'menuname','size'=>25);
echo form_input($data) ."</p>\n";

echo "<p><label for='short'>".$this->lang->line('kago_short_desc')."</label><br/>\n";
$data = array('name'=>'shortdesc','id'=>'short','size'=>40);
echo form_input($data) ."</p>\n";

echo "<p><label for='page_uri'>".$this->lang->line('kago_page_toshow')."</label><br/>\n";
echo form_dropdown('page_uri_id',$pages) ."</p>\n";

echo "<p><label for='status'>".$this->lang->line('kago_status')."</label><br/>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options) ."</p>\n";

echo "<p><label for='parent'>".$this->lang->line('kago_parent_menu')."</label><br/>\n";
echo form_dropdown('parentid',$menus) ."</p>\n";

echo "<p><label for='order'>".$this->lang->line('kago_order')."</label><br/>\n";
$data = array('name'=>'order','id'=>'order','size'=>10);
echo form_input($data) ."</p>\n";

echo form_hidden('menu_id','0');
echo form_hidden('lang_id','0');
echo form_submit('submit',$this->lang->line('kago_create_menu'));
echo form_close();


?>
</div>
</div>