<h3><?php print $header?></h3>
<?php print form_open('auth/forgotten_password',array('class'=>'vertical'))?>
    <fieldset>
        <ol>
            <li>
                <label for="email"><?php print $this->lang->line('userlib_email')?>:</label>
                <input type="text" name="email" id="email" class="text" />
            </li>
            <li class="submit">
            	<div class="buttons">
            		<button type="submit" class="positive" name="submit" value="submit">
            			<?php print $this->bep_assets->icon('arrow_refresh') ?>
            			<?php print $this->lang->line('userlib_reset_password')?>
            		</button>
            		
            		<a href="<?php print site_url('auth/login') ?>" class="negative">
            			<?php print $this->bep_assets->icon('cross') ?>
            			<?php print $this->lang->line('general_cancel')?>
            		</a>
            	</div>
            </li>
        </ol>
    </fieldset>
<?php print form_close()?>