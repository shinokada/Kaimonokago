<h2><?php print $header?></h2>

<div class="buttons">
	<a href="<?php print site_url('auth/admin/acl_groups/form')?>">
		<?php print $this->bep_assets->icon('add')?>
		<?php print $this->lang->line('access_create_group')?>
	</a>
</div><br/><br/>

<?php print form_open('auth/admin/acl_groups/delete')?> 
<table class="data_grid" cellspacing="0">
<thead>
    <tr>
        <th width=5%><?php print $this->lang->line('general_id')?></th>
        <th><?php print $this->lang->line('access_groups')?></th>
        <th width=10% class="middle"><?php print $this->lang->line('access_disabled')?></th>  
        <th width=10% class="middle"><?php print $this->lang->line('general_edit')?></th>  
        <th width=10%><?php print form_checkbox('all','select',FALSE)?> <?php print $this->lang->line('general_delete')?></th>
    </tr>
</thead>
<tfoot>
    <tr>
        <td colspan=4>&nbsp;</td>
        <td><?php print form_submit('delete',$this->lang->line('general_delete'),'onClick="return confirm(\''.$this->lang->line('access_delete_groups_confirm').'\');"')?></td>
    </tr>
</tfoot>
<tbody>
    <?php 
    // Output nested resource view
    $obj = & $this->access_control_model->group;
    $tree = $obj->getTreePreorder($obj->getRoot());
    
    while($obj->getTreeNext($tree)):        
        // See if this group is locked
        $query = $this->access_control_model->fetch('groups',NULL,NULL,array('id'=>$tree['row']['id']));
        $row = $query->row();     
        
        // Get Offset
        $offset = $this->access_control_model->buildPrettyOffset($obj,$tree);
        $disable = ($row->disabled?'tick':'cross');
        $edit = ($obj->checkNodeIsRoot($tree['row']))?'&nbsp;':'<a href="'.site_url('auth/admin/acl_groups/form/'.$tree['row']['id']).'">'.$this->bep_assets->icon('pencil').'</a>';
    ?>  
        <tr>
            <td><?php print $tree['row']['id']?></td>
            <td><?php print $offset.$tree['row']['name']?></td>
            <td class="middle"><?php print $this->bep_assets->icon($disable)?></td> 
            <td class="middle"><?php print $edit?></td> 
            <td><?php print ($row->locked OR $this->preference->item('default_user_group')==$tree['row']['id'])?'&nbsp;':form_checkbox('select[]',$tree['row']['name'],FALSE)?></td>
        </tr>
    <?php endwhile; ?>
</tbody>
</table>
<?php print form_close()?>

<div class="buttons">
	<a href="<?php print site_url('auth/admin/access_control')?>">
		<?php print $this->bep_assets->icon('arrow_left')?>
		<?php print $this->lang->line('general_back')?>
	</a>
</div>