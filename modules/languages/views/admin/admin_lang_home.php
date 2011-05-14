<?php print displayStatus();?>
<?php
// get the module name. We use this in the link. Then it will be used in kaimonokago controller to redirect to the module
$module=$this->uri->segment(1);
echo "<h2>$title</h2>";

// show session lang, if there is no session lang then it is english

echo "<h3>Default Language</h3>";
echo "<h4>";
// echo the default
echo ucwords($lang);
echo "</h4>";

// list all the languages
echo "<h3>Language List</h3>";
if (is_array($langs)){
    echo "<table id='langtable' class='langtable' border='1' cellspacing='0' cellpadding='3' width='100%'>\n";
    echo "<thead>\n<tr valign='top'>\n";
    echo "<th>ID</th>\n<th>Name</th><th>Status</th><th>Actions</th>\n";
    echo "</tr>\n</thead>\n<tbody>\n";
    foreach ($langs as $key => $list){
        echo "<tr valign='top'>\n";
        echo "<td align='center'>".$list['id']."</td>\n";
        echo "<td>".ucwords($list['langname'])."</td>\n";

        echo "<td align='center'>";
        // don't forget to add $module=$this->uri->segment(1); at the top of this page
                $active_icon = ($list['status']=='active'?'tick':'cross');
		echo anchor("kaimonokago/admin/changeStatus/$module/".$list['id'],$this->bep_assets->icon($active_icon), array('class' => $list['status']));
		echo "</td>\n";

        echo "<td align='center'>";
        echo anchor('languages/admin/edit/'.$list['id'],$this->bep_assets->icon('pencil'));
        if ($list['status']=='inactive'){
            
            //echo " | ";
            echo anchor("kaimonokago/admin/delete/$module/". $list["id"],$this->bep_assets->icon('delete'), array("onclick"=>"return confirmSubmit('".$list['langname']."')"));
         }


        echo "</td>\n";
        echo "</tr>\n";
    }
    echo "</tbody>\n</table>";
}  else {
    echo "<br /><h3>\n";
    echo $langs;
    echo "</h3>\n";
}



// Add language 
 // form to create new
echo "<h3>Add Language</h3>";
echo form_open('languages/admin/index/');

echo "\n<table id='preference_form'><tr><td class='label'><label for='langname'>*".$this->lang->line('kago_language_name')."</label></td>\n";
$data = array('name'=>'langname','id'=>'langname','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='status'>".$this->lang->line('kago_status')."</label></td>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo "<td>";
echo form_dropdown('status',$options);
echo "</td></tr></table>\n";
?>
<div class="buttons">
	<button type="submit" class="positive" name="submit" value="submit">
    <?php print $this->bep_assets->icon('disk');?>
    <?php print $this->lang->line('general_save');?>
    </button>


</div>
<?php
echo form_close();
?>