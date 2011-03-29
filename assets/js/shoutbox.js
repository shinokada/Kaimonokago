$(document).ready(function(){
	//global vars
	$(".hideme").css("display", "none");
	
	var inputUser = $("#nick");
	var inputMessage = $("#message");
	var loading = $("#loading");
	var messageList = $("#message_ul");
	var completedmsg = $("#completed");
	var completedList = $("#completed_ul");
	
	//Load for the first time the shoutbox data
	updateShoutbox();
	updateCompletedbox();
	
	
	//functions
	function updateShoutbox(){
		
		//just for the fade effect
		messageList.hide();
		loading.fadeIn();
		//send the post to shoutbox.php
		$.ajax({
			type: "POST", 
			url: "admin/AjaxgetShoutBox", 
			// data: "action=update",
			complete: function(data){
				
				loading.fadeOut();
				messageList.html(data.responseText);
				messageList.fadeIn(2000);
				//completedList.fadeIn(2000);
			}
		});
	}
	
		function updateCompletedbox(){
		//just for the fade effect
		completedList.hide();
		loading.fadeIn();
		//send the post to shoutbox.php
		$.ajax({
			type: "POST", 
			url: "admin/AjaxgetCompletedBox", 
			// data: "action=update",
			complete: function(data){
				loading.fadeOut();
				completedList.html(data.responseText);
				// messageList.fadeIn(2000);
				completedList.fadeIn(2000);
			}
		});
	}
	//check if all fields are filled
	function checkForm(){
		if(inputUser.attr("value") && inputMessage.attr("value"))
			return true;
		else
			return false;
	}
	
	
	//on submit event
	$("#form").submit(function(event){
		event.preventDefault();
		if(checkForm()){
			var nick = inputUser.attr("value");
			var message = inputMessage.attr("value");
			//we deactivate submit button while sending
			$("#send").attr({ disabled:true, value:"Sending..." });
			$("#send").blur();
			//send the post to shoutbox.php
			$.ajax({
				type: "POST", 
				url: "admin/insertShoutBox", 
				data: $('#form').serialize(),
				complete: function(data){
					messageList.html(data.responseText);
					updateShoutbox();
					 $('#message').val('');
					//reactivate the send button
					$("#send").attr({ disabled:false, value:"SUBMIT !" });
				}
			 });
		}
		else alert("Please fill all fields!");
		//we prevent the refresh of the page after submitting the form
		return false;
	});
	
	//on todo event. this changes the status to compeleted
	
	$(".todo").live('click', function(event){
		event.preventDefault();
		loading.fadeIn();
		var href = $(this).attr("href");
		var id =href.substring(href.lastIndexOf("/") + 1);
		var msgContainer = $(this).closest('li');
		
		$.ajax({
		  type: "POST",
		  url: "admin/changestatus/"+id,
		  // data: id,
		   cache: false,
		   complete: function(){
			msgContainer.slideUp('slow', function() {$(this).remove();});
		//	completedmsg.fadeOut(2000);
			updateCompletedbox();
		//	completedmsg.fadeIn(2000);
			loading.fadeOut();
		  }
		 });
		
	});
 
	
	// on complete event. this changes the status to todo
	$(".completedmsg").live('click', function(event){
    event.preventDefault();
    // alert("hei");
	loading.fadeIn();
	var href = $(this).attr("href");
	var id =href.substring(href.lastIndexOf("/") + 1);
	var CompMsgContainer = $(this).closest('li');
	
	$.ajax({
			type: "POST",
			url: "admin/changestatus/"+id,
			// data: id,
			cache: false,
			complete: function(){
			CompMsgContainer.slideUp('slow', function() {$(this).remove();});
		//	completedmsg.fadeOut(2000);
			updateShoutbox();
		//	completedmsg.fadeIn(2000);
			loading.fadeOut();
		  }
		 });
	
	});	 
	
	
	$(".delete").live('click',function(event) {
		 event.preventDefault();
		// alert ('clicked');
		loading.fadeIn();
		var commentContainer = $(this).parent();
		var id = $(this).attr("id");
		// var string = 'id='+ id ;
		//	alert(id);
		
		$.ajax({
		  type: "POST",
		  url: "admin/delete/"+id,
		  // data: id,
		   cache: false,
		   complete: function(){
			commentContainer.slideUp('slow', function() {$(this).remove();});
			loading.fadeOut();
		  }
		 });

		});
	
});


	
	