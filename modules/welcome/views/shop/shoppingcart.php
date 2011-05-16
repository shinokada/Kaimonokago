<h1><?php echo lang('general_shopping_cart'); ?></h1>
<div id='pleft'>
<?php
/*
if ($this->session->flashdata('msg')){
	echo "<div class='status_box'>";
	echo $this->session->flashdata('msg');
	echo "</div>";
}*/
?>
<?php echo form_open($module.'/checkout'); ?>
<table border='1' cellspacing='0' cellpadding='5' width='90%'>
<?php
if(isset($_SESSION['totalprice'])){
	$data['totalprice'] = $_SESSION['totalprice'];
	}

if (isset($_SESSION['cart'])){
	foreach ($_SESSION['cart'] as $PID => $row){	
		$data = array(	
				'name' => "li_id[$PID]", 
				'value'=>$row['count'], 
				'id' => "li_id_$PID", 
				'class' => 'process',
				'size' => 5
		);
		
		echo "<tr valign='top'>\n";
		echo "<td>". form_input($data)."</td>\n";
		echo "<td id='li_name_".$PID."'>". $row['name']."</td>\n"; 
		echo "<td id='li_price_".$PID."'>".lang('webshop_currency_symbol'). $row['price']."</td>\n";
		echo "<td id='li_total_".$PID."'>".lang('webshop_currency_symbol').number_format($row['price'] * $row['count'], 2,'.',',')."</td>\n";
		echo "<td><input type='button' name='delete' value='".lang('webshop_delete')."' onclick='jsRemoveProduct($PID)'></td>\n";
		echo "</tr>\n";
	}
	$TOTALPRICE = $_SESSION['totalprice'];
	$TOTALPRICE = number_format($TOTALPRICE,2,'.',',');
	$total_data = array('name' => 'total', 'id'=>'total', 'value' => $TOTALPRICE);
	echo "<tr valign='top'>\n";
	echo "<td colspan='3'>".lang('orders_total_price')."</td>\n";
	echo "<td colspan='2'>".lang('webshop_currency_symbol')."$TOTALPRICE ".form_hidden($total_data)."</td>\n";
	
	echo "</tr>\n";

	echo "<tr valign='top'>\n";
	echo "<td colspan='3'>&nbsp;</td>\n";
	echo "<td colspan='2'><input type='button' name='update' value='".lang('webshop_update')."' onclick='jsUpdateCart()'/></td>\n";
	echo "</tr>\n";	
	
	echo "<tr valign='top'>\n";
	echo "<td colspan='3'>&nbsp;</td>\n";
	$data = array(
    'name'        => 'submit',
    'value'       => lang('webshop_checkout'),
    );
	echo "<td colspan='2'>".form_submit($data)."</td>\n";
	echo "</tr>\n";	
}else{
	//just in case!
   // echo "<tr><td id='tdmes'>" . lang('webshop_no_items_to_show') . "</td></tr>\n";
	echo "<tr><td></td></tr>\n";
}//end outer if count
?>
</table>
<?php echo form_close(); ?>
<br />
<?php
	if($shippingprice>0){
		echo "<div class='status_box'><h2>";
	echo lang('webshop_shipping_charge');
	if (isset($shippingprice)){
	echo " ". lang('webshop_currency_symbol')."$shippingprice";
	}else{
		echo "0 ". lang('webshop_currency');
	}
	echo " " . lang('webshop_will_be_added');
	echo "</h2></div>";
	}
	?>

<div id='ajax_msg'></div>
</div>

