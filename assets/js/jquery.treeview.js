(function($){  
$.fn.treeview = function(options){                
    // Setup Plugin options
    var settings = jQuery.extend({
        cookie_name: 'treeview',
        leafClass: 'leaf',
        nodeClass: 'node',
        expandableClass: 'expandable',
        collapsableClass: 'collapsable',
        animate: { height: 'toggle'},
        speed: 'slow'     
    }, options);        

    // Declare main object
    var tree = this;
    
    // If the object dosn't have the treeview style assign it
    if(!tree.hasClass('treeview'))
    {
        tree.addClass('treeview');
    }    
     
    // First hide/show tree nodes
    $('li',tree).each(
        function()
        {
            // Subbranch
            subbranch = $('ul:first', this);
            
            // If there is a valid cookie value, set it to that
            if($.cookie(settings.cookie_name+$(this).attr('id')) == 'block')
                subbranch.show();
            else
                subbranch.hide();
            // Now see if this item has an open tag, if so override all parent settings
            // and show this item
            if($(this).hasClass('open'))
            {
                $(this).parents('ul').show();
                $(this).removeClass('open');
                subbranch.show();
            }
        }
    );
    
    // Now add the +/- signs
    $('li',tree).each(
        function()
        {
            // Subbranch
            subbranch = $('ul:first', this);
            
            if (subbranch.size() != 0) {    
                // Add node icon
                //$(this).find('span:first').addClass(settings.nodeClass);
                
                // Add expandable/collapsable hit areas
                $(this).prepend('<div class="hitarea"></div>');
                if (subbranch.eq(0).css('display') == 'none') {
                    $(this).find('div').addClass(settings.expandableClass);
                } else {
                    $(this).find('div').addClass(settings.collapsableClass);
                }                
            } 
            else
            {
                // Show leaf icon
                //$(this).find('span:first').addClass(settings.leafClass);
            }
        }
    );    
        
    // When a hit area is clicked, toggle the subbranch
    $('div.hitarea',tree).click(
        function()
        {
            var parent = $(this).parent();
            var subtree = $('ul:first',parent);
            
            // Store change
            if(subtree.css('display')=='none')
                $.cookie(settings.cookie_name+parent.attr('id'), 'block',{path: '/'});
            else
                $.cookie(settings.cookie_name+parent.attr('id'), 'none',{path: '/'});
            
            // Animate the subtree
            subtree.animate(settings.animate,settings.speed);            
            
            // Toggle +/-
            $(this).toggleClass(settings.expandableClass).toggleClass(settings.collapsableClass);  
        }
    );
        
    return tree;
};
})(jQuery);