<?php
   include_once "dashboard_library.php";
    set_layout('dashboard_layout.php');
    
    $from_date = date("2011-m-01");
    $to_date = date("Y-m-d");
    
    $period = new DashboardStats($from_date,$to_date);
?>
<!-- BEGIN OVERVIEW STATISTIC BARS-->
<div id="page" class="dashboard">
	<?php include 'main_dashboard_stats.php'; ?>
	<input type="hidden" id="processor_page" value="src/dashboard_module/dashboard_elements.php"/>
</div>



