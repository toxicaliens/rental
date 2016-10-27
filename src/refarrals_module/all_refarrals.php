<?php
include_once('src/models/SupportTickets.php');
include_once('src/models/Referrals.php');

$Support = new SupportTickets;
$referral = new Referrals;

set_layout("dt-layout.php", array(
	'pageSubTitle' => 'All Referrals',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Referrals' ),
		array ( 'text'=>'All Referrals' )
	)
	
));

?>

<div class="widget">
  <div class="widget-title"><h4><i class="icon-money"></i> Filters</h4>
    <span class="tools">
      <a href="javascript::void();"><i class="<?php echo (!isset($_POST['date_range'])) ? 'icon-chevron-up': 'icon-chevron-down'; ?>"></i></a>
    </span>
  </div>
  <div class="widget-body form" <?php echo (!isset($_POST['date_range'])) ? 'style="display: none;"': ''; ?>">
    <form action="" method="post" class="form-horizontal">
      <div class="row-fluid">
        <div class="span6">
          <div class="control-group">
            <label for="date_range" class="control-label">Date Range:</label>
            <div class="controls">
              <div class="input-prepend input-append">
                 <span class="add-on"><i class="icon-calendar"></i></span>
                 <input type="text" name="date_range" class="m-wrap m-ctrl-medium date-range" required value="<?php echo (isset($_POST['date_range'])) ? $_POST['date_range'] : ''; ?>" />
                 <button class="btn"><i class="icon-search"></i></button>
              </div>             
            </div>
          </div>
        </div>
      </div>
    </form>    
  </div>
</div>	

<div class="widget">
	<div class="widget-title"><h4><i class="icon-comments-alt"></i> All Referrals</h4></div>
	<div class="widget-body form">
	<?
			if(isset($_SESSION['referrals'])){
			echo $_SESSION['referrals'];
			unset($_SESSION['referrals']);
		     }
		?>
    <table id="table1" style="width: 100%" class="table table-bordered">
 		<thead>
			<tr>
			  	<th>ID#</th>
				<th>Referral Phone No</th>
				<th>Referral Id NO</th>
				<th>Referral Date</th>
				<th>Referral Names</th> 
			</tr>
 		</thead>
 	<tbody>
 	<?php
 			$date_range = (isset($_POST['date_range'])) ? $referral->getReferralsFromAndToDates($_POST['date_range']) : '';
    		$condition = (isset($_POST['date_range'])) ? $referral->filterReferrals($date_range[0], $date_range[1]) : '';
 			
			$result = $Support->AllReferrals($condition);
			while ($rows = get_row_data($result)) {
		?>
		<tr>
			<td><?=$rows['referrals_id']; ?></td>
			<td><?=$rows['referral_phone_number']; ?></td>
			<td><?=$rows['referral_id_no']; ?></td>
			<td><?=$rows['referral_date']; ?></td>
			<td><?=$rows['referral_names']; ?></td>	
		</tr>
	<?php
		}   
	?>
  </tbody>
</table>
<div class="clearfix"></div>
</div>
</div>