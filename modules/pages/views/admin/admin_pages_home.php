<?php print displayStatus();?>
<h2><?php echo $title;?></h2>
<p>
<?php
echo anchor("pages/admin/create", $this->lang->line('kago_create_page'));
?>
</p>
<?php
// get the module name. We use this in the link. Then it will be used in kaimonokago controller to redirect to the module
$module=$this->uri->segment(1);
/*
 This is how CI display flash data. but we don't use it. 

if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}
*/
if (count($pages)){
	echo "<table id='tablesorter1' class='tablesorter' border='1' cellspacing='0' cellpadding='3' width='100%'>\n";
	echo "<thead>\n<tr valign='top'>\n";
	echo "<th>".$this->lang->line('kago_id')."</th>\n<th>".$this->lang->line('kago_name')."</th><th>".
            $this->lang->line('kago_full_path')."</th><th>".$this->lang->line('kago_status').
            "</th><th>".$this->lang->line('kago_lang')."</th><th>".$this->lang->line('kago_actions')."</th>\n";
	echo "</tr>\n</thead>\n<tbody>\n";
	foreach ($pages as $key => $list){
		echo "<tr ";
        if($list['langname']){
            echo "class=\"dentme\"";
        }
        echo "valign='top'>\n";
		echo "<td align='center'>".$list['id']."</td>\n";
		echo "<td>";
        echo anchor('pages/admin/edit/'.$list['id']."/".$list['path'],$list['name']);
        echo "</td>\n";
		echo "<td>";
        if(!$list['langname']){
   		//if (!preg_match("/\.html$/",$list['path'])){
  		//	$list['path'] .= ".html";
  		//}
        // shows path only if it is english which does not have langname
		echo "/". $list['path'];
        }
		/*
		if ($list['category_id'] == 0){
			echo "/". $list['path'];
		}else{
			echo "/". $cats[$list['category_id']]. "/". $list['path'];
		}
		*/
		echo "</td>";
		echo "<td align='center'>";
		echo anchor("kaimonokago/admin/changeStatus/$module/".$list['id'],$list['status'], array('class' => $list['status']));
		echo "</td>\n";
        echo "<td align='center'>";
        if($list['langname']){
            echo ucwords($list['langname']);
        }  else {
            echo "English";
        }


        echo "</td>\n";
		echo "<td align='center'>";
		echo anchor('pages/admin/edit/'.$list['id']."/".$list['path'],$this->lang->line('kago_edit'));

         if ($list['status']=='inactive'){
		echo " | ";
		echo anchor("kaimonokago/admin/delete/$module/".$list['id'],$this->lang->line('kago_delete'), array("onclick"=>"return confirmSubmit('".$list['name']."')"));
         }

        echo "</td>\n";
		echo "</tr>\n";
	}
	echo "</tbody>\n</table>";
}


echo "<pre>";
print_r ($pages);
echo "</pre>";

?>