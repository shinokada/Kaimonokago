<h2><?php print $header?></h2>
<p><?php print $this->lang->line('access_advanced_desc')?></p>

<table width=100% cellspacing=0>
    <tr>
        <td width=33%><b><?php print $this->lang->line('access_groups')?></b></td>
        <td width=33%><b><?php print $this->lang->line('access_resources')?></b></td>
        <td width=33%><b><?php print $this->lang->line('access_actions')?></b></td>
    </tr>
    <tr>
        <td><div class="advanced_view_tree"><ul id="access_groups" class="treeview"><?php print $this->access_control_model->buildGroupSelector()?></ul></div></td>
        <td><div class="advanced_view_tree"><ul id="access_resources" class="treeview"></ul></div></td>
        <td><div class="advanced_view_tree" id="access_actions"><?php print $this->lang->line('access_advanced_select')?></div></td>
    </tr>
</table>

<div class="buttons">
	<a href="<?php print site_url('auth/admin/acl_permissions') ?>">
		<?php print $this->bep_assets->icon('arrow_left') ?>
		<?php print $this->lang->line('general_back') ?>
	</a>
</div>