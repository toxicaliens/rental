<!-- BEGIN OVERVIEW STATISTIC BARS-->
<div class="row-fluid stats-overview-cont">
	<div class="span4 responsive" data-tablet="span4" data-desktop="span4">
		<div class="stats-overview block clearfix">
			<div class="display stat ok huge">
				<!-- <span class="line-chart">0,0,0,0,0,0,0,0,0,0</span> -->
				<!-- <div class="percent">0%</div> -->
			</div>
			<div class="details">
				<div class="title">Total Policies</div>
				<div class="numbers">
					<?php echo $period->countRecords('afyapoa_file'); ?>
				</div>
			</div>
			<div class="progress progress-info">
				<div class="bar" style="width: 0%"></div>
			</div>
		</div>
	</div>
	<div class="span4 responsive" data-tablet="span4" data-desktop="span4">
		<div class="stats-overview block clearfix">
			<div class="display stat good huge">
				<!-- <span class="line-chart">0,0,0,0,0,0,0,0,0,0,0,0,0,0,0</span> -->
				<!-- <div class="percent">0%</div> -->
			</div>
			<div class="details">
				<div class="title">Total Loans</div>
				<div class="numbers">
					<?php echo $period->countRecords('afyapoa_file'); ?>
				</div>
				<div class="progress progress-warning">
					<div class="bar" style="width: 0%"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="span4 responsive" data-tablet="span4" data-desktop="span4">
		<div class="stats-overview block clearfix">
			<div class="display stat good huge">
				<!-- <span class="line-chart">0,0,0,0,0,0,0,0,0,0,0,0,0,0,0</span> -->
				<!-- <div class="percent">0%</div> -->
			</div>
			<div class="details">
				<div class="title">Total Agents</div>
				<div class="numbers">
					<?php echo $period->countAgentsType('afyapoa_agent', 'customer_id'); ?>
				</div>
				<div class="progress progress-warning">
					<div class="bar" style="width: 0%"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid stats-overview-cont">
	<div class="span4 responsive" data-tablet="span4" data-desktop="span4">
		<div class="stats-overview block clearfix">
			<div class="display stat ok huge">
				<!-- <span class="line-chart">0,0,0,0,0,0,0,0,0,0</span> -->
				<!-- <div class="percent">0%</div> -->
			</div>
			<div class="details">
				<div class="title">Total Super Champions</div>
				<div class="numbers">
					<?php echo $period->countAgentsType('afyapoa_agent', 'super_champ_customer_id'); ?>
				</div>
			</div>
			<div class="progress progress-info">
				<div class="bar" style="width: 0%"></div>
			</div>
		</div>
	</div>
	<div class="span4 responsive" data-tablet="span4" data-desktop="span4">
		<div class="stats-overview block clearfix">
			<div class="display stat good huge">
				<!-- <span class="line-chart">0,0,0,0,0,0,0,0,0,0,0,0,0,0,0</span> -->
				<!-- <div class="percent">0%</div> -->
			</div>
			<div class="details">
				<div class="title">Total ROs</div>
				<div class="numbers">
					<?php echo $period->countAgentsType('afyapoa_agent', 'ro_customer_id'); ?>
				</div>
				<div class="progress progress-warning">
					<div class="bar" style="width: 0%"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="span4 responsive" data-tablet="span4" data-desktop="span4">
		<div class="stats-overview block clearfix">
			<div class="display stat good huge">
				<!-- <span class="line-chart">0,0,0,0,0,0,0,0,0,0,0,0,0,0,0</span> -->
				<!-- <div class="percent">0%</div> -->
			</div>
			<div class="details">
				<div class="title">Total Champions</div>
				<div class="numbers">
					<?php echo $period->countAgentsType('afyapoa_agent', 'champ_customer_id'); ?>
				</div>
				<div class="progress progress-warning">
					<div class="bar" style="width: 0%"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END OVERVIEW STATISTIC BARS-->



        
            
            
            
<script>
		jQuery(document).ready(function() {		
			//App.init(); // initlayout and core plugins
			Index.init();
			//Index.initJQVMAP(); // init index page's custom scripts
			Index.initKnowElements(); // init circle stats(knob elements)
			Index.initPeityElements(); // init pierty elements
			Index.initCalendar(); // init index page's custom scripts
			//Index.initCharts(); // init index page's custom scripts
			//Index.initChat();
			Index.initDashboardDaterange();
			// Index.initIntro();
		});
	</script>