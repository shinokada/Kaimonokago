<div id="content">
	<div id="omossleft">
		<div id="logo">
		</div>
		<div class="contentleft">
	<?php print displayStatus();?>
			<?php
			if ($this->session->flashdata('subscribe_msg')){
				echo "<div class='status_box'>";
				echo $this->session->flashdata('subscribe_msg');
				echo "</div>";
			}
			?>
	
			<div id="contactform">
				<?php echo form_open( $module."/message"); ?>
                <h3><?php echo form_fieldset($this->lang->line('contact_send')." ".$this->lang->line('contact_your_message')); ?></h3>
			
				<p id="name">
					<label for="name">*<?php echo $this->lang->line('webshop_name'); ?>: </label>
					<input type="text" name="name" id="name" value="<?php echo set_value('name'); ?>" maxlength="30" size="30"  />
					
				</p>
			
				<p id="email">
					<label for="email">*<?php echo $this->lang->line('webshop_email'); ?>: </label>
					<input type="text" name="email" id="email" value="<?php echo set_value('email'); ?>" maxlength="30" size="30"  />
					
				</p>
			
				<p>
					<label for="message">*<?php echo $this->lang->line('contact_your_message'); ?>: </label><br />
					<?php 
					  $data = array(
				      'name'  => 'message',
				      'id'    => 'message',
				      'rows'  => '10',
				      'cols'  => '3',
				      'style' => 'width:60%',
				    );	
					
				echo form_textarea($data);
				?>
				</p>
				<p>*<?php echo $this->lang->line('contact_captcha'); ?></p><br />
				<?php echo "<p>$cap_img</p>" ;?>
				<div id="contactsubmit"><input type="submit" value="<?php echo $this->lang->line('contact_send'); ?>" />
				</div>
				<?php echo form_fieldset_close(); ?>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
