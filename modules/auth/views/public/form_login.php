<h3><?php print $header?></h3>
<?php print form_open('auth/login',array('class'=>'horizontal'))?>
    <fieldset>
        <ol>
            <li>
                <label for="login_field"><?php print $login_field?>:</label>
                <input type="text" name="login_field" id="login_field" class="text" value="<?php print $this->validation->login_field?>"/>
            </li>
            <li>
                <label for="password"><?php print $this->lang->line('userlib_password')?>:</label>
                <input type="password" name="password" id="password" class="text" />
            </li>
            <li>
                <label for="remember"><?php print $this->lang->line('userlib_remember_me')?>?</label>
                <?php print form_checkbox('remember','yes',$this->input->post('remember'))?>
            </li>
            <?php
            // Only display captcha if needed
            if($this->preference->item('use_login_captcha')):?>
            <li class="captcha">
                <label for="recaptcha_response_field"><?php print $this->lang->line('userlib_captcha')?>:</label>
                <?php print $captcha?>
            </li>
            <?php endif;?>

            <li class="submit">
            	<div class="buttons">
            		<button type="submit" class="positive" name="submit" value="submit">
            			<?php print $this->bep_assets->icon('key') ?>
            			<?php print $this->lang->line('userlib_login')?>
            		</button>

            		<a href="<?php print site_url('auth/forgotten_password') ?>">
            			<?php print $this->bep_assets->icon('arrow_refresh') ?>
            			<?php print $this->lang->line('userlib_forgotten_password')?>
            		</a>

            		<?php if($this->preference->item('allow_user_registration')):?>
            		<a href="<?php print site_url('auth/register') ?>">
            			<?php print $this->bep_assets->icon('user') ?>
            			<?php print $this->lang->line('userlib_register')?>
            		</a>
            		<?php endif;?>
            </li>
        </ol>
    </fieldset>
<?php print form_close()?>