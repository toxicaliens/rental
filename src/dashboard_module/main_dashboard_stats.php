<!-- BEGIN OVERVIEW STATISTIC BARS-->
<div class="row-fluid stats-overview-cont">
	<div class="span4 responsive" data-tablet="span4" data-desktop="span4">
		<div class="stats-overview block clearfix">
			<div class="display stat ok huge">
				<!-- <span class="line-chart">0,0,0,0,0,0,0,0,0,0</span> -->
				<!-- <div class="percent">0%</div> -->
			</div>
			<div class="details">
				<div class="title">Total Plots</div>
				<div class="numbers">
					<?php echo $period->countReferalRecords('referrals'); ?>
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
				<div class="title">Totals No. of Landlords</div>
				<div class="numbers">
					<?php echo $period->countOpenTicketsRecords('maintenance_ticket','0'); ?>
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
				<div class="title">Totals No. of Tenants</div>
				<div class="numbers">
					<!-- <?//php echo $period->countActiveInsuranceRecords('gtel_insurance','TRUE'); ?> -->
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
				<div class="title">Active Contractors</div>
				<div class="numbers">
					<?php echo $period->countCustomerRecords('masterfile','client'); ?>
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
				<div class="title">Total No. of Property Managers</div>
				<div class="numbers">
					<?php echo $period->countActiveCustomerRecords('customer_account','TRUE'); ?>
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
				<div class="title">Total Bills</div>
				<div class="numbers">
					<?php echo $period->countBillRecords('customer_bills'); ?>
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
				<div class="title">Pending Bills</div>
				<div class="numbers">
					<?php echo $period->countPendingBillsRecords('customer_bills','0'); ?>
				</div>
			</div>
			<div class="progress progress-info">
				<div class="bar" style="width: 0%"></div>
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