/**
 * Called to initialise autocomplete controls
 */
$(document).ready(function(){
	$('.autocomplete-picker').each(function(){
		var ctrl = $(this);
		
		ctrl.typeahead({
			source: function(query, process) {
				var $items = new Array; $items = [""];
				ctrl.addClass('autocomplete-l');
				
				$.ajax({
					type: "POST", dataType: "json",
					data: { autocomplete_event:true, search_term:query },
					complete: function () {
						ctrl.removeClass('autocomplete-l');
					},
					error: function(jqXHR, textStatus, errorThrown) {
						alert("textStatus: "+textStatus+"\nerrorThrown: "+errorThrown);
					},
					success: function(data) {
						$.map(data, function(data){
							var group = {
								id: data.tagId,
								label: data.tagLabel,                            
								toString: function () {
									return JSON.stringify(this);
								},
								toLowerCase: function () {
									return this.label.toLowerCase();
								},
								indexOf: function (string) {
									return String.prototype.indexOf.apply(this.label, arguments);
								},
								replace: function (string) {
									var value = '';
									value +=  this.label;
									if(typeof(this.level) != 'undefined') {
										value += ' <span class="pull-right muted">';
										value += this.level;
										value += '</span>';
									}
									return String.prototype.replace.apply('<div style="white-space:normal">' + value + '</div>', arguments);
								}
							};
							$items.push(group);
						});

						process($items);
					}
				});
			},
			items: 15,
			minLength: 2,
			updater: function (item) {
				var item = JSON.parse(item);
				
				if (typeof ctrl.attr('data-control') !== 'undefined' && ctrl.attr('data-control') !== false)
					$('#'+ctrl.attr('data-control')).val( item.id );
					
				return item.label;
			}
		});
	});
});

