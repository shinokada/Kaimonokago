<h2><?php echo $title;?></h2>
<p>The following products are about to be orphaned. They used to belong to the <b><?php echo $category['name'];?></b> category, but now they need to be reassigned.</p>

<ul>
<?php
foreach ($this->session->userdata('orphans') as $id => $name){
	echo "<li>$name</li>\n";
}

echo $categories[$category['id']];
echo $category['id'];
?>
</ul>

<?php
echo form_open('category/admin/reassign');
unset($categories[$category['id']]);
echo form_dropdown('categories',$categories);
echo form_hidden('id', $category['id'] );
echo form_submit('submit',$this->lang->line('kago_reassign'));
echo form_close();
?>