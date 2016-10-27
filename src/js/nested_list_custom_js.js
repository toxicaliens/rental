$(document).ready(function(){
	$('#nestable3').nestable().nestable('collapseAll');
	var li;

	function clickEvents(param) {
		if ( typeof(param) === 'undefined' ) param = 'all';
		
		$('.dd-item > span.action').unbind('click').click(function(){
			var p = $(this).parent();
			if ( confirm('Would you like to remove this item?') ) p.remove();
		}); if ( param == 'seperator' ) return;

		$('.dd-item > span.edit').unbind('click').click(function(){
			$('.add-node-modal .modal-title').html('Edit Node');
			$('.add-node-modal input[type="text"]').val('');

			li = $(this).parent();
			$('.add-node-modal .url-select').val(li.attr('data-id')).prop('selected',true);
			$('.add-node-modal .txt').val( li.attr('data-text') );
			$('.add-node-modal .url')
				.val( li.attr('data-url') )
				.prop('disabled',(li.attr('data-id').indexOf('nn')<0));

			if ( typeof(li.attr('data-icon')) !== 'undefined' ) {
				$('.add-node-modal .ico').val( li.attr('data-icon') );
				$('.add-node-modal .div-icon').removeClass('hide');
			}

			$('.add-node-modal').modal('show');
		});

		$('.dd-content > input').unbind('keyup').on('keyup', function () {
			var p = $(this).parent();
			p.parent().attr('data-url', p.children('.url').val());
			p.parent().attr('data-text', p.children('.txt').val());
			p.parent().attr('data-icon', p.children('.ico').val());

			if ( $(this).hasClass('txt') ) 
				p.parent().children('.dd3-content').html(p.children('.txt').val());
		});
	} clickEvents();

	

	$('.collapse-all').click(function(){
		$('#nestable3').nestable('collapseAll');
	});
	$('.expand-all').click(function(){
		$('#nestable3').nestable('expandAll');
	});

	$('.add-node').click(function(){
		$('.add-node-modal .url-select').val('###').prop('selected',true);
		$('.add-node-modal .modal-title').html('Add Node');
		$('.add-node-modal .url').prop('disabled',false);
		$('.add-node-modal input[type="text"]').val('');
		$('.add-node-modal').modal('show');
	});
	
	$('.add-node-modal .btn-primary').click(function(){
		var 
			txt = $('.add-node-modal .url').val(),
			a = $('.add-node-modal .alert');

		if ( txt.indexOf("/{")>=0 || txt.indexOf("}")>=0 ) {
			a.removeClass('hide');
		} else { 
			$('.add-node-modal .btn-primary').attr('save-changes', 'true');
			if ( !a.hasClass('hide') ) a.addClass('hide');
			$('.add-node-modal').modal('hide'); 
		}
		
	});

	$('.add-node-modal .url-select').change(function(){
		var 
			txt = $(this).children('option:selected').html(),
			test = ( $(this).val() == '###' || txt.indexOf("/{") >= 0 );

		$('.add-node-modal .url')
			.prop('disabled', !test)
			.val($(this).children('option:selected').html());
	});

	$('.add-node-modal').on('hide', function(){
		var test = $('.add-node-modal .btn-primary').attr('save-changes') == 'true';

		if ( $('.add-node-modal .modal-title').html() == 'Edit Node' && test ) {
			if ( !$('.add-node-modal .div-icon').hasClass('hide') ) {
				$('.add-node-modal .div-icon').addClass('hide');
				li.attr('data-icon', $('.add-node-modal .ico').val());
			}
		
			li.attr('data-id', $('.add-node-modal .url-select').val());
			li.attr('data-url', $('.add-node-modal .url').val());
			li.attr('data-text', $('.add-node-modal .txt').val());
			li.children('.dd3-content').html($('.add-node-modal .txt').val());
		}
		else if ( test ) {
			$('.add-node-modal .btn-primary').attr('save-changes', 'false');
			var t = $('.add-node-modal input.txt').val(), 
			    u = $('.add-node-modal input.url').val(), 
			    i = $('.add-node-modal .url-select').val();
			$('#nestable3 > ol').append('<li class="dd-item dd3-item" data-id="'+i+'" data-url="'+u+'" data-text="'+t+'"><div class="dd-handle dd3-handle"></div> <div class="dd3-content">'+t+'</div><span class="icon-edit edit"></span><span class="icon-trash action"></span></li>');
			clickEvents();
		}
	});


	$('.form-horizontal').on('submit', function(){
		var e = $('#nestable3').data('output', $('#serialised-text')),
		    list = e.length ? e : $(e.target),
		    output = list.data('output');

		if (window.JSON) {
			output.val(window.JSON.stringify(list.nestable('serialize')));
		} else {
			alert('JSON browser support required for one to edit this menu.');
			return false;
		}

		// Ensure the form submits
		return true;
	})
})