<?php print displayStatus();?>
<div id="pageleftcont">
<div id="create_edit">
<h2><?php echo $title;?></h2>
    <?php
if($pagecontent['lang_id']==0){
    //echo "Current config language is : ".$this->configlang;
    echo showtranslang($languages,$translanguages,$pagecontent, $module);
}

echo form_open('pages/admin/edit');

echo "<p><label for='pname'>".$this->lang->line('kago_name')."</label><br/>";
$data = array('name'=>'name','id'=>'pname','size'=>25, 'value' => $pagecontent['name']);
echo form_input($data) ."</p>\n";

echo "<p><label for='short'>".$this->lang->line('kago_keyword')."</label><br/>";
$data = array('name'=>'keywords','id'=>'short','size'=>40, 'value' => $pagecontent['keywords']);
echo form_input($data) ."</p>\n";

echo "<p><label for='desc'>".$this->lang->line('kago_desc')."</label><br/>";
$data = array('name'=>'description','id'=>'desc','size'=>40, 'value' => $pagecontent['description']);
echo form_input($data) ."</p>\n";


if($pagecontent['lang_id']==0){
    echo "<p><label for='fpath'>".$this->lang->line('kago_path_furl')."</label>";
    $data = array('name'=>'path','id'=>'fpath','size'=>50, 'value' => $pagecontent['path']);
    echo form_input($data) ."</p>\n";
}else{
    echo "<h3>".$this->lang->line('kago_path_furl'). $pagecontent['path']."</h3>";
    echo form_hidden('path', $pagecontent['path']);
  
}


echo "<p><label for='long'>".$this->lang->line('kago_content')."</label><br/>";
$data = array('name'=>'content','id'=>'long','rows'=>5, 'cols'=>'40', 'value' => $pagecontent['content']);
echo form_textarea($data) ."</p>\n";
?>
<a href="javascript:toggleEditor('long');"><?php echo $this->lang->line('kago_add_remove') ;?></a><br /><br />
<?php
echo "<p><label for='status'>".$this->lang->line('kago_status')."</label><br/>";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options,$pagecontent['status']) ."</p>\n";

echo form_hidden('lang_id', $pagecontent['lang_id']);
echo form_hidden('id',$pagecontent['id']);
echo form_submit('submit',$this->lang->line('kago_update'));
echo form_close();

echo "<pre>";
print_r ($pagecontent);
echo "</pre>";

echo "<pre>translanguages";
print_r ($translanguages);
echo "</pre>";
?>
</div>
</div>