<h2><?php echo $title;?></h2>

<?php
echo form_open('customers/admin/create');
echo "<p><label for='customer_first_name'>Customer First Name</label><br/>";
$data = array('name'=>'customer_first_name','id'=>'fname','size'=>25);
echo form_input($data) ."</p>\n";

echo "<p><label for='customer_last_name'>Customer Last Name</label><br/>";
$data = array('name'=>'customer_last_name','id'=>'lname','size'=>25);
echo form_input($data) ."</p>\n";

echo "<p><label for='phone_number'>Phone Number</label><br/>";
$data = array('name'=>'phone_number','id'=>'phone','size'=>15);
echo form_input($data) ."</p>\n";

echo "<p><label for='email'>Email</label><br/>";
$data = array('name'=>'email','id'=>'email','size'=>50);
echo form_input($data) ."</p>\n";

echo "<p>Password</p>";
echo '<input type="text" name="password" value="" size="50" />';

echo "<p>Password Confirm</p>";
echo '<input type="text" name="passconf" value="" size="50" />';

echo "<p><label for='address'>Address</label><br/>";
$data = array('name'=>'address','id'=>'address','size'=>50);
echo form_input($data) ."</p>\n";

echo "<p><label for='city'>City</label><br/>";
$data = array('name' => 'city', 'id' => 'city', 'size'=>25);
echo form_input($data) ."</p>\n";

echo "<p><label for='post_code'>Post code</label><br/>";
$data = array('name' => 'post_code', 'id' => 'post_code', 'size'=>10);
echo form_input($data) ."</p>\n";

echo form_submit('submit','create customer');
echo form_close();


?>