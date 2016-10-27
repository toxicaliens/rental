
var dTable = new function () {
	var oTable;
	var currentSource = '';
		
	function initDataTable(tbl) {
		oTable = $(tbl).dataTable({
			"bProcessing": true, "bServerSide": true,
			"sAjaxSource": currentSource,
			"aaSorting": [[ 0, "desc" ]],
			"fnServerData": function ( sSource, aoData, fnCallback ) {
				$.ajax( {
					"dataType": 'json',
					"type": "GET",
					"url": currentSource,
					"data": aoData,
					"success": fnCallback
				});
			}
		});
		
		// Add refresh control
		$('#refreshTable').click(function(){
			dTable.fnReloadAjax()
		});
	}
	
	function initNewRecord(url) {
		$('.tools #newRecord').click(function(){
			window.location = url;
		});
	}
	
	function initEditRecord(params) {
		$('.tools #editRecord').click(function(){
			var h = '', c = null;
			
			for ( var i in params.index ) {
				c = $(params.table+' > tbody > tr.info').children('td')[params['index'][i]];
				
				if ( typeof(c)!=="undefined" && typeof(c.innerHTML)!=="undefined" ) {
					if ( h != '' ) h += ',';
					h += c.innerHTML;
				}
			}
			
			// Open the form
			if ( h != "" ) window.location = params.editForm + '/' + h;
			else alert ( "Please select a record to edit" );
		});
	}
	
	function initDeleteRecord(params) {
		$('.tools #deleteRecord').click(function(){
			var h = '', t = '', c = null;
			$(params.table+' > tbody > tr.info').each(function(){
				t = '';
				for ( var i in params.index ) {
					c = $(this).children('td')[params['index'][i]];
				
					if ( typeof(c)!=="undefined" && typeof(c.innerHTML)!=="undefined" ) {
						if ( t != '' ) t += ',';
						t += c.innerHTML;
					}
				}
				if ( h != "" ) h+= "::";
				h += t;
			});
			
			// Ensure data present
			if ( h == "" )  {
				alert ( "Please select a record to delete" );
				return;
			}
			
			// Confirm deletion
			if (confirm('Are yousure you would like to delete the selected record(s)?') == false) {
				$(params.table+' > tbody > tr').removeClass('info');
				return false;
			}
			
			// Post the data
			var input = [];
			input.push({ name:"delete", value:h });
			App.blockUI(jQuery(params.table));
			
			$.ajax({
				url: params.deleteForm,
				type: "POST", data: input,
				success: function(output) {
					//Show status of the process
					console.log( output );
					
					// Unblock the ui
					App.unblockUI(jQuery(params.table));

					// Reload the table
					dTable.fnReloadAjax();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert("textStatus: "+textStatus+"\nerrorThrown: "+errorThrown);
				}
			});
		});
	}
	
	function initStatus(params) {
		$('.tools #statusOff, .tools #statusOn').click(function(){
			var h = '', t = '', c = null;
			$(params.table+' > tbody > tr.info').each(function(){
				t = '';
				for ( var i in params.index ) {
					c = $(this).children('td')[params['index'][i]];
				
					if ( typeof(c)!=="undefined" && typeof(c.innerHTML)!=="undefined" ) {
						if ( t != '' ) t += ',';
						t += c.innerHTML;
					}
				}
				if ( h != "" ) h+= "::";
				h += t;
			});
			
			// Ensure that data is present
			if ( h == "" ) {
				alert ( "Please select a record to alter its status" );
				return;
			}
		
			// Send the data
			var input = [];
			App.blockUI(jQuery(params.table));
			input.push({ name:$(this).attr('id'), value:h });
		
			$.ajax({
				url: params.statusForm,
				type: "POST", data: input,
				success: function(output) {
					//Show status of the process
					console.log( output );
					App.unblockUI(jQuery(params.table));

					// Reload the table
					dTable.fnReloadAjax();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert("textStatus: "+textStatus+"\nerrorThrown: "+errorThrown);
				}
			});
		});
	}
	
	this.fnReloadAjax = function () {
		var oSettings= oTable.fnSettings();
		oTable.fnClearTable(oTable);
		oTable.oApi._fnProcessingDisplay(oSettings, true );

		$.getJSON(oSettings.sAjaxSource, null, function(json){
			/* Got the data - add it to the table */
			for (var i=0; i<json.aaData.length; i++) {
				oTable.oApi._fnAddData(oSettings, json.aaData[i]);
			}

			oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
			oTable.oApi._fnProcessingDisplay(oSettings, false);
		});
	}
	
	this.initEditable = function(params) {
		// Add or remove class to a row when clicked on
		$(params.table+' > tbody > tr').live('click', function(event){
			if(event.ctrlKey) {
				$(this).toggleClass('info');
			}
			else {
				if ( $(this).hasClass('info') ) {
					$(params.table+' > tbody > tr').removeClass('info');
				}
				else {
					$(params.table+' > tbody > tr').removeClass('info');
					$(this).toggleClass('info');
				}
			}
		});
		
		// Attach the new form record control	
		if ( typeof(params.newForm) !== "undefined" ) {
			initNewRecord(params.newForm);
		}

		// Attach the edit form record control
		if ( typeof(params.editForm) !== "undefined" ) {
			initEditRecord(params);
		}
		
		// Attach the delete form record control
		if ( typeof(params.deleteForm) !== "undefined" ) {
			initDeleteRecord(params);
		}
		
		// Attach the status control
		if ( typeof(params.statusForm) !== "undefined" ) {
			initStatus(params);
		}
		
		currentSource = params.url;
		initDataTable(params.table);
	}
		
	this.initGrid = function(params) {
		currentSource = params.url;
		initDataTable(params.table);
	}
	
/**
 * This is the structure of the panel
<li class="pull-right dashboard-report-li dropdown">
	<div id="dashboard-select-button" class="dashboard-report-range-container no-text-shadow tooltips dropdown-toggle" data-placement="top" data-original-title="Select" role="button" data-toggle="dropdown">
		<i class="icon-reorder icon-large"></i>
		<span>All Transactions</span> <b class="caret"></b>
	</div>
		
	<ul class="dropdown-menu pull-right data-table-filter" role="menu" aria-labelledby="dLabel">
		<li><a tabindex="4" href="javascript:;">Bank Transfers</a></li>
		<li><a tabindex="5" href="javascript:;">Withdrawals</a></li>
		<li><a tabindex="6" href="javascript:;">Deposits</a></li>
		<li><a tabindex="7" href="javascript:;">Bills</a></li>
		<li class="divider"></li>
		<li><a tabindex="all" href="javascript:;">All Transactions</a></li>
	</ul>
</li>
 **/
	this.initVariedSource = function (params) {
		// The html container
		var html = '', title = '';
		for ( var i in params.sources ) {
			// Ensure default title and url
			html += '<li';
			
			// Set the predefined active url
			if ( typeof(params['sources'][i]['active']) !== "undefined" ) {
				html += ' class="active"';
				title = params['sources'][i]['text'];
				currentSource = params['sources'][i]['url'];
			}
			
			// Set the html
			if ( typeof(params['sources'][i]['divider']) !== "undefined" ) {
				html += ' class="divider"></li>';
			}
			else {
				if ( title == '' ) {
					title = params['sources'][i]['text'];
					currentSource = params['sources'][i]['url'];
				}
				
				html += '><a tab-url="'+params['sources'][i]['url']+'" href="javascript:;">'+params['sources'][i]['text']+'</a></li>';
			}
		}
		
		// Get tooltip 
		var tooltip = '';
		if ( typeof(params.tooltip) !== "undefined" )
			tooltip = params.tooltip;
		
		// Create the panel
		$('ul.breadcrumb').append('<li class="pull-right dashboard-report-li dropdown"><div id="dashboard-select-button" class="dashboard-report-range-container no-text-shadow tooltips dropdown-toggle" data-placement="top" data-original-title="'+tooltip+'" role="button" data-toggle="dropdown"><i class="icon-reorder icon-large"></i><span>'+title+'</span> <b class="caret"></b> </div><ul class="dropdown-menu pull-right data-table-filter" role="menu" aria-labelledby="dLabel">'+html+'</ul></li>');
		
		// Initialise the dropdown
		$('.dropdown-toggle').dropdown();	
		
		// Set click events
		$('.data-table-filter a').click(function(){
			$('.data-table-filter li').removeClass('active');
			$(this).parent().addClass('active');
			
			currentSource = $(this).attr('tab-url');	
			$('#dashboard-select-button span').html( $(this).html() );
			oTable.fnDraw();
		});
		
		// Initialise the datatable
		initDataTable(params.table);
	}
};
