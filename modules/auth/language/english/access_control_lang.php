<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Access Control Language Array
 *
 * Contains all language strings used by the Access Control Controller
 *
 * @package         BackendPro
 * @subpackage      Languages
 * @author          Adam Price
 * @copyright       Copyright (c) 2008
 * @license         http://www.gnu.org/licenses/lgpl.html
 * @link            http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ---------------------------------------------------------------------------

/* Strings used on Access Control Splash page */
$lang['access_permissions'] = 'Permissions';
$lang['access_groups'] = 'Groups';
$lang['access_actions'] = 'Actions';
$lang['access_resources'] = 'Resources';

$lang['access_permissions_desc'] = "By using permissions you can grant certain
    user groups access to certain resources. You can also specify what actions if any
    they can perform on those resources.";
$lang['access_groups_desc'] = "Groups are 'virtual' containers for site members. By
    assigning a user to a group it means you can assign relative permissions to users
    without having to repeat the process for every user in that group.";
$lang['access_actions_desc'] = "Actions let you have an even more fine grained
    control over a resource. You could for instance have 'Add', 'Edit' & 'Delete' actions.
    This would mean you could grant users permissions to perform certain actions on
    a set resource.";
$lang['access_resources_desc'] = "Resources are items you want to restrict
    access to. For example this administration area is and its pages are all resources.
    Using the correct user groups and permissions it is possible to only grant access
    to these pages by a select few.";

/* General */
$lang['access_name'] = "Name";
$lang['access_parent_name'] = "Parent";

/* Actions */
$lang['access_create_action'] = "Create Action";
$lang['access_delete_action'] = "Delete Action";
$lang['access_action_created'] = "The action '%s' has been created successfully";
$lang['access_action_deleted'] = "The action '%s' has been deleted successfully";
$lang['access_action_exists'] = "Cannot add the action '%s' since it already exists!";
$lang['access_delete_actions_confirm'] = "Are you SURE you want to delete these actions? Doing so will REMOVE all actions from related permissions";

/* Resources */
$lang['access_create_resource'] = "Create Resource";
$lang['access_edit_resource'] = "Modify Resource";
$lang['access_delete_resource'] = "Delete Resource";
$lang['access_resource_created'] = "The resource '%s' has been created successfully";
$lang['access_resource_saved'] = "The resource '%s' has been saved successfully";
$lang['access_resource_deleted'] = "The resource '%s' has been deleted successfully";
$lang['access_resource_exists'] = "Cannot add the resource '%s' since it already exists!";
$lang['access_resource_root'] = "Cannot modify the node '%s' since it is the root node.";
$lang['access_resource_illegal_assignment'] = "Illegal assigment for new parent node of node '%s'";
$lang['access_delete_resources_confirm'] = "Are you SURE you want delete these resources? Doing so will also DELETE all permissions using these resources!";

/* Groups */
$lang['access_disabled'] = "Disabled";
$lang['access_create_group'] = "Create Group";
$lang['access_edit_group'] = "Modify Group";
$lang['access_delete_group'] = "Delete Group";
$lang['access_group_created'] = "The group '%s' has been created successfully";
$lang['access_group_saved'] = "The group '%s' has been saved successfully";
$lang['access_group_deleted'] = "The group '%s' has been deleted successfully";
$lang['access_group_exists'] = "Cannot add the group '%s' since it already exists!";
$lang['access_group_root'] = "Cannot modify the node '%s' since it is the root node.";
$lang['access_group_illegal_assignment'] = "Illegal assigment for new parent node of node '%s'";
$lang['access_delete_groups_confirm'] = "Are you SURE you want delete these groups? Doing so will also DELETE all permissions using these groups!";

/* Permissions */
$lang['access_permissions_table_desc'] = "Items in <font color='green'><b>green</b></font> means that group is <b>ALLOWED</b> access to it, while <font color='red'><b>red</b></font> means they are <b>DENIED</b> access to it. A resource access write takes priority over action access writes. For example if a resource is marked as <b>DENIED</b>, it dosn't matter if an action is <b>ALLOWED</b> the resource & all actions will be <b>DENIED</b>.";
$lang['access_create_permission'] = "Create Permission";
$lang['access_edit_permission'] = "Modify Permission";
$lang['access_delete_permission'] = "Delete Permission";
$lang['access_permission_created'] = "Permission has been created successfully";
$lang['access_permission_saved'] = "Permission has been saved successfully";
$lang['access_permissions_deleted'] = "Permissions have been deleted successfully";
$lang['access_advanced_permissions'] = "Advanced View Mode";
$lang['access'] = "Access";
$lang['access_allow'] = "Allow";
$lang['access_deny'] = "Deny";
$lang['access_delete_permissions_confirm'] = "Are you SURE you want to delete these permissions? WARNING: DOING SO MAY LOCK YOU OUT OF THE SYSTEM!";

/* Advanced View */
$lang['access_advanced_desc'] = "This page is used as an aid to show you how
    your system permissions work. Just looking at what permissions exist doesn't
    show you what groups have access to what resources. So select a group in the
    right hand tree and their resource access infomation will be shown in the
    middle tree. If you then click on a resource it will show you what actions
    the group can perform on the resource.";
$lang['access_advanced_select'] = "Please select a resource to view its action permissions.";

/* End of file access_control_lang.php */
/* Location: ./modules/auth/lang/english/access_control_lang.php */