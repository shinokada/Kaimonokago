<h2><?php echo $title;?></h2>
<div class="buttons">
	<a href="<?php print  site_url('products/admin/create')?>">
    <?php print $this->bep_assets->icon('add');?>
    <?php print $this->lang->line('kago_create_product'); ?>
    </a>
</div>
<div class="clearboth">&nbsp;</div>

<?php
// get the module name. We use this in the link. Then it will be used in kaimonokago controller to redirect to the module
$module=$this->uri->segment(1);

if (count($products)){
	echo form_open("products/admin/batchmode");
        /*
	echo "<p>Category: ". form_dropdown('category_id',$categories);
	echo "&nbsp;";
	$data = array('name'=>'grouping','size'=>'10');
	echo "Grouping: ". form_input($data);
	echo form_submit("submit","batch update");
	echo "</p>";*/
	echo '<table id="tablesorter_product1" class="tablesorter" border="1" cellspacing="0" cellpadding="3" width="100%">';
	echo "<thead>\n<tr valign='top'>\n";
	echo "<th>".$this->lang->line('kago_productid')."</th>\n<th>".$this->lang->line('kago_name').
            "</th><th>".$this->lang->line('kago_class')."</th><th>".$this->lang->line('kago_grouping')."</th><th>".
            $this->lang->line('kago_status')."</th><th>".$this->lang->line('kago_catname').
            "</th><th>".$this->lang->line('kago_featured')."</th><th>".$this->lang->line('kago_price').
            "</th><th>".$this->lang->line('kago_lang')."</th><th>".$this->lang->line('kago_product_id').
            "</th><th>".$this->lang->line('kago_actions')."</th>\n";
	echo "</tr>\n</thead>\n<tbody>\n";
	foreach ($products as $key => $list){
		echo "<tr ";
        ($list['lang_id']>0)? $class="dentme" : $class = '';
		echo "class = \"".$class. "\" valign='top'>\n";
       // echo "<td align='center'>".form_checkbox('p_id[]',$list['id'],FALSE)."</td>";
		echo "<td align='center'>".$list['id']."</td>\n";
		echo "<td align='center'>";
        //.$list['name'].
        echo anchor('products/admin/edit/'.$list['id'],$list['name']);
        echo "</td>\n";
		echo "<td align='center'>".$list['class']."</td>\n";
		echo "<td align='center'>".$list['grouping']."</td>\n";
		
		echo "<td align='center'>";
                 $active_icon = ($list['status']=='active'?'tick':'cross');
		echo anchor("kaimonokago/admin/changeStatus/$module/".$list['id'],$this->bep_assets->icon($active_icon), array('class' => $list['status']));
		echo "</td>\n";
		
		// echo "<td align='center'>".$list['category_id']."</td>\n";
		echo "<td align='center'>".$list['CatName']."</td>\n";
		echo "<td align='center'>".$list['featured']."</td>\n";
		echo "<td align='center'>".$list['price']."</td>\n";
        if($list['langname']){
            $langname = ucfirst($list['langname']);
        }else{
            $langname = 'English';
        }
        echo "<td align='center'>$langname</td>\n";
        //echo "<td align='center'>".$list['lang_id']."</td>\n";
        echo "<td align='center'>".$list['table_id']."</td>\n";
		echo "<td align='center'>";
		echo anchor('products/admin/edit/'.$list['id'],$this->bep_assets->icon('pencil'));
        if ($list['status']=='inactive'){
		//echo " | ";
		echo anchor("kaimonokago/admin/delete/$module/".$list['id'],$this->bep_assets->icon('delete'),array("onclick"=>"return confirmSubmit('".$list['name']."')"));
        }
		echo "</td>\n";
		echo "</tr>\n";
	}
	echo "</tbody></table>";
	echo form_close();
}
/*
echo "<pre>products";
print_r ($products);
echo "</pre>";
*/
?>