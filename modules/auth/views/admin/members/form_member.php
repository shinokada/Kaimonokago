<div id="generatePasswordWindow">
	<table>
		<tr><th width="50%"><?php print $this->lang->line('userlib_generate_password'); ?></th><th class="right"><a href="javascript:void(0);" id="gpCloseWindow"><?php print $this->bep_assets->icon('cross') ?></a></th></tr>
		<tr><td rowspan="3"><?php print $this->lang->line('userlib_password'); ?>:<br/>&nbsp;&nbsp;&nbsp;<b id="gpPassword">PASSWORD</b></td><td class="right"><?php print $this->lang->line('general_uppercase'); ?> <?php print form_checkbox('uppercase','1',TRUE); ?></td></tr>
		<tr><td class="right"><?php print $this->lang->line('general_numeric'); ?> <?php print form_checkbox('numeric','1',TRUE); ?></td></tr>
		<tr><td class="right"><?php print $this->lang->line('general_symbols'); ?> <?php print form_checkbox('symbols','1',FALSE); ?></td></tr>
		<tr><td colspan="2"><a href="javascript:void(0);" class="icon_arrow_refresh" id="gpGenerateNew"><?php print $this->lang->line('general_generate'); ?></a></td></tr>
		<tr><td><a href="javascript:void(0);" class="icon_tick" id="gpApply"><?php print $this->lang->line('general_apply'); ?></a></td><td class="right"><?php print $this->lang->line('general_length'); ?> <input type="text" name="length" value="12" maxlength="2" size="4" /></td></tr>
	</table>
</div>

<h2><?php print $header?></h2>
<p><?php print $this->lang->line('userlib_password_info')?></p>

<?php print form_open('auth/admin/members/form/'.$this->validation->id,array('class'=>'horizontal'))?>
    <fieldset>
        <ol>
            <li>
                <?php print form_label($this->lang->line('userlib_username'),'username')?>
                <?php print form_input('username',$this->validation->username,'id="username" class="text"')?>
            </li>
            <li>
                <?php print form_label($this->lang->line('userlib_email'),'email')?>
                <?php print form_input('email',$this->validation->email,'id="email" class="text"')?>
            </li>
            <li>
                <?php print form_label($this->lang->line('userlib_password'),'password')?>
                <?php print form_password('password','','id="password" class="text"')?>
            </li>
            <li>
                <?php print form_label($this->lang->line('userlib_confirm_password'),'confirm_password')?>
                <?php print form_password('confirm_password','','id="confirm_password" class="text"')?>
            </li>
            <li>
                <?php print form_label($this->lang->line('userlib_group'),'group')?>
                <?php print form_dropdown('group',$groups,$this->validation->group,'id="group" size="10" style="width:20.3em;"')?>
            </li>
            <li>
                <?php print form_label($this->lang->line('userlib_active'),'active')?>
                <?php print $this->lang->line('general_yes')?> <?php print form_radio('active','1',$this->validation->set_radio('active','1'),'id="active"')?>
                <?php print $this->lang->line('general_no')?> <?php print form_radio('active','0',$this->validation->set_radio('active','0'))?>
            </li>
            <li class="submit">
                <?php print form_hidden('id',$this->validation->id)?>
                <div class="buttons">
	                <button type="submit" class="positive" name="submit" value="submit">
	                	<?php print  $this->bep_assets->icon('disk');?>
	                	<?php print $this->lang->line('general_save')?>
	                </button>

	                <a href="<?php print  site_url('auth/admin/members')?>" class="negative">
	                	<?php print  $this->bep_assets->icon('cross');?>
	                	<?php print $this->lang->line('general_cancel')?>
	                </a>

	                <a href="javascript:void(0);" id="generate_password">
	                	<?php print  $this->bep_assets->icon('key');?>
	                	<?php print $this->lang->line('userlib_generate_password'); ?>
	                </a>
	            </div>
            </li>
        </ol>
    </fieldset>
<h2><?php print $this->lang->line('userlib_user_profile')?></h2>
<?php
    if( ! $this->preference->item('allow_user_profiles')):
        print "<p>".$this->lang->line('userlib_profile_disabled')."</p>";
    else:
?>
    <fieldset>
        <ol>
            <li class="submit">
                <div class="buttons">
	                <button type="submit" class="positive" name="submit" value="submit">
	                	<?php print  $this->bep_assets->icon('disk');?>
	                	<?php print $this->lang->line('general_save')?>
	                </button>

	                <a href="<?php print  site_url('auth/admin/members')?>" class="negative">
	                	<?php print  $this->bep_assets->icon('cross');?>
	                	<?php print $this->lang->line('general_cancel')?>
	                </a>
	            </div>
            </li>
        </ol>
    </fieldset>
<?php endif;?>
<?php print form_close()?>