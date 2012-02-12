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


/*
 * from Moodle to unmask password
 */

function unmaskPassword(id) {
  var pw = document.getElementById(id);
  var chb = document.getElementById(id+'unmask');

  try {
    // first try IE way - it can not set name attribute later
    if (chb.checked) {
      var newpw = document.createElement('<input type="text" name="'+pw.name+'">');
    } else {
      var newpw = document.createElement('<input type="password" name="'+pw.name+'">');
    }
    newpw.attributes['class'].nodeValue = pw.attributes['class'].nodeValue;
  } catch (e) {
    var newpw = document.createElement('input');
    newpw.setAttribute('name', pw.name);
    if (chb.checked) {
      newpw.setAttribute('type', 'text');
    } else {
      newpw.setAttribute('type', 'password');
    }
    newpw.setAttribute('class', pw.getAttribute('class'));
  }
  newpw.id = pw.id;
  newpw.size = pw.size;
  newpw.onblur = pw.onblur;
  newpw.onchange = pw.onchange;
  newpw.value = pw.value;
  pw.parentNode.replaceChild(newpw, pw);
}