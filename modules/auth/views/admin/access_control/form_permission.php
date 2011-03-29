<h2><?php print $header?></h2>

<?php print form_open('auth/admin/acl_permissions/save')?>
<table width="100%" cellspacing="0">
    <tr>
        <td width="33%"><b><?php print $this->lang->line('access_groups')?></b></td>
        <td width="33%"><b><?php print $this->lang->line('access_resources')?></b></td>
        <td width="33%"><b><?php print $this->lang->line('access_actions')?></b></td>
    </tr>
    <tr>
        <td colspan="3">
        	<?php
        		// Show regions as readonly?
        		$readonly = ($_POST['id'] == NULL)?'':' readonly';
        	?>
	        <div class="scrollable_tree<?php print $readonly?>"><ul id="groups"><?php print $this->access_control_model->buildGroupSelector(($_POST['id']!=NULL))?></ul></div>
			<div class="scrollable_tree<?php print $readonly?>"><ul id="resources"><?php print $this->access_control_model->buildResourceSelector(($_POST['id']!=NULL))?></ul></div>
			<div class="scrollable_tree"><?php print $this->access_control_model->buildActionSelector()?></div>
        </td>
    </tr>
    <tr>

        <td colspan="3">
            <b><?php print $this->lang->line('access')?>:</b><br/>
            <?php print form_radio('allow','Y',$this->validation->set_radio('allow','Y')) . $this->lang->line('access_allow')?>
            <?php print form_radio('allow','N',$this->validation->set_radio('allow','N')) . $this->lang->line('access_deny')?>
        </td>
    </tr>
</table>
<?php print form_hidden('id',$this->validation->id)?>
<div class="buttons">
	<button type="submit" class="positive" name="submit" value="submit">
		<?php print $this->bep_assets->icon('disk');?>
		<?php print $this->lang->line('general_save');?>
	</button>

	<a href="<?php print site_url('auth/admin/acl_permissions')?>" class="negative">
		<?php print $this->bep_assets->icon('cross');?>
		<?php print $this->lang->line('general_cancel');?>
	</a>
</div>
<?php print form_close()?>