<h2><?php echo $title;?></h2>

<?php
echo form_open('menus/admin/create');
echo "\n<table id='preference_form'><tr><td class='label'><label for='menuname'>".$this->lang->line('kago_name')."</label></td>\n";
$data = array('name'=>'name','id'=>'menuname','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='short'>".$this->lang->line('kago_short_desc')."</label></td>\n";
$data = array('name'=>'shortdesc','id'=>'short','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='page_uri_id'>".$this->lang->line('kago_page_toshow')."</label></td>\n";
echo "<td>";
echo form_dropdown('page_uri_id',$pages);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='status'>".$this->lang->line('kago_status')."</label></td>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo "<td>";
echo form_dropdown('status',$options);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='parent'>".$this->lang->line('kago_parent_menu')."</label></td>\n";
echo "<td>";
echo form_dropdown('parentid',$menus) ;
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='order'>".$this->lang->line('kago_order')."</label></td>\n";
$data = array('name'=>'order','id'=>'order','class'=>'text');
echo "<td>";
echo form_input($data);
echo "</td></tr>\n</table>\n";

echo form_hidden('menu_id','0');
echo form_hidden('lang_id','0');
?>
<div class="buttons">
	<button type="submit" class="positive" name="submit" value="submit">
    <?php print $this->bep_assets->icon('disk');?>
    <?php print $this->lang->line('general_save');?>
    </button>

    <a href="<?php print site_url($cancel_link);?>" class="negative">
    <?php print $this->bep_assets->icon('cross');?>
    <?php print $this->lang->line('general_cancel');?>
    </a>
</div>
<?php
//echo form_submit('submit',$this->lang->line('kago_create_menu'));
echo form_close();


?>