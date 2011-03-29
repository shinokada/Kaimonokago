$(document).ready(function(){
	
	//configure the date format to match mysql date
	$('#date').datepick({dateFormat: 'yy-mm-dd'});
	
	$("#accordion").accordion();
		$(".status").click(function () {
      $(this).toggleClass("inactive");
    });
	
	$("#tablesorter_product").dataTable( {
		"aaSorting": [[ 1, "asc" ]],
		"iDisplayLength": 200,
                "oLanguage": {
			"sLengthMenu": 'Display <select>'+
				'<option value="20">20</option>'+
				'<option value="40">40</option>'+
				'<option value="60">60</option>'+
				'<option value="80">80</option>'+
				'<option value="100">100</option>'+
				'<option value="-1">All</option>'+
				'</select> records'
		}
  } );
  
  
  $("#tablesorter").dataTable( {
      "iDisplayLength": 40,
      "oLanguage": {
      "sLengthMenu": 'Display <select>'+
	'<option value="20">20</option>'+
	'<option value="40">40</option>'+
	'<option value="60">60</option>'+
	'<option value="80">80</option>'+
	'<option value="100">100</option>'+
	'<option value="-1">All</option>'+
	'</select> records'
      }		
  } );
  
});

function confirmSubmit(name) {
var msg;
msg= "Are you sure you want to delete the data ? "+ name ;
var agree=confirm(msg);
if (agree)
return true ;
else
return false ;
}