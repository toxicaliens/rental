// $(document).ready(function(){

	// $('input.parent').click(function(){
	// 	var who = $(this).attr('who');
	// 	$(this).closest('li').addClass('current');
	// 	if($(this).is(':checked')){
	// 		$('li.current span').addClass('checked');
	// 		$('.'+who).attr('checked', true);
	// 		$('li.current').removeClass('current');
	// 	}else if($(this).is(':unchecked')){
	// 		$('li.current span').removeClass('checked');
	// 		$('.'+who).attr('checked', false);
	// 		$('li.current').removeClass('current');
	// 	}
	// });

	$('input[id^="view_"]').click(function(){
		var parent = $(this).data("parent"),
			checked = $(this).is(":checked"),
			children = $(this).data("children").split(",");
		if(parent > 0)
		{
			var parentElem = $("#view_"+parent);
			if(checked)
			{
				$(parentElem).parent().addClass("checked");
				$(parentElem).attr('checked',checked);
			}
			else
			{				
				var parentChildren = $(parentElem).data("children").split(",");
				var anotherChildisChecked = false;
				parentChildren.forEach(function(entry) {
					if(entry != "")
					{
						var elem = $("#view_"+entry);
						if(elem.is(":checked"))
					    {
					    	anotherChildisChecked = true;
					    	return;
					    }
					}
				});
				if(!anotherChildisChecked)
				{
					$(parentElem).parent().removeClass("checked");
					$(parentElem).attr('checked',false);
				}
					
			}
		}
		children.forEach(function(entry) {
			if(entry != "")
		    	var elem = $("#view_"+entry);
		    if(checked)
		    	$(elem).parent().addClass("checked");
		    else
		    	$(elem).parent().removeClass("checked");
	    	$(elem).attr('checked',checked);
		});

	});

// 	// //if a child view is checked then select its parent
// 	// $('.child').click(function(){
// 	// 	if($(this).is(':checked')){
// 	// 		$(this).removeClass('child');
// 	// 		$(this).addClass('child');
// 	// 		$(this).closest('ul').addClass('cur_parent');
// 	// 		$('ul.cur_parent').closest('li').addClass('cur_list');
// 	// 		$('li.cur_list > div.checker > span').addClass('checked');
// 	// 		$('span.checked > input').attr('checked', true);
			
// 	// 		$('ul.cur_parent').removeClass('cur_parent');
// 	// 		$('li.cur_list').addClass('prev_list');
// 	// 		$('li.cur_list').removeClass('cur_list');
// 	// 	}else if($(this).is(':unchecked')){
// 	// 		$('span.checked > input').attr('checked', false);
// 	// 		$('li.prev_list > div.checker > span.checked').removeClass('checked');
// 	// 	}
// 	// });
// });