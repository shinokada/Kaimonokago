<table width="100%" cellspacing="0">
	<thead>
		<tr><th width="50%"><?php print $this->lang->line('dashboard_statistics_name') ?></th><th><?php print $this->lang->line('dashboard_statistics_value') ?></th></tr>
	</thead>

	<tbody>
		<tr><td><?php print $this->lang->line('dashboard_statistics_total_members') ?></td><td><?php print $total_members ?></td></tr>
		<tr><td><?php print $this->lang->line('dashboard_statistics_total_unactivated_members') ?></td><td><?php print $total_unactivated_members ?></td></tr>
		<tr><td><?php print $this->lang->line('dashboard_statistics_user_registration') ?></td><td><?php print $user_registration ?></td></tr>
		<tr><td><?php print $this->lang->line('dashboard_statistics_ci_version') ?></td><td><?php print CI_VERSION ?></td></tr>
		<tr><td><?php print $this->lang->line('dashboard_statistics_bep_version') ?></td><td><?php print BEP_VERSION ?></td></tr>
		<tr><td><?php print $this->lang->line('dashboard_statistics_php_version') ?></td><td><?php print phpversion();?></td></tr>
	</tbody>
</table>