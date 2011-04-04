
<div id="pageleftcont">
<h2><?php echo $title;?></h2>
<div id="create_edit">
<?php
if($category['lang_id']==0){
    echo showtranslang($languages,$translanguages,$category, $module);
}

echo form_open('category/admin/edit');

//echo form_hidden('name', $category['name']);
/*
echo "<p><label for='update'>Update</label><br/>";
echo form_checkbox('update', 'update', TRUE);
*/
echo "<p><label for='catname'>".$this->lang->line('kago_name')."</label><br/>";
$data = array('name'=>'name','id'=>'catname','size'=>25,'value' => $category['name']);
echo form_input($data) ."</p>\n";
//echo "<h2>".$category['name']."</h2>";

echo "<p><label for='short'>".$this->lang->line('kago_short_desc')."</label><br/>";
$data = array('name'=>'shortdesc','id'=>'short','size'=>40, 'value' => $category['shortdesc']);
echo form_textarea($data) ."</p>";
?>
<a href="javascript:toggleEditor('short');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php 
echo "<p><label for='long'>".$this->lang->line('kago_long_desc')."</label><br/>";
$data = array('name'=>'longdesc','id'=>'long','rows'=>5, 'cols'=>'40', 'value' => $category['longdesc']);
echo form_textarea($data) ."</p>";
?>
<a href="javascript:toggleEditor('long');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php 
echo "<p><label for='status'>".$this->lang->line('kago_status')."</label><br/>";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options, $category['status']) ."</p>";

echo "<p><label for='parent'>".$this->lang->line('kago_parent')."</label><br/>";
echo form_dropdown('parentid',$categories,$category['parentid']) ."</p>";

echo form_hidden('id',$category['id']);
echo form_hidden('table_id',$category['table_id']);
echo form_submit('submit',$this->lang->line('kago_update'));
echo form_close();




?>
</div>
 </div>
    <div id="pagerightcont">
  <?php  $this->load->view($right);?>    
    </div>