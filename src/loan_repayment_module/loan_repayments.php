<?
set_title('Loan Repayments');
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Payments',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Payments & Bills' ),
		array ( 'text'=>'Payments' )
	)
));

set_css(array(
  'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css'
  // 'assets/plugins/bootstrap-datepicker/css/datepicker.css'
));

// set_js(array(
 // 'assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js'
 // 'assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js'
// )); 
?>

<div class="widget">
  <div class="widget-title">
    <h4><i class="icon-file"></i> Add Payments From a CSV file</h4>
    <div class="actions">
      <a href="http://oriems.com/gtel-mobile/assets/csv/loan_repayments.csv" class="btn btn-small btn-info">Download Template <i class="icon-download"></i></a>
    </div>
  </div>
  <div class="widget-body form">
    <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
      <div class="row-fluid">  
        <div class="control-group">
          <label class="control-label">Upload a CSV file: </label>
          <div class="controls">
            <div class="fileupload fileupload-new" data-provides="fileupload">
              <div class="input-append">
                <div class="uneditable-input">
                   <i class="icon-file fileupload-exists"></i> 
                   <span class="fileupload-preview"></span>
                </div>
                <span class="btn btn-file">
                <span class="fileupload-new">Select file</span>
                <span class="fileupload-exists">Change</span>
                <input type="file" class="default" name="csv" accept=".csv" />
                </span>
                <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- hidden fields -->
      <input type="hidden" name="action" value="upload_csv"/>

      <div class="form-actions">
        <?php viewActions($_GET['num'], $_SESSION['role_id']); ?>
      </div>
    </form>
  </div>
</div>

<div class="widget">
  <div class="widget-title">
    <h4><i class="icon-money"></i> Payments</h4>
    <span class="actions">
      <!-- <a href="#add_types" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-search"></i> Search</a> -->
    </span>
  </div>
  <div class="widget-body">  
    <?php
      if (isset($_SESSION['upload_csv'])) {
        echo $_SESSION['upload_csv'];
        unset($_SESSION['upload_csv']);
      }
    ?>  
    <table id="table1" class="table table-bordered">
      <thead>
      <tr>
        <th>Upload#</th>
        <th>Upload Date</th>
        <th>Total Count</th>
        <th>Report</th>
        <th>Uploader</th>
        </tr>
      </thead>
      <tbody>
        <?
          $distinctQuery = "SELECT lrp.*, CONCAT(m.surname,' ',m.firstname,' ',m.middlename) AS full_name FROM loan_repayment_uploads lrp 
          LEFT JOIN masterfile m ON m.mf_id = lrp.upload_mf_id";
          $resultId = run_query($distinctQuery);
          while($row = get_row_data($resultId)){
        ?>
        <tr>
         <td><?=$row['repayment_upload_id']; ?></td>
         <td><?=$row['upload_date']; ?></td>
         <td><?=$row['repayment_count']; ?></td>
         <td><?=$row['error_report']; ?></td>
         <td><?=$row['full_name']; ?></td>                                
        </tr>
        <? } ?>
      </tbody>
    </table>
    <div class="clearfix"></div>
  </div>
</div>