/**
 * Contains JS code to handle the permission trees for access control
 *
 */
$(document).ready(function(){    
    
    /********************************************* USED TO MANAGE PERMISSIONS */
    // Create permission trees
    $('#groups').treeview({
        cookie_name: 'bep_group_tree'
    });
    $('#resources').treeview({
        cookie_name: 'bep_resource_tree'
    });
    
    // Setup inital actions depending on checkboxes
    $("input[name^='action_']:checkbox",'div.scrollable_tree')
        .each(function(){toggleActions($(this));})   
        .change(function(){toggleActions($(this));});
    
    // Function to hide/show action options
    function toggleActions(checkbox)
    {
        var id = checkbox.attr('name').replace('action_','');
        
        if(checkbox.is(':checked')){
            $("div[id=allow_"+id+"]",'div.scrollable_tree').show();
        } else {
            $("div[id=allow_"+id+"]",'div.scrollable_tree').hide(); 
        }
    }  
    
    /****************************************** USED TO VIEW PERMISSIONS TREE */     
    
    // Get the initial advanced view    
    fetchViewResources($('#access_groups input[name="aro"]').val());    
    
    // When a user picks a differnt access_group load its access_rights in
    // the respective div
    $('#access_groups input[name="aro"]').click(function(){fetchViewResources($(this).val())});
    
    // Function to update the advanced view access rights tree
    function fetchViewResources(group){
        $.post(base_url+index_page+'/auth/admin/acl_permissions/ajax_fetch_resources/'+group,{},
        function(val){
            $('#access_resources').html(val);
            
            // Replace the text in the action div
            $('#access_actions').text('Please select a resource to view its action permissions.');
            
            // Make it so when we click on a resource its actions are displayed
            $('#access_resources span').click(function(){
                var group = $('#access_groups input[name="aro"]:checked').val();
                var resource = $(this).parent().attr('id');
                fetchViewActions(group,resource);
            });       
        });
    }
    
    // Function to fetch ajax actions
    function fetchViewActions(group,resource){
        $.post(base_url+index_page+'/auth/admin/acl_permissions/ajax_fetch_actions/'+group+'/'+resource,{},function(val){$('#access_actions').html(val); });
    }
});