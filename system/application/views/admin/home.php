<h2><?php print $header?></h2>

<?php print $dashboard ?>

<div class="buttons" style="clear: both">
	<a href="javascript:void(0);" id="edit_dashboard">
		<?php print $this->bep_assets->icon('pencil') ?>
		<?php print $this->lang->line('general_edit') ?> <?php print $this->lang->line('backendpro_dashboard') ?>
	</a>
	
	<a href="javascript:void(0);" id="save_dashboard">
		<?php print $this->bep_assets->icon('disk') ?>
		<?php print $this->lang->line('general_save') ?>
	</a>
</div>