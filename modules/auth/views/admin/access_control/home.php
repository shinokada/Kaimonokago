<h2><?php print $header?></h2>

<table id="access_control_menu" cellspacing="0">
<tr>
    <td><?php print img('assets/images/ac_permissions.png')?></td>
    <td>
        <h3><?php print anchor('auth/admin/acl_permissions',$this->lang->line('access_permissions'))?></h3>
        <p><?php print $this->lang->line('access_permissions_desc')?></p>
    </td>
    
    <td><?php print img('assets/images/ac_groups.png')?></td>
    <td>
        <h3><?php print anchor('auth/admin/acl_groups',$this->lang->line('access_groups'))?></h3>
        <p><?php print $this->lang->line('access_groups_desc')?></p>
    </td>
</tr>

<tr>
    <td><?php print img('assets/images/ac_resources.png')?></td>
    <td>
        <h3><?php print anchor('auth/admin/acl_resources',$this->lang->line('access_resources'))?></h3>
        <p><?php print $this->lang->line('access_resources_desc')?></p>
    </td>
    
    <td><?php print img('assets/images/ac_actions.png')?></td>
    <td>
        <h3><?php print anchor('auth/admin/acl_actions',$this->lang->line('access_actions'))?></h3>
        <p><?php print $this->lang->line('access_actions_desc')?></p>
    </td>
</tr>
</table>