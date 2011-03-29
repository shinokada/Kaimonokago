   <div class="gallerimain">
      <h1><?php echo $title;?></h1>   
      <br />
<?php 
	if($this->data['customer_status']==1){
		echo "<h2>".lang('customer_login_enjoy_shopping')."</h2>";
		echo "<br /><h2>".anchor( $module.'/checkout', lang('general_check_out') )."</h2><br />" ;
		
	}else{
		echo "<h2>".lang('customer_login_plz_login')."</h2><br />";
	}
?>

<?php
	if ($this->session->flashdata('msg')){ 
		echo "<div class='status_box'>";
		echo $this->session->flashdata('msg');
		echo "</div>";
	}
?>

<?php
	$udata = array('name'=>'email','id'=>'email','size'=>30);
	$pdata = array('name'=>'password','id'=>'password','size'=>16);
	
	echo form_open($module."/login");
	echo "<p><label for='email'>". lang('orders_email'). "</label><br/>";
	echo form_input($udata) . "</p>";
	echo "<p><label for='password'>Password</label><br/>";
	echo form_password($pdata) . "</p>";
	echo form_submit('submit','login');
	echo form_close();
?>
</div>