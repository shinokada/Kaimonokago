<h2><?php echo $title;?></h2>
<p>The following products are about to be orphaned. They used to belong to the <b><?php echo $menu['name'];?></b> menu, but now they need to be reassigned.</p>

<ul>
<?php
foreach ($this->session->userdata('orphans') as $id => $name){
	echo "<li>".$this->lang->line('kago_id').": ".$id;
    echo $this->lang->line('kago_name').": $name</li>\n";
}
echo "<pre>".$this->lang->line('kago_menu');
 
 print_r ($menus);
echo "</pre>";
echo "<pre>menu";
 print_r ($menu);
echo "</pre>";
echo "</br >";
// echo $categories[$category['id']];
// echo $category['id'];
?>
</ul>

<?php
echo form_open('menus/admin/reassign');
//unset($menus[$menu['id']]);
echo form_dropdown('parentid',$menus);
//echo form_hidden('id', $menu['id'] );
echo form_submit('submit',$this->lang->line('kago_reassign'));
echo form_close();
?>