<h2><?php echo $title;?></h2>

<?php
echo form_open('customer/admin/create');
echo "\n<table id='preference_form'><tr><td class='label'><label for='customer_first_name'>*".$this->lang->line('webshop_first_name')."</label></td>\n";
$data = array('name'=>'customer_first_name','id'=>'fname','class'=>'text','value'=>set_value('customer_first_name'));
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='customer_last_name'>".$this->lang->line('webshop_last_name')."</label></td>\n";
$data = array('name'=>'customer_last_name','id'=>'lname','class'=>'text', 'value'=>set_value('customer_last_name'));
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='phone_number'>".$this->lang->line('webshop_mobile_tel')."</label></td>\n";
$data = array('name'=>'phone_number','id'=>'phone','class'=>'text','value'=>set_value('phone_number'));
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='email'>*".$this->lang->line('webshop_email')."</label></td>\n";
$data = array('name'=>'email','id'=>'email','class'=>'text','value'=>set_value('email'));
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='password'>*".$this->lang->line('webshop_pass_word')."</label></td>\n";
echo "<td>";
echo '<input type="password" name="password" id="id_newpassword" value="" class="text" />';

?>

<script>
document.write('<div class="unmask"><input id="id_newpasswordunmask" value="1" type="checkbox" onclick="unmaskPassword(\'id_newpassword\')"/><label for="id_newpasswordunmask">Unmask<\/label><\/div>');
document.getElementById("id_newpassword").setAttribute("autocomplete", "off");
</script>

<?php
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='address'>".$this->lang->line('webshop_shipping_address')."</label></td>\n";
$data = array('name'=>'address','id'=>'address','class'=>'text','value'=>set_value('address'));
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='city'>".$this->lang->line('webshop_city')."</label></td>\n";
$data = array('name' => 'city', 'id' => 'city','class'=>'text','value'=>set_value('city'));
echo "<td>";
echo form_input($data);
echo "</td></tr>\n";

echo "<tr><td class='label'><label for='post_code'>".$this->lang->line('webshop_post_code')."</label></td>\n";
$data = array('name' => 'post_code', 'id' => 'post_code','class'=>'text','value'=>set_value('post_code'));
echo "<td>";
echo form_input($data);
echo "</td></tr>\n</table>\n";
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
//echo form_submit('submit','create customer');
echo form_close();


?>