<h2><?php print $header?></h2>

<div class="buttons">
	<a href="#create">
		<?php print $this->bep_assets->icon('add') ?>
		<?php print $this->lang->line('access_create_action')?>
	</a>
</div><br/><br/>

<?php print form_open('auth/admin/acl_actions/delete')?> 
<table class="data_grid" cellspacing="0">
<thead>
    <tr>
        <th width=5%><?php print $this->lang->line('general_id')?></th>
        <th><?php print $this->lang->line('access_actions')?></th>
        <th width=10%><?php print form_checkbox('all','select',FALSE)?> <?php print $this->lang->line('general_delete')?></th>
    </tr>
</thead>
<tfoot>
    <tr>
        <td colspan=2>&nbsp;</td>
        <td><?php print form_submit('delete',$this->lang->line('general_delete'),'onClick="return confirm(\''.$this->lang->line('access_delete_actions_confirm').'\');"')?></td>  
    </tr>
</tfoot>
<tbody>
    <?php 
    $query = $this->access_control_model->fetch('axos');
    foreach($query->result() as $result): ?>
    <tr>
        <td><?php print $result->id?></td>
        <td><?php print $result->name?></td>
        <td><?php print form_checkbox('select[]',$result->name,FALSE)?></td>
    </tr>    
    <?php endforeach;?>
</tbody>
</table>
<?php print form_close()?>

<div class="buttons">
	<a href="<?php print site_url('auth/admin/access_control') ?>">
		<?php print $this->bep_assets->icon('arrow_left') ?>
		<?php print $this->lang->line('general_back')?>
	</a>
</div><br/><br/>

<a name="create"></a>
<h2><?php print $this->lang->line('access_create_action')?></h2>
<?php print form_open('auth/admin/acl_actions/create',array('class'=>'horizontal'))?>
    <fieldset>
        <ol>
            <li>
                <?php print form_label($this->lang->line('access_name'),'name')?>
                <?php print form_input('name','','class="text"')?>
            </li>
            <li class="submit">
            	<div class="buttons">
            		<button type="submit" class="positive" name="submit" value="submit">
            			<?php print $this->bep_assets->icon('disk') ?>
            			<?php print $this->lang->line('general_save') ?>
            		</button>
            	</div>
            </li>
        </ol>
    </fieldset>
<?php print form_close()?>
