var chartCtrl = new function () {
	function showTooltip(x, y, contents) {
		$('<div id="tooltip">' + contents + '</div>').css({
			position: 'absolute',
			display: 'none',
			top: y + 5,
			border: '1px solid #333',
			padding: '4px',
			color: '#fff',
			'border-radius': '3px',
			'background-color': '#333',
			opacity: 0.80
		}).appendTo("body").fadeIn(200);
		
		if ( (x+$('#tooltip').width()+25) > $(document).width() )
			x = x - 15 - $('#tooltip').width();
		else x = x + 15;
		
		$('#tooltip').css({ left: x });
	}
	
	function bindHover(chart, dateRange=false) {
		chart.bind("plothover", function (event, pos, item) {
			$("#x").text(pos.x.toFixed(2));
			$("#y").text(pos.y.toFixed(2));

			if (item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;

					$("#tooltip").remove();
					var x = item.datapoint[0].toFixed(2), y = item.datapoint[1].toFixed(2);
					if ( dateRange ) {
						var today = new Date(item.datapoint[0]);
						var dd = today.getDate();
						var mm = today.getMonth()+1; //January is 0!
						var yyyy = today.getFullYear();
						
						if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} 
						x = yyyy+'-'+mm+'-'+dd;
					}

					showTooltip(item.pageX, item.pageY, item.series.label + ": " + x + " = " + y);
				}
			} else {
				$("#tooltip").remove();
				previousPoint = null;
			}
		});
	}
	
	function plotChart(params, input) {
		if ( typeof(input) === 'undefined' ) input = null;
		App.blockUI(jQuery(".widget-body"));
		
		$.ajax({
			type:'POST', dataType:"json", url:params.source, data:input,
			success: function(response) {
				if ( typeof(params.chart) === "string" ) {
					$.plot($(params.chart), response, params.options);
				}
				else {
					for ( var i in params.chart )
						$.plot($(params['chart'][i]), [response[i]], params.options);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert("textStatus: "+textStatus+"\nerrorThrown: "+errorThrown);
			},
			complete: function(jqXHR, textStatus) {
				App.unblockUI(jQuery(".widget-body"));
			}
		});
	}
	
	function setLabels(params) {
		if ( typeof(params.xaxisLabel) !== "undefined" ) {
			$('<div>' + params.xaxisLabel + '</div>').css({
				position: 'absolute',
				'text-align': 'center',
				'font-size': '12px',
				bottom: '3px',
				left: 0,
				right: 0
			}).appendTo($(params.chart).parent());
		}
		
		if ( typeof(params.yaxisLabel) !== "undefined" ) {
			$('<div>' + params.yaxisLabel + '</div>').css({
				position: 'absolute',
				'text-align': 'center',
				'font-size': '12px',
				top: '50%',
				left: '0px',
				transform: 'rotate(-90deg)',
				'-o-transform': 'rotate(-90deg)',
				'-ms-transform': 'rotate(-90deg)',
				'-moz-transform': 'rotate(-90deg)',
				'-webkit-transform':  'rotate(-90deg)',
				'transform-origin': '0 0',
				'-o-transform-origin': '0 0',
				'-ms-transform-origin': '0 0',
				'-moz-transform-origin': '0 0',
				'-webkit-transform-origin': '0 0'
			}).appendTo($(params.chart).parent());
		}
	}
	
	function initDateRange(params) {
		// Append the date range
		$('ul.breadcrumb').append('<li class="pull-right dashboard-report-li"><div id="dashboard-report-range" class="dashboard-report-range-container no-text-shadow tooltips" data-placement="top" data-original-title="Change dashboard date range"><i class="icon-calendar icon-large"></i><span></span> <b class="caret"></b></div></li>');
		
		// Attach the appropriate range
		$('#dashboard-report-range').daterangepicker({
			ranges: {
				'Last 7 Days': [Date.today().add({days:-6}), 'today'],
				'Last 30 Days': [Date.today().add({days:-29}), 'today'],
				'This Month': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
				'Last Month': [
					Date.today().moveToFirstDayOfMonth().add({ months: -1 }),
					Date.today().moveToFirstDayOfMonth().add({ days: -1 })
				]
			},
			opens: 'left',
			format: 'MM/dd/yyyy',
			separator: ' to ',
			startDate: Date.today().add({ days: -29 }),
			endDate: Date.today(),
			minDate: '01/01/2012',
			maxDate: '12/31/2014',
			locale: {
				applyLabel: 'Submit',
				fromLabel: 'From',
				toLabel: 'To',
				customRangeLabel: 'Custom Range',
				daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
				monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
				firstDay: 1
			},
			showWeekNumbers: true,
			buttonClasses: ['btn-danger']
		},
		
		function (start, end) {
			// Update function
			var input = [];
			input.push({ name:"from", value:start.toString('yyyy-MM-dd') });
			input.push({ name:"to", value:end.toString('yyyy-MM-dd') });
			plotChart(params, input);
			
			$('#dashboard-report-range span').html(start.toString('MMMM d, yyyy') + ' - ' + end.toString('MMMM d, yyyy'));
		});
		
		
		$('#dashboard-report-range').show();
		$('#dashboard-report-range span').html(
			Date.today()
				.add({days: -29})
				.toString('MMMM d, yyyy') + ' - ' + Date.today().toString('MMMM d, yyyy')
		);
	}
	
	this.init = function(params) {
		// Set options
		params['options'] = {
			series: {
				lines: { show: true },
				points: { show: true },
				shadowSize: 2
			},
			grid: {
				hoverable: true,
				clickable: true,
				tickColor: "#eee",
				borderWidth: 0
			}
		};
		
		// Plot the chart
		plotChart(params);
		
		// Attach the tooltip
		bindHover($(params.chart));
		
		// Labels
		setLabels(params);
	}
	
	this.initWithRange = function(params) {
		// Set options
		params['options'] = {
			series: {
				lines: { show: true },
				points: { show: true },
				shadowSize: 2
			},
			grid: {
				hoverable: true,
				clickable: true,
				tickColor: "#eee",
				borderWidth: 0
			},
			xaxis: {
				mode: "time"
			}
		};
		
		// Plot the chart
		plotChart(params);
		
		// Labels and the tooltip
		if ( typeof(params.chart) === "string" ) {
			setLabels(params);
			bindHover($(params.chart), true);
		}
		else {
			for ( var i in params.chart ) {
				var p = {};
				p['chart'] = params['chart'][i];
	
				if ( typeof(params['xaxisLabel'][i]) !== "undefined" )
					p['xaxisLabel'] = params['xaxisLabel'][i];
				if ( typeof(params['yaxisLabel'][i]) !== "undefined" )
					p['yaxisLabel'] = params['yaxisLabel'][i];
				
				setLabels(p);
				bindHover($(p.chart), true);
			}
		}
		
		// Set the date range
		initDateRange(params);
	}
};
