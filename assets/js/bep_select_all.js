/* Provides a method to select multiple checkboxes */
$(document).ready(function(){  
    $("input[name='all']").change(function(){
        var parent = $(this);
            /*var children = $(this).val();
            var checked = $(this).is(':checked');
            var form = $(this).parents('form:first');
            $("input[name='"+children+"[]']",form).each(function(){$(this).attr('checked',checked);});*/
            $("input[name='"+parent.val()+"[]']",parent.parents('form:first')).each(function(){$(this).attr('checked',parent.is(':checked'));});
    });
});