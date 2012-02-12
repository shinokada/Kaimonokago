$(document).ready(function(){
	// Declare well used objects
	var editBnt = $('#edit_dashboard');
  	var saveBnt = $('#save_dashboard');
  	var regions = $("#dashboard .sortable");
  	var widgets = $('.widget',regions);
  	
  	/* CREATE INITIAL DASHBOARD STATE */
  	// Hide Save button
  	saveBnt.hide();
  
  	// Get the current dashboard settings from the cookie
  	// and position the widgets accordingly
  	//
  	// When the widgets are saved there are saved in a string with the following
  	// format
  	//
  	// {region}[]={widget_id}&...&{widget_id}[]=visible/hidden
  	//
  	// Where the following variables exist:
  	//	{region} 	= The dashboard region, either topsection, leftsection or rightsection
  	//	{widget_id} = The widget md5 name hash
  	//
  	// The actual widgets have ID of something like widget_98321j3ky98123jk213 but only ever
  	// the bit after widget_ is stored
  	var arr = $.cookie('bep_dashboard');
  	if( arr != null)
  	{
  		// Only position the widgets if we have a cookie
  		arr = arr.split('&');
	  	for(i=0;i<arr.length;i++)
	  	{
	  		var cmd = arr[i].split('[]=');
	  		if(cmd[0] == "topsection" || cmd[0] == "leftsection" || cmd[0] == "rightsection")
	  		{
	  			// We have a position cmd
	  			$('#widget_'+cmd[1],regions).appendTo('#'+cmd[0]);
	  		}
	  		else
	  		{
	  			// We have a visibility cmd
	  			if(cmd[1] == 'hidden')
	  				$('#widget_'+cmd[0],regions).hide();
	  		}
	  	}  
	 }
  
  	// Make regions sortable
    regions.sortable({
    	cursor: 'move',
    	connectWith: [$('#topsection'),$('#leftsection'),$('#rightsection')],
    	opacity: 0.8,
    	scroll: false
    });
    
    // Disable regions
    regions.sortable("disable");
    
    // Assign a class to the actions so we can identify them in the future
    $('div.action',widgets).each(function(){
    	var tick = $('img:eq(0)',this);
    	var cross= $('img:eq(1)',this);
    	
    	// Setup onclick actions
    	tick.addClass('db-visible').hide().click(function(){
    		$(this).hide();
    		cross.show();
    	});
    	cross.addClass('db-hidden').hide().click(function(){
    		$(this).hide();
    		tick.show();
    	});
    });
    
    /* WHEN USER REQUESTS TO EDIT DASHBOARD */
    editBnt.click(function(){
    	// Hide the button and display the save button
    	editBnt.hide();
    	saveBnt.show();
    	
    	// Make regions sortable
    	regions.sortable("enable");
    	
    	// Get rid of everything apart from the header in the widgets
    	$('div.body',widgets).hide();
    	
    	// Loop over all widgets
    	widgets.each(function(){
    		// Decide whether to show a tick or a cross for this widget
    		if($(this).css('display') == 'none')
    			$('.action img.db-hidden',this).show();
    		else
    			$('.action img.db-visible',this).show();
    		
    		// Show the widget
    		$(this).show();
    	});
    });
    
    /* WHEN THE USER REQUESTS TO SAVE THE DASHBOARD */
    saveBnt.click(function(){
    	// Variable to store cookie settings in
    	var cookie = "";
    	
    	// Save the order which the widgets are in
    	regions.each(function(){
    		var widget = $(this).sortable("serialize").replace(/widget/g, $(this).attr('id'));
    		
    		// If no widgets in region, move to next region
    		if(widget == "") return true;
    		
    		if(cookie == "") cookie = widget;
    		else cookie = cookie + "&" + widget;
    	});
    	
    	// Loop over all widgets and save their values into cookies
    	// If it isn't meant to be shown hide the widget
    	widgets.each(function(){
    		newID = $(this).attr('id').replace(/widget_/g, '');
    		if($('div.action img:visible',this).hasClass('db-hidden')){
    			// Cross is showing
    			cookie = cookie + "&" + newID + "[]=hidden";
    			$(this).hide();
    		}
    		else{
    			// Tick is showing
    			cookie = cookie + "&" + newID + "[]=visible";
    		}
    	});
    	
    	// Save cookie
    	$.cookie('bep_dashboard',cookie,{expires: 31});
    	
    	// Hide the button and display the edit button
    	saveBnt.hide();
    	editBnt.show();
    	
    	// Make regions sortable
    	regions.sortable("disable");
    	
    	// Show bodies of widgets again
    	$('div.body',widgets).show();
    	
    	// Hide the actions
    	$('.action img',widgets).hide();
    });
  });