<?php
if ($this->session->flashdata('msg')){ 
	echo "<div class='status_box'>";
	echo $this->session->flashdata('msg');
	echo "</div>";
}
?>
<h1>
<?php
echo lang('orders_thank_you');
?>
</h1>