 	<div class="gallerimain">
    	<h1><?php echo $title; ?></h1><br />
	<?php print displayStatus();?>
		<h2><?php echo $this->lang->line('webshop_regist_plz_here'); ?></h2><br />
		<h2><?php echo sprintf( $this->lang->line('genral_login_msg'), anchor( $module.'/login', $this->lang->line('genral_login') ) );?></h2>
		<br />
		
		<?php
		if ($this->session->flashdata('msg')|| $this->session->flashdata('error')){ 
			echo "<div class='status_box'>";
			echo $this->session->flashdata('msg');
			echo $this->session->flashdata('error');
			echo "</div>";
		}
		?>
		<?php echo validation_errors('<div class="message error">','</div>'); ?>
		
		<?php echo form_open($module."/registration",array('class' => 'expose')); ?>

		<h3>*<?php echo $this->lang->line('webshop_email'); ?></h3>
		<input type="text" name="email" value="<?php echo set_value('email'); ?>" size="40" />
		
		<h3>*<?php echo $this->lang->line('webshop_email_confirm'); ?></h3>
		<input type="text" name="emailconf" value="<?php echo set_value('emailconf'); ?>" size="40" />
		
		<h3>*<?php echo $this->lang->line('webshop_pass_word'); ?></h3>
		<input type="password" name="password" value="" size="20" />
		
		<h3>*<?php echo $this->lang->line('webshop_first_name'); ?></h3>
		<input type="text" name="customer_first_name" value="<?php echo set_value('customer_first_name'); ?>" size="30" />
		
		<h3>*<?php echo $this->lang->line('webshop_last_name'); ?></h3>
		<input type="text" name="customer_last_name" value="<?php echo set_value('customer_last_name'); ?>" size="30" />
		
		<h3>*<?php echo $this->lang->line('webshop_mobile_tel'); ?></h3>
		<input type="text" name="phone_number" value="<?php echo set_value('phone_number'); ?>" size="15" />
		
		
		<h3>*<?php echo $this->lang->line('webshop_shipping_address'); ?></h3>
		<input type="text" name="address" value="<?php echo set_value('address'); ?>" size="50" />
		
		<h3>*<?php echo $this->lang->line('webshop_post_code'); ?></h3>
		<input type="text" name="post_code" value="<?php echo set_value('post_code'); ?>" size="8" />
		
		<h3>*<?php echo $this->lang->line('webshop_city'); ?></h3>
		<input type="text" name="city" value="<?php echo set_value('city'); ?>" size="20" />
                <br />
		<?php
                if($security_method=='recaptcha'){
                    echo "<h3>*".$this->lang->line('contact_captcha')."</h3>";
                    echo "<p>$cap_img</p>" ;
                    
                }elseif($security_method=='question'){
                    echo "<h3>*". $this->lang->line('webshop_write_ans')."</h3><br />";
                    echo $question;
                    echo "<input type=\"text\" name=\"write_ans\" id=\"write_ans\" maxlength=\"30\" size=\"30\"  />";
                }
		
		?>
		
		<br />
		<input type="submit" name="submit" value="<?php echo $this->lang->line('webshop_register'); ?>" />
		
		<?php echo form_close(); ?>

</div>