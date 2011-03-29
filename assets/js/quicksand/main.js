(function($) {
	$.fn.sorted = function(customOptions) {
		var options = {
			reversed: false,
			by: function(a) {
				return a.text();
			}
		};
		$.extend(options, customOptions);
	
		$data = $(this);
		arr = $data.get();
		arr.sort(function(a, b) {
			
		   	var valA = options.by($(a));
		   	var valB = options.by($(b));
			if (options.reversed) {
				return (valA < valB) ? 1 : (valA > valB) ? -1 : 0;				
			} else {		
				return (valA < valB) ? -1 : (valA > valB) ? 1 : 0;	
			}
		});
		return $(arr);
	};

})(jQuery);

$(function() {
  
  var read_button = function(class_names) {
    var r = {
      selected: false,
      type: 0
    };
    for (var i=0; i < class_names.length; i++) {
      if (class_names[i].indexOf('selected-') == 0) {
        r.selected = true;
      }
      if (class_names[i].indexOf('segment-') == 0) {
        r.segment = class_names[i].split('-')[1];
      }
    };
    return r;
  };
  
  // taaaak:
  
  var determine_sort = function($buttons) {
    var $selected = $buttons.parent().filter('[class*="selected-"]');
    return $selected.find('a').attr('data-value');
  };
  
  var determine_kind = function($buttons) {
    var $selected = $buttons.parent().filter('[class*="selected-"]');
    return $selected.find('a').attr('data-value');
  };
  
  // kochamy DRY
  
  var $list = $('#list');
  var $data = $list.clone();
  
  var $controls = $('ul.splitter ul');
  
  $controls.each(function(i) {
    
    var $control = $(this);
    var $buttons = $control.find('a');
    
    $buttons.bind('click', function(e) {
      
      var $button = $(this);
      var $button_container = $button.parent();
      var button_properties = read_button($button_container.attr('class').split(' '));      
      var selected = button_properties.selected;
      var button_segment = button_properties.segment;

      if (!selected) {

        $buttons.parent().removeClass('selected-0').removeClass('selected-1').removeClass('selected-2');
        $button_container.addClass('selected-' + button_segment);
        
        var sorting_type = determine_sort($controls.eq(1).find('a'));
        var sorting_kind = determine_kind($controls.eq(0).find('a'));
        
        if (sorting_kind == 'all') {
          var $filtered_data = $data.find('li');
        } else {
          var $filtered_data = $data.find('li[data-type="' + sorting_kind + '"]');
        }
        
        if (sorting_type == 'size') {
          var $sorted_data = $filtered_data.sorted({
            by: function(v) {
              return parseFloat($(v).find('span[data-type="size"]').text());
            }
          });
        } else {
          var $sorted_data = $filtered_data.sorted({
            by: function(v) {
              return $(v).find('strong').text().toLowerCase();
            }
          });
        }
        
        $list.quicksand($sorted_data, {
          duration: 800,
          easing: 'easeInOutQuad', adjustHeight: false
        });

        
      }
      
      e.preventDefault();
    });
    
  }); 
  
	// bind radiobuttons in the form
	// var $filter_type = $('#grid-filter input[name="type"]');
	//   var $filter_sort = $('#grid-filter input[name="sort"]');
	//   
	//   $filter_type.add($filter_sort).change(function(e) {
	//     if ($($filter_type+":checked").val() == 'all') {
	//       $filteredData = $("#data li")
	//     } else {
	//       $filteredData = $('#data li[data-type= ' + $($filter_type+":checked").val() + ']');
	//     }
	//     
	//     if ($('#grid-filter input[name="sort"]:checked').val() == "size") {
	//       var $sortedData = $filteredData.sorted({
	//         by: function(v) {
	//           return parseFloat($(v).find("span[data-type=size]").text());
	//         }
	//       });
	//     } else {
	//       var $sortedData = $filteredData.sorted({
	//         by: function(v) {
	//           return $(v).find("strong").text().toLowerCase();
	//         }
	//       });
	//     }   
	
	
	
	//       $('#list').quicksand($sortedData, {
	//         duration: 800,
	//         easing: 'easeInOutQuad'
	//       });
	//   
	//   });
	
});