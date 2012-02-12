
<div id="pageleftcont">
<h2><?php echo $title;?></h2>
<div id="create_edit">
<?php
/*
if($info['lang_id']==0){
    echo showtranslang($languages,$translanguages,$info, $module);
}
 * 
 */

echo form_open($module.'/admin/edit');

//echo form_hidden('name', $info['name']);
/*
echo "<p><label for='update'>Update</label><br/>";
echo form_checkbox('update', 'update', TRUE);
*/
echo "<p><label for='langname'>".$this->lang->line('kago_name')."</label><br/>";
$data = array('name'=>'langname','id'=>'langname','size'=>25,'value' => ucfirst($info['langname']));
echo form_input($data) ."</p>\n";
//echo "<h2>".$info['name']."</h2>";

echo "<p><label for='status'>".$this->lang->line('kago_status')."</label><br/>";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options, $info['status']) ."</p>";


echo form_hidden('id',$info['id']);
echo form_submit('submit',$this->lang->line('kago_update'));
echo form_close();




echo "<pre>info";
print_r ($info);
echo "</pre>";
echo "<pre>module";
print_r ($module);
echo "</pre>";



?>
</div>
 </div>
   