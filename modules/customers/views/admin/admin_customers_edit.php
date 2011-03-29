<h2><?php echo $title;?></h2>

<?php
echo form_open('customers/admin/edit');
echo "<p><label for='customer_first_name'>Customer First Name</label><br/>";
$data = array('name'=>'customer_first_name','id'=>'fname','size'=>25, 'value'=>$customer['customer_first_name']);
echo form_input($data) ."</p>";

echo "<p><label for='customer_last_name'>Customer Last Name</label><br/>";
$data = array('name'=>'customer_last_name','id'=>'lname','size'=>25, 'value'=>$customer['customer_last_name']);
echo form_input($data) ."</p>";

echo "<p><label for='phone_number'>Phone Number</label><br/>";
$data = array('name'=>'phone_number','id'=>'phone','size'=>25, 'value'=>$customer['phone_number']);
echo form_input($data) ."</p>";

echo "<p><label for='email'>Email</label><br/>";
$data = array('name'=>'email','id'=>'email','size'=>50, 'value'=>$customer['email']);
echo form_input($data) ."</p>";

echo "<p>Password</p>";
echo '<input type="text" name="password" value="" size="50" />';

echo "<p>Password Confirm</p>";
echo '<input type="text" name="passconf" value="" size="50" />';

echo "<p><label for='address'>Shipping address</label><br/>";
$data = array('name'=>'address','id'=>'address','size'=>50, 'value'=>$customer['address']);
echo form_input($data) ."</p>";

echo "<p><label for='city'>City</label><br/>";
$data = array('name'=>'city','id'=>'city','size'=>50, 'value'=>$customer['city']);
echo form_input($data) ."</p>";

echo "<p><label for='post_code'>Post code</label><br/>";
$data = array('name'=>'post_code','id'=>'post','size'=>10, 'value'=>$customer['post_code']);
echo form_input($data) ."</p>";

echo form_hidden('customer_id',$customer['customer_id']);
echo form_submit('submit','update customer');
echo form_close();


?>