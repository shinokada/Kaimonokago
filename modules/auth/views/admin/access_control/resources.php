<h2><?php print $header?></h2>

<div class="buttons">
	<a href="<?php print site_url('auth/admin/acl_resources/form')?>">
		<?php print $this->bep_assets->icon('add') ?>
		<?php print $this->lang->line('access_create_resource')?>
	</a>
</div><br/><br/>

<?php print form_open('auth/admin/acl_resources/delete')?>
<table class="data_grid" cellspacing="0">
<thead>
    <tr>
        <th width=5%><?php print $this->lang->line('general_id')?></th>
        <th><?php print $this->lang->line('access_resources')?></th>
        <th width=10% class="middle"><?php print $this->lang->line('general_edit')?></th>
        <th width=10%><?php print form_checkbox('all','select',FALSE)?> <?php print $this->lang->line('general_delete')?></th>
    </tr>
</thead>
<tfoot>
    <tr>
        <td colspan=3>&nbsp;</td>
        <td><?php print form_submit('delete',$this->lang->line('general_delete'),'onClick="return confirm(\''.$this->lang->line('access_delete_resources_confirm').'\');"')?></td>
    </tr>
</tfoot>
<tbody>
    <?php
    // Output nested resource view
    $obj = & $this->access_control_model->resource;
    $tree = $obj->getTreePreorder($obj->getRoot());

    while($obj->getTreeNext($tree)):
        // See if this resource is locked
        $query = $this->access_control_model->fetch('resources','locked',NULL,array('id'=>$tree['row']['id']));
        $row = $query->row();

        // Get Offset
        // INFO: This is a bit of a hack for php 4 as noted in bug #55
        if (floor(phpversion()) < 5)
		{
			// Use pass by reference since its not deprecated yet
        	$offset = $this->access_control_model->buildPrettyOffset($obj,$tree);
		}
		else
		{
			// Can't use pass by reference since it may be deprecated
			$offset = $this->access_control_model->buildPrettyOffset($obj,$tree);
		}
        $edit = ($obj->checkNodeIsRoot($tree['row'])?'&nbsp;':'<a href="'.site_url('auth/admin/acl_resources/form/'.$tree['row']['id']).'">' . $this->bep_assets->icon('pencil') . '</a>');
    ?>
        <tr>
            <td><?php print $tree['row']['id']?></td>
            <td><?php print $offset.$tree['row']['name']?></td>
            <td class="middle"><?php print $edit?></td>
            <td><?php print ($row->locked?'&nbsp;':form_checkbox('select[]',$tree['row']['name'],FALSE))?></td>
        </tr>
    <?php endwhile; ?>
</tbody>
</table>
<?php print form_close()?>

<div class="buttons">
	<a href="<?php print site_url('auth/admin/access_control')?>">
		<?php print $this->bep_assets->icon('arrow_left') ?>
		<?php print $this->lang->line('general_back')?>
	</a>
</div><br/><br/>